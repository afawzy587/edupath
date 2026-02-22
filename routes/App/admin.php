<?php

declare(strict_types=1);

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Login;
use App\Livewire\Admin\CourseCreate;
use App\Livewire\Admin\CourseEdit;
use App\Http\Controllers\Admin\CourseController;
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
});
