<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin;
use App\Models\Banners;
use App\Models\Constants;
use App\Models\GlobalFunction;
use App\Models\GlobalSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\AdminSettings;
use Illuminate\Support\Facades\Storage;
use App\Helpers\AdminHelper;


class SettingsController extends Controller
{
    function uploadFileGivePath(Request $request)
    {
        $rules = [
            'file' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }
        $path = GlobalFunction::saveFileAndGivePath($request->file);

        return response()->json([
            'status' => true,
            'message' => 'file uploaded successfully',
            'path' => $path
        ]);
    }

    function updatePaymentSettings(Request $request)
    {
        $settings = GlobalSettings::first();
        $settings->payment_gateway = $request->payment_gateway;

        $settings->stripe_secret = $request->stripe_secret;
        $settings->stripe_publishable_key = $request->stripe_publishable_key;
        $settings->stripe_currency_code = $request->stripe_currency_code;

        $settings->razorpay_key = $request->razorpay_key;
        $settings->razorpay_currency_code = $request->razorpay_currency_code;

        $settings->paystack_secret_key = $request->paystack_secret_key;
        $settings->paystack_public_key = $request->paystack_public_key;
        $settings->paystack_currency_code = $request->paystack_currency_code;

        $settings->paypal_client_id = $request->paypal_client_id;
        $settings->paypal_secret_key = $request->paypal_secret_key;
        $settings->paypal_currency_code = $request->paypal_currency_code;

        $settings->flutterwave_public_key = $request->flutterwave_public_key;
        $settings->flutterwave_encryption_key = $request->flutterwave_encryption_key;
        $settings->flutterwave_secret_key = $request->flutterwave_secret_key;
        $settings->flutterwave_currency_code = $request->flutterwave_currency_code;

        $settings->save();

        return GlobalFunction::sendSimpleResponse(true, 'value changed successfully');
    }

    function changePassword(Request $request)
    {
        $admin = Admin::where('user_type', 1)->first();
        if ($admin->user_password == $request->old_password) {
            $admin->user_password = $request->new_password;
            $admin->save();
            return response()->json(['status' => true, 'message' => 'Password changed successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Incorrect Old password !']);
        }
    }
    function updateGlobalSettings(Request $request)
    {
        $settings = GlobalSettings::first();
        $settings->currency = $request->currency;
        $settings->comission = $request->comission;
        $settings->min_amount_payout_salon = $request->min_amount_payout_salon;
        $settings->max_order_at_once = $request->max_order_at_once;
        $settings->support_email = $request->support_email;
        $settings->save();

        return GlobalFunction::sendSimpleResponse(true, 'value changed successfully');
    }
    function settings(Request $request)
    {
        if (!AdminHelper::checkPermission('settings-view')) {
            return redirect('admin/index')->with('error', 'We don\'t have a access.');
        }

        $settings = GlobalSettings::first();
        return view('Admin.settings', [
            'data' => $settings
        ]);
    }

    function banners()
    {
        if (!AdminHelper::checkPermission('banner-view')) {
            return redirect('admin/index')->with('error', 'We don\'t have a access.');
        }
        return view('Admin.banners');
    }
    function deleteBanner($id)
    {
        $item = Banners::find($id);
        GlobalFunction::deleteFile($item->image);
        $item->delete();

        return GlobalFunction::sendSimpleResponse(true, 'Banner deleted successfully');
    }

    function addBanner(Request $request)
    {
        if (!AdminHelper::checkPermission('banner-add')) {
            return GlobalFunction::sendSimpleResponse(false, 'You are not allowed to add');
        }
        $item = new Banners();
        $item->title = $request->title;
        $item->image = GlobalFunction::saveFileAndGivePath($request->image);
        $item->save();

        return GlobalFunction::sendSimpleResponse(true, 'Banner added successfully');
    }

    function fetchBannersList(Request $request)
    {
        $totalData =  Banners::count();
        $rows = Banners::orderBy('id', 'DESC')->get();

        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'fullname',
            2 => 'identity',
            3 => 'username',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = Banners::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Banners::Where('title', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Banners::Where('title', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($result as $item) {

            $delete = "";
            $edit = "";
            $imgUrl = "http://placehold.jp/150x150.png";

            $imgUrl = GlobalFunction::createMediaUrl($item->image);
            $img = '<img src="' . $imgUrl . '" width="300" height="120">';

            if (AdminHelper::checkPermission('banner-delete')) {
                $delete = '<a href="" class="mr-2 btn btn-danger text-white delete"  rel=' . $item->id . ' >' . __("Delete") . '</a>';
            }
            if (AdminHelper::checkPermission('banner-edit')) {
                $edit = '<a href="javascript:void(0)" class="mr-2 btn btn-primary text-white update" data-title="' . $item->title . '" rel=' . $item->id . ' >' . __("Edit") . '</a>';
            }
            $action =  $edit . $delete;


            $data[] = array(
                $img,
                $item->title,
                $action
            );
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => $totalFiltered,
            "data"            => $data
        );
        echo json_encode($json_data);
        exit();
    }

    function editBannerInfo(Request $request)
    {

        $bannerInfo = Banners::find($request->id);
        $bannerInfo->title = $request->title;
        if ($request->image != null) {
            $bannerInfo->image = GlobalFunction::saveFileAndGivePath($request->image);
            if ($bannerInfo->image != '') {
                Storage::delete($bannerInfo->image);
            }
        }
        $bannerInfo->save();

        return GlobalFunction::sendSimpleResponse(true, 'Banner updated successfully');
    }

    function index()
    {

        $settings = GlobalSettings::first();


        return view('Admin.index', [
            'settings' => $settings,
        ]);
    }

    function adminSettings()
    {
        if (!AdminHelper::checkPermission('settings-view')) {
            return redirect('admin/index')->with('error', 'We don\'t have a access.');
        }
        $adminSettings = AdminSettings::first();

        return view('Admin.adminSettings', ['adminSettings' => $adminSettings]);
    }

    function updateAdminSettings(Request $request)
    {
        if (!AdminHelper::checkPermission('settings-edit')) {
            return redirect('admin/index')->with('error', 'We don\'t have a access.');
        }
        $validator = Validator::make($request->all(), [
            'site_logo' => 'mimes:jpeg,jpg,png|max:2048', // max 10000kb
            'footer_logo' => 'mimes:jpeg,jpg,png|max:2048', // max 10000kb
            'fav_icon' => 'mimes:jpeg,jpg,png|max:2048' // max 10000kb
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withErrors($errors);
        }


        $settings = AdminSettings::first();

        if ($request->site_logo != null) {
            if ($settings->site_logo != '') {
                Storage::delete($settings->site_logo);
                /* if(Storage::exists('uploads/1uukMjtsOJRqdK8sZ42p2HErFIVG0eFgW1teMTI11.jpg')) */
            }
            $settings->site_logo = GlobalFunction::saveFileAndDynamicPath($request->site_logo, 'logo');
        }
        if ($request->footer_logo != null) {
            if ($settings->footer_logo != '') {
                Storage::delete($settings->footer_logo);
            }
            $settings->footer_logo = GlobalFunction::saveFileAndDynamicPath($request->footer_logo, 'logo');
        }
        if ($request->fav_icon != null) {
            if ($settings->fav_icon != '') {
                Storage::delete($settings->fav_icon);
            }
            $settings->fav_icon = GlobalFunction::saveFileAndDynamicPath($request->fav_icon, 'logo');
        }

        $settings->site_name = $request->site_name ?? '';
        $settings->admin_email = $request->admin_email ?? '';
        $settings->meta_title = $request->meta_title ?? '';
        $settings->meta_description = $request->meta_description ?? '';
        $settings->meta_keywords = $request->meta_keywords ?? '';

        $settings->fb_app_id = $request->fb_app_id ?? '';
        $settings->fb_app_secret = $request->fb_app_secret ?? '';
        $settings->fb_access_token = $request->fb_access_token ?? '';
        $settings->twitter_app_id = $request->twitter_app_id ?? '';
        $settings->twitter_name = $request->twitter_name ?? '';
        $settings->copy_right = $request->copy_right ?? '';
        $settings->gmail_client_id = $request->gmail_client_id ?? '';
        $settings->gmail_client_secret = $request->gmail_client_secret ?? '';
        $settings->gmail_redirect_url = $request->gmail_redirect_url ?? '';
        $settings->gmap_key = $request->gmap_key ?? '';
        $settings->facebook_link = $request->facebook_link ?? '';
        $settings->twitter_link = $request->twitter_link ?? '';
        $settings->linkedin_link = $request->linkedin_link ?? '';
        $settings->instagram_link = $request->instagram_link ?? '';
        $settings->youtube_link = $request->youtube_link ?? '';
        $settings->google_data_studio_link = $request->google_data_studio_link ?? '';
        $settings->google_analytics = $request->google_analytics ?? '';
        $settings->twillio_account_sid = $request->twillio_account_sid ?? '';
        $settings->twillio_auth_token = $request->twillio_auth_token ?? '';
        $settings->twillio_number = $request->twillio_number ?? '';
        $settings->twillio_mode = $request->twillio_mode ?? '';
        $settings->paypal_email = $request->paypal_email ?? '';
        $settings->paypal_mode = $request->paypal_mode ?? '';


        $settings->save();

        $adminFill = "";
        foreach ($settings->toArray() as $key => $value) {
            $adminFill .= "\n    '" . $key . "' => '" . $value . "',";
        }

        $adminFill .= "\n];";

        $final = "<?php return [ " . $adminFill;

        // Laravel base path
        $basePath = base_path();

        // Directory within Laravel's base path
        $directory = 'config';

        // Full path to the file
        $filePath = $basePath . '/' . $directory . '/myConfig.php';

        // Create the directory if it doesn't exist
        if (!is_dir($basePath . '/' . $directory)) {
            mkdir($basePath . '/' . $directory, 0755, true);
        }

        // Write the content to the file
        file_put_contents($filePath, $final);

        return redirect()->back()->with('success', 'Successfully saved');
    }
}
