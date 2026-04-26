<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingPageSettingController extends Controller
{
    use UploadFileTrait;

    public function update(Request $request)
    {
        $request->validate([
            'video' => ['nullable', 'file', 'mimetypes:video/mp4,video/quicktime,video/webm,video/ogg', 'max:51200'],
        ]);

        if ($request->hasFile('video')) {
            $existingVideo = Setting::get('landing_page_video');
            if ($existingVideo) {
                $this->deleteFile($existingVideo, 'public');
            }

            $videoPath = $this->uploadFile($request->file('video'), 'landing-page/videos', 'public');
            Setting::set('landing_page_video', $videoPath);
        }

        return redirect()
            ->route('admin.landing-page-settings')
            ->with('success', __('admin.landing_page.upload_success'));
    }

    public function destroy()
    {
        $existingVideo = Setting::get('landing_page_video');
        if ($existingVideo) {
            $this->deleteFile($existingVideo, 'public');
            Setting::set('landing_page_video', null);
        }

        return redirect()
            ->route('admin.landing-page-settings')
            ->with('success', __('admin.landing_page.delete_success'));
    }
}

