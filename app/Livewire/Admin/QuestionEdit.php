<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Question;
use Livewire\Component;

class QuestionEdit extends Component
{
    public Question $question;

    public function mount(Question $question): void
    {
        $this->question = $question->load('translations');
    }

    public function render()
    {
        $categories = Category::query()
            ->with('translations')
            ->orderBy('id')
            ->get();

        return view('livewire.admin.question-edit', [
            'question' => $this->question,
            'categories' => $categories,
        ])
            ->layout('layouts.app')
            ->layoutData(['pageName' => 'admin-questions']);
    }
}
