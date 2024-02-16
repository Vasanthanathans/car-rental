<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;
use App\Models\Banners;

class AdminHelper
{
    public static function checkPermission(string $string)
    {
        $adminPermission = json_decode(Session::get('permissions'));
        if (in_array($string, $adminPermission)) {

            return true;
        } else {
            return false;
        }
    }

    public static function getBannerInfo(Int $id)
    {
        $banner = Banners::where('id', $id)->first();
        return $banner;
    }
}
