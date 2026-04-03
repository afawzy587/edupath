<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->with('translations')
            ->latest()
            ->paginate(15);

        if (view()->exists('admin.categories.index')) {
            return view('admin.categories.index', compact('categories'));
        }

        return response()->json($categories);
    }

    public function create()
    {
        if (view()->exists('admin.categories.create')) {
            return view('admin.categories.create');
        }

        return response()->json();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'active' => ['sometimes', 'boolean'],
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],
        ]);

        $category = Category::query()->create([
            'active' => (bool) ($data['active'] ?? true),
        ]);

        $category->translateOrNew('en')->name = $data['name_en'];
        $category->translateOrNew('ar')->name = $data['name_ar'];
        $category->save();

        if ($request->wantsJson()) {
            return response()->json($category->load('translations'), 201);
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', __('categories.created_success'));
    }

    public function edit(Category $category)
    {
        $category->load('translations');

        if (view()->exists('admin.categories.edit')) {
            return view('admin.categories.edit', compact('category'));
        }

        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'active' => ['sometimes', 'boolean'],
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],
        ]);

        $category->fill([
            'active' => (bool) ($data['active'] ?? $category->active),
        ]);

        $category->translateOrNew('en')->name = $data['name_en'];
        $category->translateOrNew('ar')->name = $data['name_ar'];
        $category->save();

        if ($request->wantsJson()) {
            return response()->json($category->load('translations'));
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', __('categories.updated_success'));
    }

    public function destroy(Request $request, Category $category)
    {
        $category->delete();

        if ($request->wantsJson() || ! view()->exists('admin.categories.index')) {
            return response()->json(['message' => __('categories.deleted_success')]);
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', __('categories.deleted_success'));
    }
}
