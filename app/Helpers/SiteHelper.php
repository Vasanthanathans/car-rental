<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;
use App\Models\Banners;

class SiteHelper
{
    public static function getBannerInfo(Int $id){
        $banner = Banners::where('id', $id)->first();
        if($banner !=null){
            return $banner->image;
        }else{
            return '';
        }
    }
}
