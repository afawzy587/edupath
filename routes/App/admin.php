<?php

declare(strict_types=1);

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Login;
use App\Livewire\Admin\Categories;
use App\Livewire\Admin\CategoryCreate;
use App\Livewire\Admin\CategoryEdit;
use App\Livewire\Admin\CourseCreate;
use App\Livewire\Admin\CourseEdit;
use App\Livewire\Admin\QuestionCreate;
use App\Livewire\Admin\QuestionEdit;
use App\Livewire\Admin\Questions;
use App\Livewire\Admin\UsersReport;
use App\Http\Controllers\Admin\UserExportController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\QuestionController;
use App\Livewire\Admin\Courses;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', Login::class)
    ->middleware('guest')
    ->name('admin.login');

Route::get('/dashboard', Dashboard::class)
    ->middleware(['auth', 'admin'])
    ->name('dashboard');

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'admin'],
], function (): void {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/courses', Courses::class)->name('courses.index');
    Route::get('/courses/create', CourseCreate::class)->name('courses.create');
    Route::get('/courses/{course}/edit', CourseEdit::class)->name('courses.edit');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');

    Route::get('/categories', Categories::class)->name('categories.index');
    Route::get('/categories/create', CategoryCreate::class)->name('categories.create');
    Route::get('/categories/{category}/edit', CategoryEdit::class)->name('categories.edit');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/questions', Questions::class)->name('questions.index');
    Route::get('/questions/create', QuestionCreate::class)->name('questions.create');
    Route::get('/questions/{question}/edit', QuestionEdit::class)->name('questions.edit');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

    Route::get('/reports/{type}', UsersReport::class)->name('reports.show');
    Route::get('/reports/{type}/export', UserExportController::class)->name('reports.export');
});
