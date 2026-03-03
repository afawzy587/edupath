<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use Livewire\Component;

class CategoryCreate extends Component
{
    public function render()
    {
        return view('livewire.admin.category-create')
            ->layout('layouts.app')
            ->layoutData(['pageName' => 'admin-categories']);
    }
}
