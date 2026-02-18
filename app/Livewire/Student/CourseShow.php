<?php

declare(strict_types=1);

namespace App\Livewire\Student;

use App\Models\Answer;
use App\Models\Course;
use Livewire\Component;

class CourseShow extends Component
{

    public Course $course;
    public int $matchPercent = 0;

    public function mount(Course $course)
    {
        if (! $course->active) {
            return redirect()->route('student.courses');
        }

        $this->course = $course;
        $this->matchPercent = $this->calculateMatchPercent($course);
    }

    public function getDurationProperty(): int
    {
        return 3 + ($this->course->id % 6);
    }

    public function render()
    {
        return view('livewire.student.course-show')
            ->layout('layouts.app')
            ->layoutData(['pageName' => 'courses']);
    }

    private function calculateMatchPercent(Course $course): int
    {
        $user = auth()->user();
        if (! $user || ! $course->category_id) {
            return 0;
        }

        $ratingPercent = Answer::query()
            ->selectRaw('(AVG(answers.value) / 5) * 100 as rating_percent')
            ->join('questions', 'questions.id', '=', 'answers.question_id')
            ->where('answers.student_id', $user->id)
            ->where('questions.category_id', $course->category_id)
            ->where('questions.active', true)
            ->value('rating_percent');

        $ratingPercent = is_null($ratingPercent) ? 0 : (int) round((float) $ratingPercent);

        return max(0, min(100, $ratingPercent));
    }
}
