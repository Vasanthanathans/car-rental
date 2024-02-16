<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use App\Models\GlobalFunction;
use App\Models\GlobalSettings;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Helpers\AdminHelper;

class UsersController extends Controller
{
    //
    function users()
    {
        if (!AdminHelper::checkPermission('user-view')) {
            return redirect('admin/index')->with('error', 'We don\'t have a access.');
        }
        return view('Admin.users');
    }

    function viewUserProfile($id)
    {
        $user = Users::find($id);
        $settings = GlobalSettings::first();
        $totalBookings = 0;
        return view('Admin.viewUserProfile', [
            'user' => $user,
            'settings' => $settings,
            'totalBookings' => $totalBookings,
        ]);
    }

    function blockUserFromAdmin($id)
    {
        $user = Users::find($id);
        $user->is_block = 1;
        $user->save();

        return GlobalFunction::sendSimpleResponse(true, 'User blocked successfully!');
    }
    function unblockUserFromAdmin($id)
    {
        $user = Users::find($id);
        $user->is_block = 0;
        $user->save();

        return GlobalFunction::sendSimpleResponse(true, 'User unblocked successfully!');
    }





    function fetchUsersList(Request $request)
    {
        $totalData =  Users::count();
        $rows = Users::orderBy('id', 'DESC')->get();

        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'fullname',
            2 => 'identity',
            3 => 'regPhoneNumber',
            4 => 'isPhoneVerified',
            5 => 'username',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = Users::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Users::where(function ($query) use ($search) {
                $query->Where('identity', 'LIKE', "%{$search}%")
                    ->orWhere('fullname', 'LIKE', "%{$search}%")
                    ->orWhere('regPhoneNumber', 'LIKE', "%{$search}%");
            })->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Users::where(function ($query) use ($search) {
                $query->Where('identity', 'LIKE', "%{$search}%")
                    ->orWhere('fullname', 'LIKE', "%{$search}%")
                    ->orWhere('regPhoneNumber', 'LIKE', "%{$search}%");
            })->count();
        }
        $data = array();
        foreach ($result as $item) {

            if ($item->profile_image == null) {
                $image = '<img src="http://placehold.jp/150x150.png" width="50" height="50">';
            } else {
                $imgUrl = GlobalFunction::createMediaUrl($item->profile_image);
                $image = '<img src="' . $imgUrl . '" width="50" height="50">';
            }

            $bookingCount = 0;

            $view = '<a href="' . route('admin.viewUserProfile', $item->id) . '" class="mr-2 btn btn-info text-white " rel=' . $item->id . ' >' . __("View") . '</a>';

            $block = "";
            $verified = "";
            if ($item->is_block == 0) {
                $block = '<a href="" class="mr-2 btn btn-danger text-white block" rel=' . $item->id . ' >' . __("Block") . '</a>';
            } else {
                $block = '<a href="" class="mr-2 btn btn-success text-white unblock" rel=' . $item->id . ' >' . __("Unblock") . '</a>';
            }
            if ($item->isPhoneVerified == 0) {
                $verified = '<p class="mr-2 btn btn-danger text-white" rel=' . $item->id . ' >' . __("Not Verified") . '</p>';
            } else {
                $verified = '<p class="mr-2 btn btn-success text-white" rel=' . $item->id . ' >' . __("Verified") . '</p>';
            }

            $action = $view  . $block;

            $data[] = array(
                $image,
                $item->identity,
                $item->regPhoneNumber,
                $verified,
                $item->fullname,
                $bookingCount,
                $action,
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


    function editUserDetails(Request $request)
    {
        $rules = [
            'user_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }

        $user = Users::find($request->user_id);
        if ($user == null) {
            return response()->json(['status' => false, 'message' => "User doesn't exists!"]);
        }
        if ($request->has('phone_number')) {
            $user->phone_number = GlobalFunction::cleanString($request->phone_number);
        }
        if ($request->has('fullname')) {
            $user->fullname = GlobalFunction::cleanString($request->fullname);
        }
        if ($request->has('favourite_salons')) {
            $user->favourite_salons = GlobalFunction::cleanString($request->favourite_salons);
        }
        if ($request->has('favourite_services')) {
            $user->favourite_services = GlobalFunction::cleanString($request->favourite_services);
        }
        if ($request->has('is_notification')) {
            $user->is_notification = $request->is_notification;
        }
        if ($request->has('profile_image')) {
            $user->profile_image = GlobalFunction::saveFileAndGivePath($request->profile_image);
        }
        $user->save();

        $user = Users::where('id', $user->id)->withCount('bookings')->first();
        return GlobalFunction::sendDataResponse(true, 'user updated successfully', $user);
    }


    function registerUser(Request $request)
    {
        $rules = [
            'identity' => 'required',
            'device_type' => [Rule::in(1, 2)],
            'device_token' => 'required',
            'login_type' => [Rule::in(1, 2, 3)],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }

        $user = Users::where('identity', $request->identity)->first();
        if ($user != null) {
            $user->device_type = $request->device_type;
            $user->device_token = $request->device_token;
            $user->login_type = $request->login_type;
            $user->save();
        } else {
            $user = new Users();
            $user->identity = $request->identity;
            $user->fullname = GlobalFunction::cleanString($request->fullname);
            $user->device_type = $request->device_type;
            $user->device_token = $request->device_token;
            $user->login_type = $request->login_type;
            $user->email = $request->identity;
            $user->save();
        }
        $user = Users::where('id', $user->id)->withCount('bookings')->first();
        return GlobalFunction::sendDataResponse(true, 'User registration successful', $user);
    }
    function fetchUserDetails(Request $request)
    {
        $rules = [
            'user_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }

        $user = Users::where('id', $request->user_id)->withCount('bookings')->first();
        return GlobalFunction::sendDataResponse(true, 'User details fetched successful', $user);
    }

    function updateOtpVerify(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'regPhoneNumber' => 'required',
            'isPhoneVerified' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }
        $user = Users::where('id', $request->user_id)->withCount('bookings')->first();
        $user->regPhoneNumber = $request->regPhoneNumber;
        $user->isPhoneVerified = $request->isPhoneVerified == "1" ? 1 : 0;
        $user->save();
        return GlobalFunction::sendDataResponse(true, 'User details fetched successful', $user);
    }

    function checkNumberAlreadyExist(Request $request)
    {
        $rules = [
            'regPhoneNumber' => 'required',
            'user_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }
        if (Users::where('regPhoneNumber', $request->regPhoneNumber)->where('id', "!=", $request->user_id)->exists()) {
            return GlobalFunction::sendDataResponse(false, 'Number Already Registered!', []);
        } else {
            return GlobalFunction::sendDataResponse(true, 'User details fetched successful', []);
        }
    }
}
