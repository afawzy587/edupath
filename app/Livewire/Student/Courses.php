<?php

declare(strict_types=1);

namespace App\Livewire\Student;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Course;
use Livewire\Component;

class Courses extends Component
{
    public ?int $activeCategoryId = null;

    public ?string $pageName = 'courses';

    public function setCategory(?int $categoryId = null): void
    {
        $this->activeCategoryId = $categoryId;
    }

    public function signIn(int $courseId)
    {
        $course = Course::query()
            ->whereKey($courseId)
            ->where('active', true)
            ->first();

        if (! $course) {
            return;
        }

        $user = auth()->user();
        if (! $user) {
            return;
        }

        $user->courses()->syncWithoutDetaching([$course->id]);

        session()->flash('success', __('courses.add_success'));

        return redirect()->route('student.courses.show', $course);
    }

    public function render()
    {
        $categories = Category::query()
            ->where('active', true)
            ->with('translations')
            ->get();

        $coursesQuery = Course::query()
            ->where('active', true)
            ->when(
                $this->activeCategoryId,
                fn($query) => $query->where('courses.category_id', $this->activeCategoryId)
            )
            ->with(['translations', 'category.translations']);

        $enrolledCourseIds = [];
        $user = auth()->user();
        if ($user) {
            $enrolledCourseIds = $user->courses()->pluck('courses.id')->all();

            $categoryRatings = Answer::query()
                ->selectRaw('questions.category_id, AVG(answers.value) as avg_rating, (AVG(answers.value) / 5) * 100 as rating_percent')
                ->join('questions', 'questions.id', '=', 'answers.question_id')
                ->where('answers.student_id', $user->id)
                ->whereNotNull('questions.category_id')
                ->where('questions.active', true)
                ->groupBy('questions.category_id');

            $coursesQuery
                ->leftJoinSub($categoryRatings, 'category_ratings', function ($join): void {
                    $join->on('courses.category_id', '=', 'category_ratings.category_id');
                })
                ->orderByDesc('category_ratings.rating_percent')
                ->orderBy('courses.id')
                ->selectRaw('courses.*, COALESCE(category_ratings.rating_percent, 0) as rating_percent');
        }

        $courses = $coursesQuery->get();
        return view('livewire.student.courses', [
            'categories' => $categories,
            'courses' => $courses,
            'enrolledCourseIds' => $enrolledCourseIds,
        ])
            ->layout('layouts.app')
            ->layoutData(['pageName' => 'courses']);
    }
}

