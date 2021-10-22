<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait ImageHandler{

    /**
     * Save an image and return the path
     *
     * @param UploadedFile $image
     * @param string $file
     * @return string
     */
    protected function saveImage(UploadedFile $image , string $file): string
    {
        $path = $image->store('public/images/' . $file);
        return str_replace('public/' , 'storage/' , $path);
    }

    /**
     * Delete an image
     *
     * @param string $avatar
     */
    protected function deleteOld(string $avatar){
        $oldPath = preg_replace('/.*storage/' , 'public' ,$avatar);
        Storage::delete($oldPath);
    }
}
