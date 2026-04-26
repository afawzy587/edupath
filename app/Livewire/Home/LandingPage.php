<?php

declare(strict_types=1);

namespace App\Livewire\Home;

use App\Models\Setting;
use Livewire\Component;
use App\Traits\UploadFileTrait;
class LandingPage extends Component
{
    use UploadFileTrait;
    public function render()
    {
        $videoUrl = null;
        $videoPath = Setting::get('landing_page_video');
        if ($videoPath) {
            $videoUrl = $this->getFileUrl($videoPath);
        }

        return view('livewire.home.landing-page', [
            'videoUrl' => $videoUrl,
        ])
            ->layout('layouts.app');
    }
}
