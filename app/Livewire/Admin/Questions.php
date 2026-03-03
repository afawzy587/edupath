<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Question;
use Livewire\Component;

class Questions extends Component
{
    public function render()
    {
        $questions = Question::query()
            ->with(['translations', 'category.translations'])
            ->latest()
            ->paginate(10);

        return view('livewire.admin.questions', [
            'questions' => $questions,
        ])
            ->layout('layouts.app')
            ->layoutData(['pageName' => 'admin-questions']);
    }
}
