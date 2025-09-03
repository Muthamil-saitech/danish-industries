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
  # This is RawMaterialController
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\FPrmitem;
use App\MaterialStock;
use App\RawMaterial;
use App\RawMaterialCategory;
use App\RMPurchase_model;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RawMaterialController extends Controller
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
        $obj = RawMaterial::orderBy('id', 'DESC')->where('del_status', "Live")->get()->map(function ($rmaterial) {
            $usedInPrmat = FPrmitem::where('rmaterials_id', $rmaterial->id)->where('del_status','Live')->exists();
            $usedInPurchase = RMPurchase_model::where('rmaterials_id', $rmaterial->id)->where('del_status','Live')->exists();
            $usedInStock = MaterialStock::where('mat_id', $rmaterial->id)->where('del_status','Live')->exists();
            $rmaterial->used_in_product = $usedInPrmat || $usedInPurchase || $usedInStock;
            return $rmaterial;
        });
        $title = __('index.raw_materials');
        return view('pages.rawmaterial.rawmaterials', compact('title', 'obj'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('index.add_raw_material');
        $categories = RawMaterialCategory::orderBy('id', 'DESC')->where('del_status', "Live")->get();
        $units = Unit::orderBy('id', 'DESC')->where('del_status', "Live")->get();
        // $obj_rm = RawMaterial::count();
        // //generate code
        // $code = "RM-" . str_pad($obj_rm + 1, 3, '0', STR_PAD_LEFT);
        return view('pages.rawmaterial.addEditRawMaterial', compact('title', 'units', 'categories'));
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
                'max:150',
            ],
            'category' => 'required',
            // 'insert_type' => 'required_if:category,1',
            'code' => [
                'required',
                'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\/&\-\s]+$/',
                'max:20',
                Rule::unique('tbl_rawmaterials', 'code')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            // 'type' => 'required',
            // 'description' => 'required|max:250',
            'remarks' => 'max:100',
            // 'heat_no' => 'max:20',
            'old_mat_no' => 'max:100',
        ],
            [
                'name.required' => __('index.raw_mat_req'),
                'category.required' => __('index.raw_mat_c_req'),
                'code.required' => __('index.raw_mat_code_req'),
                // 'insert_type.required_if' => "The Insert Type field is required",
            ]
        );

        $obj = new \App\RawMaterial();
        $obj->name = ucwords(escape_output($request->get('name')));
        $obj->code = escape_output($request->get('code'));
        $obj->category = escape_output($request->get('category'));
        // $obj->insert_type = $request->get('category')=="1" ? escape_output($request->get('insert_type')) : null;
        $obj->insert_type = null;
        // $obj->heat_no = escape_output($request->get('heat_no'));
        $obj->diameter = $request->filled('diameter') ? escape_output($request->get('diameter')) : null;
        $obj->old_mat_no = $request->get('old_mat_no');
        $obj->remarks = html_entity_decode($request->get('remarks'));
        $obj->added_by = auth()->user()->id;
        $obj->save();
        return redirect('rawmaterials')->with(saveMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RawMaterial  $rawmaterial
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rawmaterial = RawMaterial::find(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.edit_raw_material');
        $categories = RawMaterialCategory::orderBy('id', 'DESC')->where('del_status', "Live")->get();
        $units = Unit::orderBy('id', 'DESC')->where('del_status', "Live")->get();
        $obj = $rawmaterial;
        return view('pages.rawmaterial.addEditRawMaterial', compact('title', 'obj', 'categories', 'units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RawMaterial  $rawmaterial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RawMaterial $rawmaterial)
    {
        request()->validate([
            'name' => [
                'required',
                'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\/&\-\s]+$/',
                'max:150',
            ],
            'category' => 'required',
            'code' => [
                'required',
                'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\/&\-\s]+$/',
                'max:20',
                Rule::unique('tbl_rawmaterials', 'code')->ignore($rawmaterial->id,'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            // 'type' => 'required',
            // 'description' => 'required|max:250',
            'remarks' => 'max:100',
            // 'heat_no' => 'max:20',
            'old_mat_no' => 'max:100',
        ],
            [
                'name.required' => __('index.raw_mat_req'),
                'category.required' => __('index.raw_mat_c_req'),
                'code.required' => __('index.raw_mat_code_req'),
            ]
        );

        $rawmaterial->name = ucwords(escape_output($request->get('name')));
        $rawmaterial->code = escape_output($request->get('code'));
        $rawmaterial->category = escape_output($request->get('category'));
        // $rawmaterial->heat_no = escape_output($request->get('heat_no'));
        $rawmaterial->diameter = $request->filled('diameter') ? escape_output($request->get('diameter')) : null;
        // $rawmaterial->type = null_check(escape_output($request->get('type')));
        $rawmaterial->old_mat_no = html_entity_decode($request->get('old_mat_no'));
        $rawmaterial->remarks = html_entity_decode($request->get('remarks'));
        $rawmaterial->added_by = auth()->user()->id;
        $rawmaterial->save();
        return redirect('rawmaterials')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RawMaterial  $rawmaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(RawMaterial $rawmaterial)
    {
        $rawmaterial->del_status = "Deleted";
        $rawmaterial->save();
        return redirect('rawmaterials')->with(deleteMessage());
    }

    /**
     * Price History
     */
    public function priceHistory(Request $request)
    {
        $raw_material = encrypt_decrypt($request->get('raw_material'), 'decrypt');
        $rawMaterials = RawMaterial::where('del_status', "Live")->get();
        if($raw_material)
        {
            $obj = RawMaterial::whereHas('purchase')->orderBy('name', 'ASC')->where('del_status', "Live")->where('id', $raw_material)->get();
        }else{
            $obj = null;
        }
        $title = __('index.price_history');
        return view('pages.rawmaterial.priceHistory', compact('title', 'obj', 'rawMaterials'));

    }
}
