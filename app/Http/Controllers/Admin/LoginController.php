<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubAdminModel;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //
    function login()
    {

        Artisan::call('storage:link');

        if (Session::get('admin_id')) {
            return redirect('admin/index');
        }
        return  view('Admin.login');
    }

    function checklogin(Request $req)
    {
        $data = SubAdminModel::where('email', $req->email)->first();

        if ($data && $req->email == $data['email'] && Hash::check($req->password, $data['password'])) {

            $req->session()->put('user_name', $data['fullName']);
            $req->session()->put('email', $data['email']);
            $req->session()->put('admin_id', $data['id']);
            $req->session()->put('permissions', $data['permissions']);
            return  redirect('admin/index');
        } else {
            Session::flash('message', 'Wrong credentials !');
            return redirect()->route('admin');
        }
    }


    function logout()
    {

        session()->pull('user_name');
        session()->pull('email');
        session()->pull('admin_id');
        session()->pull('permissions');
        return  redirect(url('/admin'));
    }
}
