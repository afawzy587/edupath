<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Traits\HashedId;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use UploadFileTrait;
    public function index()
    {
        $courses = Course::query()
            ->with(['translations', 'category.translations'])
            ->latest()
            ->paginate(15);

        if (view()->exists('admin.courses.index')) {
            return view('admin.courses.index', compact('courses'));
        }

        return response()->json($courses);
    }

    public function create()
    {
        $categories = Category::query()
            ->with('translations')
            ->orderBy('id')
            ->get();

        if (view()->exists('admin.courses.create')) {
            return view('admin.courses.create', compact('categories'));
        }

        return response()->json([
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'instructor_name' => ['required', 'string', 'max:255'],
            'active' => ['sometimes', 'boolean'],
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],
            'description_en' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadFile($request->file('image'), 'courses', 'public');
        }

        $course = Course::query()->create([
            'category_id' => $data['category_id'],
            'instructor_name' => $data['instructor_name'],
            'active' => (bool) ($data['active'] ?? true),
        ]);

        $course->translateOrNew('en')->name = $data['name_en'];
        $course->translateOrNew('en')->description = $data['description_en'] ?? null;
        $course->translateOrNew('en')->image = $imagePath ?? null;

        $course->translateOrNew('ar')->name = $data['name_ar'];
        $course->translateOrNew('ar')->description = $data['description_ar'] ?? null;
        $course->translateOrNew('ar')->image = $imagePath ?? null;

        $course->save();

        if ($request->wantsJson()) {
            return response()->json($course->load(['translations', 'category.translations']), 201);
        }

        return redirect()
            ->route('admin.courses.index')
            ->with('success', __('courses.created_success'));
    }

    public function show(Course $course)
    {
        $course->load(['translations', 'category.translations']);

        if (view()->exists('admin.courses.show')) {
            return view('admin.courses.show', compact('course'));
        }

        return response()->json($course);
    }

    public function edit(Course $course)
    {
        $course->load('translations');
        $categories = Category::query()
            ->with('translations')
            ->orderBy('id')
            ->get();

        if (view()->exists('admin.courses.edit')) {
            return view('admin.courses.edit', compact('course', 'categories'));
        }

        return response()->json([
            'course' => $course,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'instructor_name' => ['required', 'string', 'max:255'],
            'active' => ['sometimes', 'boolean'],
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],
            'description_en' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = $course->translate('en')?->image ?? null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadFile($request->file('image'), 'courses', 'public');
        }

        $course->fill([
            'category_id' => $data['category_id'],
            'instructor_name' => $data['instructor_name'],
            'active' => (bool) ($data['active'] ?? $course->active),
        ]);

        $course->translateOrNew('en')->name = $data['name_en'];
        $course->translateOrNew('en')->description = $data['description_en'] ?? null;
        $course->translateOrNew('en')->image = $imagePath;

        $course->translateOrNew('ar')->name = $data['name_ar'];
        $course->translateOrNew('ar')->description = $data['description_ar'] ?? null;
        $course->translateOrNew('ar')->image = $imagePath;

        $course->save();

        if ($request->wantsJson()) {
            return response()->json($course->load(['translations', 'category.translations']));
        }

        return redirect()
            ->route('admin.courses.index')
            ->with('success', __('courses.updated_success'));
    }

    public function destroy(Request $request, Course $course)
    {
        $course->delete();

        if ($request->wantsJson() || ! view()->exists('admin.courses.index')) {
            return response()->json(['message' => __('courses.deleted_success')]);
        }

        return redirect()
            ->route('admin.courses.index')
            ->with('success', __('courses.deleted_success'));
    }
}
