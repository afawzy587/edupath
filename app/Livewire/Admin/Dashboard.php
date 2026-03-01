<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Answer;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Course;
use App\Models\CourseTranslation;
use App\Models\CourseTraslation;
use App\Models\Question;
use App\Models\QuestionTranslation;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'students' => User::query()->where('type', 'student')->count(),
            'admins' => User::query()->where('type', 'admin')->count(),
            'courses' => Course::query()->count(),
            'active_courses' => Course::query()->where('active', true)->count(),
            'categories' => Category::query()->count(),
            'questions' => Question::query()->count(),
            'active_questions' => Question::query()->where('active', true)->count(),
            'answers' => Answer::query()->count(),
        ];

        $recentStudents = User::query()
            ->where('type', 'student')
            ->latest()
            ->take(6)
            ->get(['id', 'name', 'email', 'school', 'created_at']);

        $topCourses = Course::query()
            ->with(['translations', 'category.translations'])
            ->withCount('students')
            ->orderByDesc('students_count')
            ->take(5)
            ->get();

        $inactiveCourses = Course::query()->where('active', false)->count();

        $modelStats = [
            ['key' => 'users', 'count' => User::query()->count()],
            ['key' => 'courses', 'count' => Course::query()->count()],
            ['key' => 'categories', 'count' => Category::query()->count()],
            ['key' => 'questions', 'count' => Question::query()->count()],
            ['key' => 'answers', 'count' => Answer::query()->count()],
            ['key' => 'course_translations', 'count' => CourseTranslation::query()->count()],
            ['key' => 'course_translations_legacy', 'count' => CategoryTranslation::query()->count()],
            ['key' => 'category_translations', 'count' => CategoryTranslation::query()->count()],
            ['key' => 'question_translations', 'count' => QuestionTranslation::query()->count()],
        ];

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recentStudents' => $recentStudents,
            'topCourses' => $topCourses,
            'inactiveCourses' => $inactiveCourses,
            'modelStats' => $modelStats,
        ])
            ->layout('layouts.app')
            ->layoutData(['pageName' => 'admin-dashboard']);
    }
}
