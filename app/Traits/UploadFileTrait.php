<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadFileTrait
{
    /**
     * Upload a single file to the given disk and directory.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $directory
     * @param  string|null  $disk
     * @return string|null  The stored file path or null on failure.
     */
    public function uploadFile(UploadedFile $file, string $directory = 'uploads', ?string $disk = null): ?string
    {
        $disk = $disk ?? config('filesystems.default');
        try {
            $extension = $file->guessExtension()
                ?? $file->extension()
                ?? $file->getClientOriginalExtension();
            $filename = Str::uuid() . '.' . $extension;

            $path = $file->storeAs($directory, $filename, $disk);
            return $path;
        } catch (\Throwable $e) {
            logger()->channel('uploads')->error('UploadFileTrait@uploadFile', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
                'disk' => $disk,
            ]);
            return null;
        }
    }

    /**
     * Delete a stored file.
     *
     * @param  string  $filePath
     * @param  string|null  $disk
     * @return bool
     */
    public function deleteFile(string $filePath, ?string $disk = null): bool
    {
        $disk = $disk ?? config('filesystems.default');

        try {
            return Storage::disk($disk)->exists($filePath)
                ? Storage::disk($disk)->delete($filePath)
                : false;
        } catch (\Throwable $e) {
            logger()->channel('uploads')->error('UploadFileTrait@deleteFile', [
                'error' => $e->getMessage(),
                'filePath' => $filePath,
                'disk' => $disk,
            ]);
            return false;
        }
    }

    /**
     * Get the public URL for a stored file.
     *
     * @param  string|null  $filePath
     * @param  string|null  $disk
     * @return string
     */
    public function getFileUrl(?string $filePath = null, ?string $disk = null): ?string
    {
        $disk = $disk ?? config('filesystems.default');
        return $filePath ? Storage::disk($disk)->url($filePath) : null;
    }
}
