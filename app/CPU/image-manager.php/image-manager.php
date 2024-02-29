<?php

namespace App\CPU;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageManager
{
    public static function upload(string $dir, string $format, $image = null)
    {
        $imageName = 'def.png';
        if ($image) {
            // Check if it's a valid image by reading its dimensions
            $imageInfo = is_string($image) ? getimagesizefromstring(base64_decode($image)) : true;

            if ($imageInfo !== false) {
                $imageName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;

                if (!Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->makeDirectory($dir);
                }

                if (is_file($image)) {
                    Storage::disk('public')->put($dir . $imageName, file_get_contents($image));
                } elseif(is_string($image)) {
                    Storage::disk('public')->put($dir . $imageName, base64_decode($image));
                }
            }
        }

        return $imageName;
    }

    public static function update(string $dir, $old_image, string $format, $image = null)
    {
        if (Storage::disk('public')->exists($dir . $old_image)) {
            Storage::disk('public')->delete($dir . $old_image);
        }
        $imageName = ImageManager::upload($dir, $format, $image);
        return $imageName;
    }

    public static function delete($full_path)
    {
        // if (Storage::disk('public')->exists($full_path)) {
        //     Storage::disk('public')->delete($full_path);
        // }

        // return [
        //     'success' => 1,
        //     'message' => 'Removed successfully !'
        // ];

    }
}
