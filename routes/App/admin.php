<?php

declare(strict_types=1);

use App\Livewire\Admin\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', Dashboard::class)
    ->middleware(['auth', 'admin'])
    ->name('dashboard');

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'admin'],
], function (): void {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
});
