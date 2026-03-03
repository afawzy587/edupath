<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;

class CategoryEdit extends Component
{
    public Category $category;

    public function mount(Category $category): void
    {
        $this->category = $category->load('translations');
    }

    public function render()
    {
        return view('livewire.admin.category-edit', [
            'category' => $this->category,
        ])
            ->layout('layouts.app')
            ->layoutData(['pageName' => 'admin-categories']);
    }
}
