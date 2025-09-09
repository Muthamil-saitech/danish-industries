<?php

namespace App\Http\Controllers;

use App\Drawer;
use App\DrawingParameter;
use App\Manufacture;
use App\ProductionStage;
use App\Tool;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DrawerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $obj = Drawer::orderBy('id', 'DESC')->where('del_status', "Live")->get()->map(function ($drawer) {
            $usedInManufacture = Manufacture::where('drawer_no', $drawer->drawer_no)->where('del_status', 'Live')->exists();
            $drawer->used_in_manufacture = $usedInManufacture;
            return $drawer;
        });
        $title =  __('index.drawer');
        $total_drawers = Drawer::where('del_status', "Live")->count();
        return view('pages.drawer.drawer', compact('title', 'obj', 'total_drawers'));
    }
    public function create()
    {
        $title =  __('index.add_drawer');
        $tools = Tool::where('del_status','Live')->orderBy('id','DESC')->get();
        $productionstages = ProductionStage::orderBy('id', 'ASC')->where('del_status', "Live")->get();
        return view('pages.drawer.addEditDrawer', compact('title', 'tools', 'productionstages'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        request()->validate([
            'drawer_no' => [
                'required',
                Rule::unique('tbl_drawers', 'drawer_no')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'revision_no' => 'required',
            'revision_date' => 'required',
            'drawer_loc' => 'required|max:100',
            'tools_id' => 'array',
            'stage_id' => 'array',
            'drawer_img' => 'nullable|mimes:jpeg,png,jpg,svg|max:1024',
        ], [
            'drawer_no.required' => "The drawing no field is required",
            'drawer_loc.required' => "The drawing location field is required",
            'drawer_loc.max' => "The drawing location may not be greater than 100 characters.",
        ]);
        $obj = new \App\Drawer;
        $obj->drawer_no = strtoupper(escape_output($request->get('drawer_no')));
        $obj->revision_no = escape_output($request->get('revision_no'));
        $obj->revision_date = date('Y-m-d', strtotime($request->get('revision_date')));
        $obj->drawer_loc = escape_output($request->get('drawer_loc'));
        $obj->program_code = json_encode($request->get('program_code'),true);
        $obj->tools_id = implode(',', $request->get('tools_id', []));
        $obj->stage_id = implode(',', $request->get('stage_id', []));
        if ($request->hasFile('drawer_img')) {
            $file = $request->file('drawer_img');
            $filename = time() . "_" . $file->getClientOriginalName();
            $file->move(base_path('uploads/drawer'), $filename);
            $obj->drawer_img = $filename;
        }
        $obj->save();
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
            $drawing_param = new DrawingParameter();
            $drawing_param->drawing_id = $obj->id;
            $drawing_param->di_param = $di_params[$i] ?? '';
            $drawing_param->di_spec = $di_specs[$i] ?? '';
            $drawing_param->di_method = escape_output($di_methods[$i] ?? '');
            $drawing_param->ap_param = escape_output($ap_params[$i] ?? '');
            $drawing_param->ap_spec = $ap_specs[$i] ?? '';
            $drawing_param->ap_method = escape_output($ap_methods[$i] ?? '');
            $drawing_param->save();
        }
        return redirect('drawers')->with(saveMessage());
    }
    public function edit($id)
    {
        $drawer = Drawer::find(encrypt_decrypt($id, 'decrypt'));
        $title =  __('index.edit_drawer');
        $obj = $drawer;
        $drawing_parameters = DrawingParameter::where('drawing_id',$drawer->id)->where('del_status','Live')->get();
        $tools = Tool::where('del_status','Live')->orderBy('id','DESC')->get();
        $productionstages = ProductionStage::orderBy('id', 'ASC')->where('del_status', "Live")->get();
        return view('pages.drawer.addEditDrawer', compact('title', 'obj', 'tools', 'productionstages', 'drawing_parameters'));
    }
    public function update(Request $request, Drawer $drawer)
    {
        // dd($request->all());
        request()->validate([
            'drawer_no' => [
                'required',
                Rule::unique('tbl_drawers', 'drawer_no')->ignore($drawer->id, 'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'revision_no' => 'required',
            'revision_date' => 'required',
            'drawer_loc' => 'required|max:100',
            'tools_id' => 'array',
            'stage_id' => 'array',
            // 'program_code' => 'required',
            'drawer_img' => 'nullable|mimes:jpeg,png,jpg,svg|max:1024'
        ], [
            'drawer_no.required' => "The drawing no field is required",
            'drawer_loc.required' => "The drawing location field is required",
            'drawer_loc.max' => "The drawing location may not be greater than 100 characters.",
        ]);
        $drawer->drawer_no = strtoupper(escape_output($request->get('drawer_no')));
        $drawer->revision_no = escape_output($request->get('revision_no'));
        $drawer->revision_date = date('Y-m-d', strtotime($request->get('revision_date')));
        $drawer->drawer_loc = escape_output($request->get('drawer_loc'));
        $drawer->program_code = json_encode($request->get('program_code'),true);
        $drawer->tools_id = implode(',', $request->get('tools_id', []));
        $drawer->stage_id = implode(',', $request->get('stage_id', []));
        if ($request->hasFile('drawer_img')) {
            if (!empty($drawer->drawer_img)) {
                $oldImagePath = base_path('uploads/drawer/' . $drawer->drawer_img);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $file = $request->file('drawer_img');
            $filename = time() . "_" . $file->getClientOriginalName();
            $file->move(base_path('uploads/drawer'), $filename);
            $drawer->drawer_img = $filename;
        }
        $drawer->save();
        DrawingParameter::where('drawing_id', $drawer->id)->update(['del_status' => "Deleted"]);
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
            $drawing_param = new DrawingParameter();
            $drawing_param->drawing_id = $drawer->id;
            $drawing_param->di_param = $di_params[$i] ?? '';
            $drawing_param->di_spec = $di_specs[$i] ?? '';
            $drawing_param->di_method = escape_output($di_methods[$i] ?? '');
            $drawing_param->ap_param = escape_output($ap_params[$i] ?? '');
            $drawing_param->ap_spec = $ap_specs[$i] ?? '';
            $drawing_param->ap_method = escape_output($ap_methods[$i] ?? '');
            $drawing_param->save();
        }
        return redirect('drawers')->with(updateMessage());
    }
    public function destroy(Drawer $drawer)
    {
        $drawer->del_status = "Deleted";
        $drawer->save();
        return redirect('drawers')->with(deleteMessage());
    }
}
