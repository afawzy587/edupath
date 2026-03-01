<?php

declare(strict_types=1);

namespace App\Livewire\Student;

use App\Models\Answer;
use App\Models\Category;
use App\Models\ExploreInteraction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Profile extends Component
{
    public string $comparisonTab = 'interests';
    public ?string $pageName = 'profile';

    public function setComparisonTab(string $tab): void
    {
        if (! in_array($tab, ['interests', 'hobbies'], true)) {
            return;
        }

        $this->comparisonTab = $tab;
    }

    public function render()
    {
        if (! auth()->check()) {
            return redirect()->route('student.login');
        }

        $user = auth()->user();
        $categoryNames = Category::query()
            ->where('active', true)
            ->with('translations')
            ->orderBy('id')
            ->get()
            ->pluck('name', 'id');

        $hollandScores = $this->buildAssessmentScores('assessments', (int) $user->id, $categoryNames);
        $hobbiesScores = $this->buildAssessmentScores('hobbies', (int) $user->id, $categoryNames);

        $behavior = $this->buildBehaviorAnalytics((int) $user->id, $categoryNames);
        $courseSignals = $this->buildCourseSignals((int) $user->id);
        $exploreSignals = $this->buildExploreSignals((int) $user->id);

        $activeBlueScores = $this->comparisonTab === 'interests' ? $hollandScores : $hobbiesScores;
        $comparisonRows = $this->buildComparisonRows($activeBlueScores, $courseSignals, $exploreSignals, $categoryNames);

        $topHolland = $hollandScores->first();
        $topHobbies = $hobbiesScores->first();

        return view('livewire.student.profile', [
            'user' => $user,
            'hollandScores' => $hollandScores,
            'hobbiesScores' => $hobbiesScores,
            'hollandHexData' => $hollandScores->take(6)->values(),
            'hobbyTopThree' => $hobbiesScores->take(3)->values(),
            'summary' => [
                'top_interest' => $topHolland,
                'top_hobby' => $topHobbies,
            ],
            'behavior' => $behavior,
            'comparisonRows' => $comparisonRows,
        ])
            ->layout('layouts.app')
            ->layoutData(['pageName' => 'profile']);
    }

    private function buildAssessmentScores(string $type, int $userId, Collection $categoryNames): Collection
    {
        return Answer::query()
            ->join('questions', 'questions.id', '=', 'answers.question_id')
            ->where('answers.student_id', $userId)
            ->where('questions.type', $type)
            ->whereNotNull('questions.category_id')
            ->selectRaw('questions.category_id, AVG(answers.value) as avg_value, COUNT(*) as answers_count')
            ->groupBy('questions.category_id')
            ->get()
            ->map(function ($row) use ($categoryNames): array {
                $percent = (int) round((((float) $row->avg_value) / 5) * 100);
                return [
                    'category_id' => (int) $row->category_id,
                    'name' => $categoryNames->get((int) $row->category_id, __('profile.unknown_domain')),
                    'percent' => max(0, min(100, $percent)),
                    'avg_value' => (float) $row->avg_value,
                    'answers_count' => (int) $row->answers_count,
                ];
            })
            ->sortByDesc('percent')
            ->values();
    }

    private function buildBehaviorAnalytics(int $userId, Collection $categoryNames): array
    {
        $interactions = ExploreInteraction::query()
            ->join('courses', 'courses.id', '=', 'explore_interactions.course_id')
            ->where('explore_interactions.user_id', $userId)
            ->whereNotNull('courses.category_id')
            ->selectRaw('courses.category_id, SUM(explore_interactions.views_count) as total_views, SUM(explore_interactions.watch_seconds) as total_watch_seconds')
            ->groupBy('courses.category_id')
            ->get();

        $likesByCategory = DB::table('course_likes')
            ->join('courses', 'courses.id', '=', 'course_likes.course_id')
            ->where('course_likes.user_id', $userId)
            ->whereNotNull('courses.category_id')
            ->selectRaw('courses.category_id, COUNT(*) as total_likes')
            ->groupBy('courses.category_id')
            ->get()
            ->keyBy('category_id');

        $viewsMap = $interactions->mapWithKeys(fn($row) => [(int) $row->category_id => (int) $row->total_views]);
        $watchMap = $interactions->mapWithKeys(fn($row) => [(int) $row->category_id => (int) $row->total_watch_seconds]);
        $likesMap = $likesByCategory->mapWithKeys(fn($row, $categoryId) => [(int) $categoryId => (int) $row->total_likes]);

        $totalViews = (int) $viewsMap->sum();
        $totalWatchSeconds = (int) $watchMap->sum();
        $totalLikes = (int) $likesMap->sum();

        $mostWatchedCategoryId = $viewsMap->sortDesc()->keys()->first();
        $mostTimeCategoryId = $watchMap->sortDesc()->keys()->first();
        $mostLikedCategoryId = $likesMap->sortDesc()->keys()->first();

        $viewsChart = $viewsMap
            ->sortDesc()
            ->take(8)
            ->map(fn($value, $categoryId) => [
                'name' => $categoryNames->get((int) $categoryId, __('profile.unknown_domain')),
                'value' => (int) $value,
            ])
            ->values();

        $watchChart = $watchMap
            ->sortDesc()
            ->take(8)
            ->map(fn($value, $categoryId) => [
                'name' => $categoryNames->get((int) $categoryId, __('profile.unknown_domain')),
                'value' => (int) round(((int) $value) / 60),
            ])
            ->values();

        return [
            'total_views' => $totalViews,
            'total_likes' => $totalLikes,
            'total_watch_minutes' => (int) round($totalWatchSeconds / 60),
            'most_watched' => $mostWatchedCategoryId ? $categoryNames->get((int) $mostWatchedCategoryId) : null,
            'most_time_spent' => $mostTimeCategoryId ? $categoryNames->get((int) $mostTimeCategoryId) : null,
            'most_liked' => $mostLikedCategoryId ? $categoryNames->get((int) $mostLikedCategoryId) : null,
            'views_chart' => $viewsChart,
            'watch_chart' => $watchChart,
        ];
    }

    private function buildCourseSignals(int $userId): Collection
    {
        $enrolled = DB::table('course_user')
            ->join('courses', 'courses.id', '=', 'course_user.course_id')
            ->where('course_user.user_id', $userId)
            ->whereNotNull('courses.category_id')
            ->selectRaw('courses.category_id, COUNT(*) as enrolled_count')
            ->groupBy('courses.category_id')
            ->get()
            ->keyBy('category_id');

        $completed = DB::table('reviews')
            ->join('courses', 'courses.id', '=', 'reviews.course_id')
            ->where('reviews.user_id', $userId)
            ->whereNotNull('courses.category_id')
            ->selectRaw('courses.category_id, COUNT(*) as completed_count')
            ->groupBy('courses.category_id')
            ->get()
            ->keyBy('category_id');

        $categoryIds = collect($enrolled->keys())->merge($completed->keys())->unique()->values();
        $raw = $categoryIds->mapWithKeys(function ($categoryId) use ($enrolled, $completed): array {
            $enrolledCount = (int) ($enrolled[$categoryId]->enrolled_count ?? 0);
            $completedCount = (int) ($completed[$categoryId]->completed_count ?? 0);
            return [(int) $categoryId => ($enrolledCount * 2) + ($completedCount * 3)];
        });

        $max = (int) $raw->max();

        return $raw->mapWithKeys(function ($score, $categoryId) use ($max, $enrolled, $completed): array {
            $enrolledCount = (int) ($enrolled[$categoryId]->enrolled_count ?? 0);
            $completedCount = (int) ($completed[$categoryId]->completed_count ?? 0);
            $percent = $max > 0 ? (int) round(((int) $score / $max) * 100) : 0;

            return [(int) $categoryId => [
                'percent' => $percent,
                'enrolled_count' => $enrolledCount,
                'completed_count' => $completedCount,
            ]];
        });
    }

    private function buildExploreSignals(int $userId): Collection
    {
        $views = ExploreInteraction::query()
            ->join('courses', 'courses.id', '=', 'explore_interactions.course_id')
            ->where('explore_interactions.user_id', $userId)
            ->whereNotNull('courses.category_id')
            ->selectRaw('courses.category_id, SUM(explore_interactions.views_count) as views_count')
            ->groupBy('courses.category_id')
            ->get()
            ->keyBy('category_id');

        $likes = DB::table('course_likes')
            ->join('courses', 'courses.id', '=', 'course_likes.course_id')
            ->where('course_likes.user_id', $userId)
            ->whereNotNull('courses.category_id')
            ->selectRaw('courses.category_id, COUNT(*) as likes_count')
            ->groupBy('courses.category_id')
            ->get()
            ->keyBy('category_id');

        $categoryIds = collect($views->keys())->merge($likes->keys())->unique()->values();
        $raw = $categoryIds->mapWithKeys(function ($categoryId) use ($views, $likes): array {
            $viewsCount = (int) ($views[$categoryId]->views_count ?? 0);
            $likesCount = (int) ($likes[$categoryId]->likes_count ?? 0);
            return [(int) $categoryId => $viewsCount + ($likesCount * 4)];
        });

        $max = (int) $raw->max();

        return $raw->mapWithKeys(function ($score, $categoryId) use ($max, $views, $likes): array {
            $viewsCount = (int) ($views[$categoryId]->views_count ?? 0);
            $likesCount = (int) ($likes[$categoryId]->likes_count ?? 0);
            $percent = $max > 0 ? (int) round(((int) $score / $max) * 100) : 0;

            return [(int) $categoryId => [
                'percent' => $percent,
                'views_count' => $viewsCount,
                'likes_count' => $likesCount,
            ]];
        });
    }

    private function buildComparisonRows(
        Collection $blueScores,
        Collection $courseSignals,
        Collection $exploreSignals,
        Collection $categoryNames
    ): Collection {
        return $blueScores
            ->map(function (array $score) use ($courseSignals, $exploreSignals, $categoryNames): array {
                $categoryId = (int) $score['category_id'];
                $course = $courseSignals->get($categoryId, ['percent' => 0, 'enrolled_count' => 0, 'completed_count' => 0]);
                $explore = $exploreSignals->get($categoryId, ['percent' => 0, 'views_count' => 0, 'likes_count' => 0]);

                return [
                    'name' => $categoryNames->get($categoryId, __('profile.unknown_domain')),
                    'blue_percent' => (int) $score['percent'],
                    'green_percent' => (int) ($course['percent'] ?? 0),
                    'yellow_percent' => (int) ($explore['percent'] ?? 0),
                    'enrolled_count' => (int) ($course['enrolled_count'] ?? 0),
                    'completed_count' => (int) ($course['completed_count'] ?? 0),
                    'views_count' => (int) ($explore['views_count'] ?? 0),
                    'likes_count' => (int) ($explore['likes_count'] ?? 0),
                ];
            })
            ->values();
    }
}
