<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Course;
use Livewire\Component;

class CourseEdit extends Component
{
    public Course $course;

    public function mount(Course $course): void
    {
        $this->course = $course->load('translations');
    }

    public function render()
    {
        $categories = Category::query()
            ->with('translations')
            ->orderBy('id')
            ->get();

        return view('livewire.admin.course-edit', [
            'course' => $this->course,
            'categories' => $categories,
        ])
            ->layout('layouts.app')
            ->layoutData(['pageName' => 'admin-courses']);
    }
}
