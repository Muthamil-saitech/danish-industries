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
  # This is FPCategoryController
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\FinishedProduct;
use App\FPCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FPCategoryController extends Controller
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
        $obj = FPCategory::orderBy('id', 'DESC')->where('del_status', "Live")->get()->map(function ($fcat) {
            $usedInProd = FinishedProduct::where('category', $fcat->id)->where('del_status', 'Live')->exists();
            $fcat->used_in_product = $usedInProd;
            return $fcat;
        });
        $title =  __('index.product_categories');
        $total_fpcategories = FPCategory::where('del_status', "Live")->count();
        return view('pages.fpcategory.fpcategories', compact('title', 'obj', 'total_fpcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title =  __('index.add_product_category');
        return view('pages.fpcategory.addEditFPCategory', compact('title'));
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
                Rule::unique('tbl_fpcategory', 'name')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'description' => 'max:250'
        ], [
            'name.required' => __('index.prod_cat_req'),
        ]);

        $obj = new \App\FPCategory;
        $obj->name = ucwords(escape_output($request->get('name')));
        $obj->description = html_entity_decode($request->get('description'));
        $obj->save();
        return redirect('fpcategories')->with(saveMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FPCategory  $fpcategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fpcategory = FPCategory::find(encrypt_decrypt($id, 'decrypt'));
        $title =  __('index.edit_product_category');
        $obj = $fpcategory;
        return view('pages.fpcategory.addEditFPCategory', compact('title', 'obj'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FPCategory  $fpcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FPCategory $fpcategory)
    {
        request()->validate([
            'name' => [
                'required',
                'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\/&\-\s]+$/',
                'max:50',
                Rule::unique('tbl_fpcategory', 'name')->ignore($fpcategory->id, 'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'description' => 'max:250'
        ], [
            'name.required' => __('index.prod_cat_req'),
        ]);

        $fpcategory->name = ucwords(escape_output($request->get('name')));
        $fpcategory->description = html_entity_decode($request->get('description'));
        $fpcategory->save();
        return redirect('fpcategories')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FPCategory  $fpcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(FPCategory $fpcategory)
    {
        $fpcategory->del_status = "Deleted";
        $fpcategory->save();
        return redirect('fpcategories')->with(deleteMessage());
    }
}
