<?php

use App\Livewire\Actions\Logout;
use App\Livewire\Assessments\Questions;
use App\Livewire\Hobbies\Questions as HobbiesQuestions;
use App\Livewire\Home\LandingPage;
use App\Livewire\Student\Login;
use App\Livewire\Student\Register;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingPage::class)->name('landing-page');
Route::get('/assessments', Questions::class)->name('assessments');
Route::get('/hobbies', HobbiesQuestions::class)->name('hobbies');
Route::group(['prefix' => 'student', 'as' => 'student.'], function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::post('/logout', Logout::class)->name('logout');
});
