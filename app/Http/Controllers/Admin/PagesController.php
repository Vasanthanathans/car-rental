<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CmsPagesModel;
use Illuminate\Support\Str;
use App\Models\GlobalFunction;
use App\Helpers\AdminHelper;

class PagesController extends Controller
{
    //

    function privacypolicy(Request $request)
    {
        $data = Pages::first();
        return $data->privacy;
    }
    function termsOfUse(Request $request)
    {
        $data = Pages::first();
        return $data->termsofuse;
    }

    function viewTerms(Request $request)
    {
        $data = Pages::first();
        return view('Admin.pages.viewTerms', ['data' => $data->termsofuse]);
    }
    function updatePrivacy(Request $request)
    {
        $data = Pages::first();
        $data->privacy = $request->content;
        $data->save();

        return  json_encode(['status' => true, 'message' => "update successful"]);
    }
    function updateTerms(Request $request)
    {
        $data = Pages::first();
        $data->termsofuse = $request->content;
        $data->save();

        return  json_encode(['status' => true, 'message' => "update successful"]);
    }
    function viewPrivacy()
    {

        $data = Pages::first();
        return view('Admin.pages.viewPrivacy', ['data' => $data->privacy]);
    }

    function cmsPages()
    {
        if (!AdminHelper::checkPermission('cms-view')) {
            return redirect('admin/index')->with('error', 'We don\'t have a access.');
        }
        return  view('Admin.cms.cmsPages');
    }

    function fetchCmsPageList(Request $request)
    {
        $totalData =  CmsPagesModel::count();
        $rows = CmsPagesModel::orderBy('id', 'DESC')->get();

        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'title',
            2 => 'footer_type',
            3 => 'status',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = CmsPagesModel::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  CmsPagesModel::Where('id', 'LIKE', "%{$search}%")
                ->orWhere('title', 'LIKE', "%{$search}%")
                ->orWhere('footer_type', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = CmsPagesModel::Where('id', 'LIKE', "%{$search}%")
                ->orWhere('title', 'LIKE', "%{$search}%")
                ->orWhere('footer_type', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        $i = 1;
        foreach ($result as $item) {

            $edit = "";
            $delete = "";


            $footerType = $item->footer_type == 0 ? "Footer" : "Other";
            $con1 = $item->status == 0 ? "danger" : "success";
            $con2 = $item->status == 1 ? "Active" : "Inactive";

            $status = '<a href="" class="mr-2 btn btn-' . $con1 . ' text-white changeStatus" rel=' . $item->id . ' >' . $con2 . '</a>';

            if (AdminHelper::checkPermission('cms-edit')) {

                $edit = "<a href='" . url('/') . "/admin/addCmsPage/" . $item->id . "' class='btn mr-2 btn-primary'>Edit</a>";
            }
            if (AdminHelper::checkPermission('cms-delete')) {
                $delete = '<a href="" class="mr-2 btn btn-danger text-white delete" rel=' . $item->id . ' >' . __("Delete") . '</a>';
            }

            $action =  $edit . $delete;


            $data[] = array(
                $i,
                $item->title,
                $footerType,
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

    function addCmsPage($id = '')
    {
        if ($id != '') {

            if (!AdminHelper::checkPermission('cms-edit')) {
                return redirect('admin/index')->with('error', 'We don\'t have a access.');
            }
            $cmsPage = CmsPagesModel::where('id', $id);
            if ($cmsPage->count() > 0) {
                return view('Admin.cms.addCmsPage', ['page' => $cmsPage->first()]);
            }
            return redirect()->route('admin.cmsPages');
        }

        if (!AdminHelper::checkPermission('cms-add')) {
            return redirect('admin/index')->with('error', 'We don\'t have a access.');
        }

        return view('Admin.cms.addCmsPage');
    }

    function addeditCmsPage(Request $request)
    {

        if ($request->id == null) {

            $titleExist = CmsPagesModel::where('title', $request->title)->count();
            if ($titleExist > 0) {
                return  json_encode(['status' => false, 'message' => "Already Exists"]);
            } else {


                $cms = new CmsPagesModel();
                $cms->title = $request->title;
                $cms->content = htmlentities($request->content);
                $cms->footer_type = $request->footer_type;
                $cms->url = Str::snake($request->title);
                $cms->save();
                return  json_encode(['status' => true, 'message' => "Successfully CMS Page created."]);
            }
        } else {

            $titleExist = CmsPagesModel::where('id', '!=', $request->id)->where('title', $request->title)->count();
            if ($titleExist > 0) {
                return  json_encode(['status' => false, 'message' => "Already Exists"]);
            } else {
                $cms = CmsPagesModel::where('id', $request->id)->first();
                $cms->title = $request->title;
                $cms->content = htmlentities($request->content);
                $cms->footer_type = $request->footer_type;
                $cms->url = Str::snake($request->title);
                $cms->save();
                return  json_encode(['status' => true, 'message' => "Successfully Updated."]);
            }
        }
    }

    function deleteCmspage($id)
    {
        $item = CmsPagesModel::find($id);
        $item->delete();

        return GlobalFunction::sendSimpleResponse(true, 'Page deleted successfully');
    }
    function changeStatus($id)
    {
        $item = CmsPagesModel::find($id);
        $item->status = $item->status == 1 ? '0' : '1';
        $item->save();

        return GlobalFunction::sendSimpleResponse(true, 'Status Changed successfully');
    }
}
