<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;

class CourseCreate extends Component
{
    public function render()
    {
        $categories = Category::query()
            ->with('translations')
            ->orderBy('id')
            ->get();

        return view('livewire.admin.course-create', [
            'categories' => $categories,
        ])
            ->layout('layouts.app')
            ->layoutData(['pageName' => 'admin-courses']);
    }
}
