<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

class LandingController extends Controller
{

    public function index()
    {

        return  view('Site.index');
    }

    public function about()
    {
        return view('Site.about');
    }
    public function services()
    {
        return view('Site.services');
    }
    public function pricing()
    {
        return view('Site.pricing');
    }
    public function vehicle()
    {
        return view('Site.vehicle');
    }
    public function blog()
    {
        return view('Site.blog');
    }
    public function contact()
    {
        return view('Site.contact');
    }

    public function vehicleinfo(string $vehicleId)
    {

        if ($vehicleId != '' && $vehicleId != null) {
            return view('Site.vehicleInfo');
        } else {
            redirect()->back();
        }
    }
}
