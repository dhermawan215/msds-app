<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait LogoUpload
{
    /**
     * @method store image logo
     * @return string path
     */
    public function storeLogo($file, $folder = null, $fileName = null)
    {
        $newFileName = !is_null($fileName) ? $fileName : Str::random(10);
        $timeStamp = date('Ymdis');
        $pathFileName = $timeStamp . '-' . $newFileName . '.' . $file->getClientOriginalExtension();
        return $file->move($folder, $pathFileName);
    }
    /**
     * @method delete image logo
     * @param string path
     * @return bool
     */
    public function deleteLogo($path)
    {
        return unlink($path);
    }
}
