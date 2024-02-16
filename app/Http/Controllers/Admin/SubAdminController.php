<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubAdminModel;
use App\Models\GlobalFunction;
use Illuminate\Support\Facades\Hash;
use App\Helpers\AdminHelper;

class SubAdminController extends Controller
{
    function subadmins()
    {
        if (!AdminHelper::checkPermission('subadmin-view')) {
            return redirect('admin/index')->with('error', 'We don\'t have a access.');
        }
        return view('Admin.subAdmin.subAdmin', ['headTitle' => 'Sub Admins']);
    }

    function fetchSubAdminList(Request $request)
    {
        $totalData =  SubAdminModel::count();
        $rows = SubAdminModel::orderBy('id', 'DESC')->get();

        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'fullName',
            2 => 'email',
            3 => 'status',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = SubAdminModel::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  SubAdminModel::Where('id', 'LIKE', "%{$search}%")
                ->orWhere('fullName', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = SubAdminModel::Where('id', 'LIKE', "%{$search}%")
                ->orWhere('fullName', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        $i = 1;
        foreach ($result as $item) {

            $edit = "";
            $delete = "";


            $con1 = $item->status == 0 ? "danger" : "success";
            $con2 = $item->status == 1 ? "Active" : "Inactive";

            $status = '<a href="" class="mr-2 btn btn-' . $con1 . ' text-white changeStatus" rel=' . $item->id . ' >' . $con2 . '</a>';
            if (AdminHelper::checkPermission('subadmin-edit')) {
                $edit = "<a href='" . url('/') . "/admin/addSubAdmin/" . $item->id . "' class='btn mr-2 btn-primary'>Edit</a>";
            }
            if (AdminHelper::checkPermission('subadmin-delete')) {
                $delete = '<a href="" class="mr-2 btn btn-danger text-white delete" rel=' . $item->id . ' >' . __("Delete") . '</a>';
            }

            $action =  $edit . $delete;


            $data[] = array(
                $i,
                $item->fullName,
                $item->email,
                $status,
                $action
            );
            $i++;
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


    function addSubAdmin($id = '')
    {

        if ($id != '') {
            if (!AdminHelper::checkPermission('subadmin-edit')) {
                return redirect('admin/index')->with('error', 'We don\'t have a access.');
            }
            $subAdmin = SubAdminModel::where('id', $id);
            if ($subAdmin->count() > 0) {
                return view('Admin.subAdmin.addSubAdmin', ['data' => $subAdmin->first()]);
            }
            return redirect()->route('admin.subadmins');
        }
        if (!AdminHelper::checkPermission('subadmin-add')) {
            return redirect('admin/index')->with('error', 'We don\'t have a access.');
        }
        return view('Admin.subAdmin.addSubAdmin');
    }

    function addeditSubAdmin(Request $request)
    {
        if ($request->id == null) {

            $emailExist = SubAdminModel::where('email', $request->email)->count();
            if ($emailExist > 0) {
                return  json_encode(['status' => false, 'message' => "Email Already Exists"]);
            } else {

                $subAdmin = new SubAdminModel();
                $subAdmin->fullName = $request->fullName;
                $subAdmin->password = Hash::make($request->password);
                $subAdmin->email = $request->email;
                $subAdmin->status = '1';
                $subAdmin->permissions = json_encode($request->permissions);
                $subAdmin->save();
                return  json_encode(['status' => true, 'message' => "Successfully sub admin added."]);
            }
        } else {

            $emailExist = SubAdminModel::where('id', '!=', $request->id)->where('email', $request->email)->count();
            if ($emailExist > 0) {
                return  json_encode(['status' => false, 'message' => "Email Already Exists"]);
            } else {
                $subAdmin = SubAdminModel::where('id', $request->id)->first();
                $subAdmin->fullName = $request->fullName;
                if ($request->password != null) {
                    $subAdmin->password = Hash::make($request->password);
                }
                $subAdmin->email = $request->email;
                $subAdmin->permissions = json_encode($request->permissions);
                $subAdmin->save();
                return  json_encode(['status' => true, 'message' => "Successfully Updated."]);
            }
        }
    }

    function deleteSubAdmin($id)
    {

        $item = SubAdminModel::find($id);
        $item->delete();
        return GlobalFunction::sendSimpleResponse(true, 'Deleted successfully');
    }
    function changeSubAdminStatus($id)
    {
        $item = SubAdminModel::find($id);
        $item->status = $item->status == 1 ? '0' : '1';
        $item->save();

        return GlobalFunction::sendSimpleResponse(true, 'Status Changed successfully');
    }
}
