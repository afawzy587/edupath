<?php

declare(strict_types=1);

namespace App\Livewire\Student;

use App\Models\Category;
use App\Models\Course;
use App\Models\ExploreInteraction;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Explore extends Component
{
    public ?int $activeCategoryId = null;
    public ?string $pageName = 'explore';

    public function setCategory(?int $categoryId = null): void
    {
        $this->activeCategoryId = $categoryId;
    }


    public function setPageName(?string $pageName = null): void
    {
        $this->pageName = $pageName;
    }

    public function toggleLike(int $courseId): void
    {
        $user = auth()->user();
        if (! $user) {
            return;
        }

        $isLiked = $user->likedCourses()
            ->where('course_id', $courseId)
            ->exists();

        if ($isLiked) {
            $user->likedCourses()->detach($courseId);
        } else {
            $user->likedCourses()->attach($courseId);
        }
    }

    public function trackView(int $courseId): void
    {
        $user = auth()->user();
        if (! $user) {
            return;
        }

        $courseExists = Course::query()
            ->whereKey($courseId)
            ->where('active', true)
            ->whereNotNull('video')
            ->where('video', '!=', '')
            ->exists();

        if (! $courseExists) {
            return;
        }

        $interaction = ExploreInteraction::query()->firstOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $courseId,
            ],
            [
                'views_count' => 0,
                'watch_seconds' => 0,
            ]
        );

        $interaction->increment('views_count');
    }

    public function trackWatchTime(int $courseId, int $seconds): void
    {
        $user = auth()->user();
        if (! $user) {
            return;
        }

        $safeSeconds = max(1, min($seconds, 300));

        $courseExists = Course::query()
            ->whereKey($courseId)
            ->where('active', true)
            ->whereNotNull('video')
            ->where('video', '!=', '')
            ->exists();

        if (! $courseExists) {
            return;
        }

        $interaction = ExploreInteraction::query()->firstOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $courseId,
            ],
            [
                'views_count' => 0,
                'watch_seconds' => 0,
            ]
        );

        $interaction->increment('watch_seconds', $safeSeconds);
    }

    public function render()
    {
        $categories = Category::query()
            ->where('active', true)
            ->whereHas('courses', function ($query): void {
                $query->where('active', true)
                    ->whereNotNull('video')
                    ->where('video', '!=', '');
            })
            ->with('translations')
            ->orderBy('id')
            ->get();

        $courses = Course::query()
            ->where('active', true)
            ->whereNotNull('video')
            ->where('video', '!=', '')
            ->when(
                $this->activeCategoryId,
                fn($query) => $query->where('courses.category_id', $this->activeCategoryId)
            )
            ->with(['translations', 'category.translations'])
            ->withCount(['reviews', 'likes'])
            ->latest()
            ->get();

        $likedCourseIds = [];
        $userId = auth()->id();
        if ($userId && $courses->isNotEmpty()) {
            $likedCourseIds = DB::table('course_likes')
                ->where('user_id', $userId)
                ->whereIn('course_id', $courses->pluck('id'))
                ->pluck('course_id')
                ->all();
        }

        return view('livewire.student.explore', [
            'categories' => $categories,
            'courses' => $courses,
            'likedCourseIds' => $likedCourseIds,
        ])
            ->layout('layouts.app')
            ->layoutData(['pageName' => 'explore']);
    }
}
