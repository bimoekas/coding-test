<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;


class FileUploader
{
    /**
     * Upload file
     *
     * @param \Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[]|array|null $files
     * @param string $folder
     *
     * @return string[]|string|null
     */
    public function upload($files, $folder = 'uploads')
    {
        if (is_null($files)) {
            return null;
        }

        if (is_array($files)) {
            return collect($files)->map(fn ($file) => $this->uploadFile($file, $folder))->toArray();
        }

        return $this->uploadFile($files, $folder);
    }

    /**
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     */
    private function uploadFile($file, $folder): string
    {
        $savedFilePath = Storage::putFile($folder, $file, 'public');

        return Storage::url($savedFilePath);
    }
}
