<?php

declare(strict_types=1);

namespace App\Livewire\Student;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $school = '';
    public $gender = 'male';
    public $age = 'nine';

    protected $rules = [
        'name' => 'nullable|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/'],
        'school' => 'nullable|string|max:255',
        'gender' => 'required|in:male,female',
        'age' => 'required|in:nine,eleven',
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name ?: null,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'school' => $this->school ?: null,
            'gender' => $this->gender,
            'age' => $this->age,
        ]);

        Auth::login($user);

        return redirect()
            ->route('landing-page')
            ->with('success', 'Registration successful.');
    }

    public function render()
    {
        return view('livewire.student.auth.⚡register')
            ->layout('layouts.app');
    }
}
