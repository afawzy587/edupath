<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    public function login()
    {
        $credentials = $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $this->remember)) {
            $this->addError('email', __('auth.failed'));
            return;
        }

        session()->regenerate();

        $user = auth()->user();
        if (! $user || ! $user->isAdmin()) {
            Auth::logout();
            $this->addError('email', __('auth.failed'));
            return;
        }

        return redirect()->intended(route('admin.dashboard'));
    }

    public function render()
    {
        return view('livewire.admin.login')
            ->layout('layouts.app');
    }
}
