<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Setting;
use App\Traits\UploadFileTrait;
use Livewire\Component;

class LandingPageSettings extends Component
{
    use UploadFileTrait;

    public ?string $currentVideo = null;

    public function mount(): void
    {
        $this->currentVideo = Setting::get('landing_page_video');
    }

    public function deleteVideo(): void
    {
        if ($this->currentVideo) {
            $this->deleteFile($this->currentVideo, 'public');
            Setting::set('landing_page_video', null);
            $this->currentVideo = null;
        }

        $this->dispatch('notify', message: __('admin.landing_page.delete_success'));
    }

    public function render()
    {
        return view('livewire.admin.landing-page-settings')
            ->layout('layouts.app')
            ->layoutData(['pageName' => 'admin-landing-page-settings']);
    }
}

