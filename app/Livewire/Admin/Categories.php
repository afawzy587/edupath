<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;

class Categories extends Component
{
    public function render()
    {
        $categories = Category::query()
            ->with('translations')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.categories', [
            'categories' => $categories,
        ])
            ->layout('layouts.app')
            ->layoutData(['pageName' => 'admin-categories']);
    }
}
