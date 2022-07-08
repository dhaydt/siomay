<?php

namespace App\CPU;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class imageManager
{
    public static function update(string $dir, $old_image, string $format, $image = null)
    {
        $old_image = $old_image['value'];
        if (Storage::disk('public')->exists($dir.$old_image)) {
            Storage::disk('public')->delete($dir.$old_image);
        }
        $imageName = imageManager::upload($dir, $format, $image);

        return $imageName;
    }

    public static function upload(string $dir, string $format, $image = null)
    {
        if ($image != null) {
            $imageName = Carbon::now()->toDateString().'-'.uniqid().'.'.$format;
            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
            }
            Storage::disk('public')->put($dir, $image);
        } else {
            $imageName = 'def.png';
        }

        return $image;
    }
}
