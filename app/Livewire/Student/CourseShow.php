<?php

declare(strict_types=1);

namespace App\Livewire\Student;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Review;
use Livewire\Component;

class CourseShow extends Component
{
    public Course $course;
    public int $matchPercent = 0;
    public string $reviewBody = '';
    public ?Review $userReview = null;
    public $reviews = [];
    public $relatedVideos = [];

    public function mount(Course $course)
    {
        if (! $course->active) {
            return redirect()->route('student.courses');
        }

        $this->course = $course;
        $this->matchPercent = $this->calculateMatchPercent($course);
        $this->loadReviews();
        $this->loadRelatedVideos();
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

    public function saveReview(): void
    {
        $user = auth()->user();
        if (! $user) {
            return;
        }

        $data = $this->validate([
            'reviewBody' => 'required|string|max:1000',
        ]);

        $review = Review::updateOrCreate(
            [
                'course_id' => $this->course->id,
                'user_id' => $user->id,
            ],
            [
                'body' => $data['reviewBody'],
            ]
        );
        $messageKey = $review->wasRecentlyCreated ? 'courses.review_created' : 'courses.review_updated';
        session()->flash('success', __($messageKey));

        $this->userReview = $review;
        $this->reviewBody = $review->body;
        $this->loadReviews();
    }

    public function deleteReview(): void
    {
        $user = auth()->user();
        if (! $user) {
            return;
        }

        Review::query()
            ->where('course_id', $this->course->id)
            ->where('user_id', $user->id)
            ->delete();
        session()->flash('success', __('courses.review_deleted'));

        $this->userReview = null;
        $this->reviewBody = '';
        $this->loadReviews();
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

    private function loadReviews(): void
    {
        $this->reviews = Review::query()
            ->with('user')
            ->where('course_id', $this->course->id)
            ->latest()
            ->get();

        $userId = auth()->id();
        $this->userReview = $userId
            ? $this->reviews->firstWhere('user_id', $userId)
            : null;

        if ($this->userReview) {
            $this->reviewBody = $this->userReview->body;
        }
    }

    private function loadRelatedVideos(): void
    {
        if (! $this->course->category_id) {
            $this->relatedVideos = collect();
            return;
        }

        $locale = app()->getLocale();

        $this->relatedVideos = Course::query()
            ->with('translations')
            ->where('category_id', $this->course->category_id)
            ->whereKeyNot($this->course->id)
            ->whereHas('translations', function ($query) use ($locale): void {
                $query->where('locale', $locale)
                    ->whereNotNull('video');
            })
            ->latest()
            ->get();
    }
}
