<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::query()
            ->with(['translations', 'category.translations'])
            ->latest()
            ->paginate(15);

        if (view()->exists('admin.questions.index')) {
            return view('admin.questions.index', compact('questions'));
        }

        return response()->json($questions);
    }

    public function create()
    {
        $categories = Category::query()
            ->with('translations')
            ->orderBy('id')
            ->get();

        if (view()->exists('admin.questions.create')) {
            return view('admin.questions.create', compact('categories'));
        }

        return response()->json([
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'type' => ['required', Rule::in(['assessments', 'hobbies'])],
            'order' => ['nullable', 'integer', 'min:0'],
            'active' => ['sometimes', 'boolean'],
            'title_en' => ['required', 'string', 'max:255'],
            'title_ar' => ['required', 'string', 'max:255'],
        ]);

        $question = Question::query()->create([
            'category_id' => $data['category_id'] ?? null,
            'type' => $data['type'],
            'order' => $data['order'] ?? 0,
            'active' => (bool) ($data['active'] ?? true),
        ]);

        $question->translateOrNew('en')->title = $data['title_en'];
        $question->translateOrNew('ar')->title = $data['title_ar'];
        $question->save();

        if ($request->wantsJson()) {
            return response()->json($question->load(['translations', 'category.translations']), 201);
        }

        return redirect()
            ->route('admin.questions.index')
            ->with('success', __('questions.created_success'));
    }

    public function edit(Question $question)
    {
        $question->load('translations');
        $categories = Category::query()
            ->with('translations')
            ->orderBy('id')
            ->get();

        if (view()->exists('admin.questions.edit')) {
            return view('admin.questions.edit', compact('question', 'categories'));
        }

        return response()->json([
            'question' => $question,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $data = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'type' => ['required', Rule::in(['assessments', 'hobbies'])],
            'order' => ['nullable', 'integer', 'min:0'],
            'active' => ['sometimes', 'boolean'],
            'title_en' => ['required', 'string', 'max:255'],
            'title_ar' => ['required', 'string', 'max:255'],
        ]);

        $question->fill([
            'category_id' => $data['category_id'] ?? null,
            'type' => $data['type'],
            'order' => $data['order'] ?? $question->order,
            'active' => (bool) ($data['active'] ?? $question->active),
        ]);

        $question->translateOrNew('en')->title = $data['title_en'];
        $question->translateOrNew('ar')->title = $data['title_ar'];
        $question->save();

        if ($request->wantsJson()) {
            return response()->json($question->load(['translations', 'category.translations']));
        }

        return redirect()
            ->route('admin.questions.index')
            ->with('success', __('questions.updated_success'));
    }

    public function destroy(Request $request, Question $question)
    {
        $question->delete();

        if ($request->wantsJson() || ! view()->exists('admin.questions.index')) {
            return response()->json(['message' => __('questions.deleted_success')]);
        }

        return redirect()
            ->route('admin.questions.index')
            ->with('success', __('questions.deleted_success'));
    }
}
