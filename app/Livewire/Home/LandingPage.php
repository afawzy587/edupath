<?php

declare(strict_types=1);

namespace App\Livewire\Home;

use Livewire\Component;

class LandingPage extends Component
{
    public function render()
    {
        return view('livewire.home.landing-page')
            ->layout('layouts.app');
    }

}
