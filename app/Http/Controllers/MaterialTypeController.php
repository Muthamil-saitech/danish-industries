<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\MaterialType;
use App\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MaterialTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $obj = MaterialType::orderBy('id', 'DESC')->where('del_status', "Live")->get()->map(function ($type) {
            $usedInMaterial = RawMaterial::where('type', $type->id)->where('del_status', 'Live')->exists();
            $category->used_in_material = $usedInMaterial;
            return $category;
        }); */
        $obj = MaterialType::where('del_status','Live')->orderBy('id','DESC')->get();
        $title =  __('index.mat_types');
        $total_mat_types = MaterialType::where('del_status', "Live")->count();
        return view('pages.material_types.index', compact('title', 'obj', 'total_mat_types'));
    }
    public function create()
    {
        $title =  __('index.add_mat_type');
        return view('pages.material_types.add', compact('title'));
    }
    public function store(Request $request)
    {
        request()->validate([
            'type_name' => [
                'required',
                'max:50',
                Rule::unique('tbl_material_types', 'type_name')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
        ], [
            'type_name.required' => __('index.mat_type_req'),
            'type_name.unique' => __('index.mat_type_unique'),
        ]);
        $obj = new \App\MaterialType();
        $obj->type_name = ucwords(escape_output($request->get('type_name')));
        $obj->save();
        return redirect('materialtypes')->with(saveMessage());
    }
    public function edit($id)
    {
        $materialtype = MaterialType::find(encrypt_decrypt($id, 'decrypt'));
        $title =  __('index.edit_mat_type');
        $obj = $materialtype;
        return view('pages.material_types.add', compact('title', 'obj'));
    }
    public function update(Request $request, MaterialType $materialtype)
    {
        request()->validate([
            'type_name' => [
                'required',
                'max:50',
                Rule::unique('tbl_material_types', 'type_name')->ignore($materialtype->id, 'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
        ], [
            'type_name.required' => __('index.mat_type_req'),
            'type_name.unique' => __('index.mat_type_unique'),
        ]);

        $materialtype->type_name = ucwords(escape_output($request->get('type_name')));
        $materialtype->save();
        return redirect('materialtypes')->with(updateMessage());
    }
    public function destroy(MaterialType $materialtype)
    {
        $materialtype->del_status = "Deleted";
        $materialtype->save();
        return redirect('materialtypes')->with(deleteMessage());
    }
}
