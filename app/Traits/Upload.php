<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;


trait Upload
{
    /**
     * Section file for action upload
     */
    public function createFile($section = true, $folder, $file, $oldFile = null)
    {
        if ($section) {
            $filename = $this->storeFile($folder, $file);
        } else {
            if ($oldFile) {
                $this->deleteFile($folder, $file);
            }
            $filename = $this->storeFile($folder, $file);
        }

        return basename($filename);
    }

    /**
     * Delete file from storage
     */
    public function deleteFile($folder, $file)
    {
        return Storage::disk('public')->delete($folder . '/' . $file);
    }

    /**
     * Save file into storage
     */
    public function storeFile($folder, $file)
    {
        return Storage::disk('public')->put($folder, $file);
    }
}
