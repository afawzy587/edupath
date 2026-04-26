<?php

declare(strict_types=1);

namespace App\Livewire\Home;

use App\Models\Setting;
use Livewire\Component;

class LandingPage extends Component
{
    public function render()
    {
        $videoUrl = null;
        $videoPath = Setting::get('landing_page_video');
        if ($videoPath) {
            $videoUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($videoPath);
        }

        return view('livewire.home.landing-page', [
            'videoUrl' => $videoUrl,
        ])
            ->layout('layouts.app');
    }
}
