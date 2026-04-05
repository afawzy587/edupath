<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Question;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersReport extends Component
{
    use WithPagination;

    public string $type = 'hobbies';
    public string $search = '';
    public int $perPage = 10;

    public function mount(string $type): void
    {
        abort_unless(in_array($type, ['hobbies', 'assessments'], true), 404);

        $this->type = $type;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $questions = Question::query()
            ->with('translations')
            ->where('type', $this->type)
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        $questionIds = $questions->pluck('id');

        $students = User::query()
            ->where('type', 'student')
            ->when($this->search !== '', fn($query) => $query->where('name', 'like', '%'.$this->search.'%'))
            ->with([
                'answers' => fn($query) => $query->whereIn('question_id', $questionIds),
            ])
            ->orderBy('name')
            ->orderBy('id')
            ->paginate($this->perPage);

        $students->setCollection($students->getCollection()->map(function (User $student) use ($questions): array {
            $answersByQuestion = $student->answers->pluck('value', 'question_id');

            return [
                'student' => $student,
                'answers' => $questions->mapWithKeys(
                    fn($question) => [$question->id => $answersByQuestion->get($question->id, '—')]
                )->all(),
            ];
        }));

        return view('livewire.admin.users-report', [
            'students' => $students,
            'questions' => $questions,
            'reportType' => $this->type,
        ])
            ->layout('layouts.app')
            ->layoutData(['pageName' => 'admin-users-report-'.$this->type]);
    }

    public function getTypeLabelProperty(): string
    {
        return $this->type === 'assessments'
            ? __('admin.reports.types.assessments')
            : __('admin.reports.types.hobbies');
    }

    public function getAltTypeProperty(): string
    {
        return $this->type === 'assessments' ? 'hobbies' : 'assessments';
    }

    public function getAltTypeLabelProperty(): string
    {
        return $this->type === 'assessments'
            ? __('admin.reports.types.hobbies')
            : __('admin.reports.types.assessments');
    }
}
