<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Course;
use Livewire\Component;

class Courses extends Component
{
    public function render()
    {
        $courses = Course::query()
            ->with(['translations', 'category.translations'])
            ->latest()
            ->paginate(10);

        return view('livewire.admin.courses', [
            'courses' => $courses,
        ])
            ->layout('layouts.app')
            ->layoutData(['pageName' => 'admin-courses']);
    }
}
