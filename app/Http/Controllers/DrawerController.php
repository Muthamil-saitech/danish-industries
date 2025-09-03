<?php

namespace App\Http\Controllers;

use App\Drawer;
use App\Manufacture;
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
        return view('pages.drawer.addEditDrawer', compact('title'));
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
            'program_code' => 'required',
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
        $obj->program_code = escape_output($request->get('program_code'));
        $obj->notes = html_entity_decode($request->get('notes'));
        if ($request->hasFile('drawer_img')) {
            $file = $request->file('drawer_img');
            $filename = time() . "_" . $file->getClientOriginalName();
            $file->move(base_path('uploads/drawer'), $filename);
            $obj->drawer_img = $filename;
        }
        $obj->save();
        return redirect('drawers')->with(saveMessage());
    }
    public function edit($id)
    {
        $drawer = Drawer::find(encrypt_decrypt($id, 'decrypt'));
        $title =  __('index.edit_drawer');
        $obj = $drawer;
        return view('pages.drawer.addEditDrawer', compact('title', 'obj'));
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
            'program_code' => 'required',
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
        $drawer->program_code = escape_output($request->get('program_code'));
        $drawer->notes = html_entity_decode($request->get('notes'));
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
        return redirect('drawers')->with(updateMessage());
    }
    public function destroy(Drawer $drawer)
    {
        $drawer->del_status = "Deleted";
        $drawer->save();
        return redirect('drawers')->with(deleteMessage());
    }
}
