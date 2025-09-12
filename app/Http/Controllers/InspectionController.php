<?php

namespace App\Http\Controllers;

use App\Drawer;
use App\Inspection;
use App\InspectionObservedDimension;
use App\InspectionParam;
use App\MaterialType;
use App\RawMaterial;
use App\RawMaterialCategory;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $obj = Inspection::where('del_status', 'Live')->orderBy('id', 'DESC')->get()->map(function ($inspect) {
            $usedInDimension = InspectionObservedDimension::where('inspect_id', $inspect->id)->exists();
            $inspect->used_in_dimension = $usedInDimension;
            return $inspect;
        });
        $title = __('index.inspection');
        $total_inspections = Inspection::where('del_status', 'Live')->count();
        return view('pages.inspection.inspection', compact('title', 'obj', 'total_inspections'));
    }
    public function create()
    {
        $title =  __('index.add_inspection');
        $categories = RawMaterialCategory::orderBy('id', 'DESC')->where('del_status', "Live")->get();
        $material_types = MaterialType::where('del_status','Live')->orderBy('id','DESC')->get();
        $materials = RawMaterial::where('category', '!=', 1)->where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        $drawers = Drawer::where('del_status', 'Live')->get();
        return view('pages.inspection.addEditInspection', compact('title', 'materials', 'drawers', 'categories', 'material_types'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $inspection = new Inspection();
        $inspection->mat_type = $request->get('mat_type');
        $inspection->ins_type = 0;
        $inspection->mat_cat_id = $request->get('mat_cat_id');
        $inspection->mat_id = $request->get('mat_id');
        // $inspection->mat_code = $request->get('mat_code');
        $inspection->drawer_id = $request->get('drawer_no');
        $inspection->save();
        $inspect_id = $inspection->id;
        $di_params = $request->get('di_param', []);
        $di_specs = $request->get('di_spec', []);
        $di_methods = $request->get('di_method', []);
        $ap_params = $request->get('ap_param', []);
        $ap_specs = $request->get('ap_spec', []);
        $ap_methods = $request->get('ap_method', []);
        $max = max(
            count($di_params),
            count($ap_params)
        );
        for ($i = 0; $i < $max; $i++) {
            $ins_param = new InspectionParam();
            $ins_param->inspect_id = $inspect_id;
            $ins_param->di_param = $di_params[$i] ?? '';
            $ins_param->di_spec = $di_specs[$i] ?? '';
            $ins_param->di_method = escape_output($di_methods[$i] ?? '');
            $ins_param->ap_param = escape_output($ap_params[$i] ?? '');
            $ins_param->ap_spec = $ap_specs[$i] ?? '';
            $ins_param->ap_method = escape_output($ap_methods[$i] ?? '');
            $ins_param->save();
        }
        return redirect('inspections')->with(saveMessage());
    }
    public function getMaterialCode(Request $request)
    {
        $material = RawMaterial::where('del_status', "Live")->where('id', $request->id)->orderBy('id', 'DESC')->first();
        echo json_encode($material);
    }
    public function edit($id)
    {
        $inspection = Inspection::find(encrypt_decrypt($id, 'decrypt'));
        $title =  __('index.edit_inspection');
        $obj = $inspection;
        $categories = RawMaterialCategory::orderBy('id', 'DESC')->where('del_status', "Live")->get();
        $material_types = MaterialType::where('del_status','Live')->orderBy('id','DESC')->get();
        $inspectParams = InspectionParam::where('inspect_id', $inspection->id)->where('del_status', 'Live')->get();
        $materials = RawMaterial::where('category', '!=', 1)->where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        $drawers = Drawer::where('del_status', 'Live')->get();
        return view('pages.inspection.addEditInspection', compact('title', 'obj', 'materials', 'drawers', 'inspectParams', 'categories', 'material_types'));
    }
    public function update(Request $request, Inspection $inspection)
    {
        // dd($request->all());
        $inspection->mat_type = $request->get('mat_type');
        $inspection->ins_type = 0;
        $inspection->mat_cat_id = $request->get('mat_cat_id');
        $inspection->mat_id = $request->get('mat_id');
        // $inspection->mat_code = $request->get('mat_code');
        $inspection->drawer_id = $request->get('drawer_no');
        $inspection->save();
        $last_id = $inspection->id;
        InspectionParam::where('inspect_id', $last_id)->update(['del_status' => "Deleted"]);
        $di_params = $request->get('di_param', []);
        $di_specs = $request->get('di_spec', []);
        $di_methods = $request->get('di_method', []);
        $ap_params = $request->get('ap_param', []);
        $ap_specs = $request->get('ap_spec', []);
        $ap_methods = $request->get('ap_method', []);
        $max = max(
            count($di_params),
            count($ap_params)
        );
        for ($i = 0; $i < $max; $i++) {
            $ins_param = new InspectionParam();
            $ins_param->inspect_id = $last_id;
            $ins_param->di_param = $di_params[$i] ?? '';
            $ins_param->di_spec = $di_specs[$i] ?? '';
            $ins_param->di_method = escape_output($di_methods[$i] ?? '');
            $ins_param->ap_param = escape_output($ap_params[$i] ?? '');
            $ins_param->ap_spec = $ap_specs[$i] ?? '';
            $ins_param->ap_method = escape_output($ap_methods[$i] ?? '');
            $ins_param->save();
        }
        return redirect('inspections')->with(updateMessage());
    }
    public function destroy(Inspection $inspection)
    {
        InspectionParam::where('inspect_id', $inspection->id)->update(['del_status' => "Deleted"]);
        $inspection->del_status = "Deleted";
        $inspection->save();
        return redirect('inspections')->with(deleteMessage());
    }
}
