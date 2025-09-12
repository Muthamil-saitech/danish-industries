<?php
/*
  ##############################################################################
  # iProduction - Production and Manufacture Management Software
  ##############################################################################
  # AUTHOR:		Door Soft
  ##############################################################################
  # EMAIL:		info@doorsoft.co
  ##############################################################################
  # COPYRIGHT:		RESERVED BY Door Soft
  ##############################################################################
  # WEBSITE:		https://www.doorsoft.co
  ##############################################################################
  # This is RawMaterialCategoryController
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\MaterialType;
use App\RawMaterial;
use App\RawMaterialCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RawMaterialCategoryController extends Controller
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
        $obj = RawMaterialCategory::orderBy('id', 'DESC')->where('del_status', "Live")->get()->map(function ($category) {
            $usedInMaterial = RawMaterial::where('category', $category->id)->where('del_status', 'Live')->exists();
            $category->used_in_material = $usedInMaterial;
            return $category;
        });
        $title =  __('index.raw_material_categories');
        $total_mat_categories = RawMaterialCategory::where('del_status', "Live")->count();
        return view('pages.rmcategory.rmcategories', compact('title', 'obj', 'total_mat_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $material_types = MaterialType::where('del_status','Live')->orderBy('id','DESC')->get();
        $title =  __('index.add_raw_material_category');
        return view('pages.rmcategory.addEditRMCategory', compact('title', 'material_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => [
                'required',
                'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\/&\-\s]+$/',
                'max:50',
                Rule::unique('tbl_rmcategory', 'name')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'mat_type_id' => 'required',
            'description' => 'max:250'
        ], [
            'mat_type_id.required' => __('index.mat_type_req'),
            'name.required' => __('index.raw_mat_c_req'),
            'name.unique' => __('index.raw_mat_c_unique'),
        ]);

        $obj = new \App\RawMaterialCategory;
        $obj->name = ucwords(escape_output($request->get('name')));
        $obj->mat_type_id = $request->get('mat_type_id');
        $obj->description = html_entity_decode($request->get('description'));
        $obj->save();
        return redirect('rmcategories')->with(saveMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RawMaterialCategory  $rmcategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rmcategory = RawMaterialCategory::find(encrypt_decrypt($id, 'decrypt'));
        $material_types = MaterialType::where('del_status','Live')->orderBy('id','DESC')->get();
        $title =  __('index.edit_raw_material_category');
        $obj = $rmcategory;
        return view('pages.rmcategory.addEditRMCategory', compact('title', 'obj', 'material_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RawMaterialCategory  $rmcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RawMaterialCategory $rmcategory)
    {
        request()->validate([
            'name' => [
                'required',
                'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\/&\-\s]+$/',
                'max:50',
                Rule::unique('tbl_rmcategory', 'name')->ignore($rmcategory->id, 'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'mat_type_id' => 'required',
            'description' => 'max:250'
        ], [
            'mat_type_id.required' => __('index.mat_type_req'),
            'name.required' => __('index.raw_mat_c_req'),
        ]);

        $rmcategory->name = ucwords(escape_output($request->get('name')));
        $rmcategory->mat_type_id = $request->get('mat_type_id');
        $rmcategory->description = html_entity_decode($request->get('description'));
        $rmcategory->save();
        return redirect('rmcategories')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RawMaterialCategory  $rmcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(RawMaterialCategory $rmcategory)
    {
        $rmcategory->del_status = "Deleted";
        $rmcategory->save();
        return redirect('rmcategories')->with(deleteMessage());
    }
}
