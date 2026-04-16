<?php

declare(strict_types=1);

namespace App\Livewire\Hobbies;

use App\Models\Answer;
use App\Models\Question;
use Livewire\Component;

class Questions extends Component
{
    public array $questions = [];
    public array $answers = [];
    public array $answerRows = [];

    public int $page = 1;
    public int $perPage = 10;
    public int $total = 0;

    public string $pageName = 'hobbies';

    public function mount(): void
    {
        $this->loadAnswers();
        $this->loadQuestions();
        $this->loadAnswerRows();
    }

    public function selectOption(int $questionId, int $value): void
    {
        $this->answers[$questionId] = $value;
        $this->saveAnswer($questionId, $value);
        $this->resetErrorBag('page');
    }

    public function nextPage(): void
    {
        if (! $this->validateCurrentPage()) {
            return;
        }

        if ($this->page * $this->perPage >= $this->total) {
            return;
        }

        $this->page++;
        $this->loadQuestions();
    }

    public function previousPage(): void
    {
        if ($this->page <= 1) {
            return;
        }

        $this->page--;
        $this->loadQuestions();
    }

    public function getCurrentCountProperty(): int
    {
        if ($this->total === 0) {
            return 0;
        }

        return min(count(array_filter($this->answers, fn($value) => $value !== null)), $this->total);
    }

    public function getProgressPercentProperty(): float
    {
        if ($this->total === 0) {
            return 0;
        }

        return ($this->currentCount / $this->total) * 100;
    }

    public function getIsCompletedProperty(): bool
    {
        return $this->currentCount >= $this->total;
    }

    public function saveHobbies(): void
    {
        if (! $this->validateCurrentPage()) {
            return;
        }

        $this->dispatch('hobbies-saved');
    }

    private function loadQuestions(): void
    {
        $baseQuery = Question::query()
            ->with('translations')
            ->where('type', 'hobbies')
            ->where('active', true)
            ->orderBy('order')
            ->orderBy('id');

        $this->total = (clone $baseQuery)->count();

        $this->questions = (clone $baseQuery)
            ->forPage($this->page, $this->perPage)
            ->get()
            ->map(fn($question) => [
                'id' => $question->id,
                'title' => $question->title ?? '',
            ])
            ->toArray();
    }

    private function loadAnswers(): void
    {
        $studentId = auth()->id();

        if (! $studentId) {
            return;
        }

        $answers = Answer::query()
            ->where('student_id', $studentId)
            ->whereHas('question', fn($query) => $query->where('type', 'hobbies'))
            ->pluck('value', 'question_id')
            ->toArray();

        $this->answers = array_map('intval', $answers);
    }

    private function loadAnswerRows(): void
    {
        $studentId = auth()->id();

        if (! $studentId) {
            $this->answerRows = [];
            return;
        }

        $this->answerRows = Answer::query()
            ->with('question')
            ->where('student_id', $studentId)
            ->whereHas('question', fn($query) => $query->where('type', 'hobbies'))
            ->orderBy('question_id')
            ->get()
            ->map(fn($answer) => [
                'question_id' => $answer->question_id,
                'question_title' => $answer->question?->title ?? '',
                'value' => (int) $answer->value,
            ])
            ->toArray();
    }

    private function saveAnswer(int $questionId, int $value): void
    {
        $studentId = auth()->id();

        if (! $studentId) {
            return;
        }

        Answer::updateOrCreate(
            [
                'student_id' => $studentId,
                'question_id' => $questionId,
            ],
            [
                'value' => $value,
            ]
        );
    }

    private function validateCurrentPage(): bool
    {
        $missing = collect($this->questions)
            ->pluck('id')
            ->filter(fn($questionId) => ! array_key_exists($questionId, $this->answers));

        if ($missing->isNotEmpty()) {
            $this->addError('page', __('hobbies.validation_required'));
            return false;
        }

        return true;
    }

    public function render()
    {
        return view('livewire.hobbies.questions')
            ->layout('layouts.app');
    }
}
