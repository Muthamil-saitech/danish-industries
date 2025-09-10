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
  # This is ProductionStageController
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\FPproductionstage;
use Illuminate\Http\Request;
use App\ProductionStage;
use Illuminate\Validation\Rule;

class ProductionStageController extends Controller
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
        $obj = ProductionStage::orderBy('id', 'DESC')->where('del_status', "Live")->get()->map(function ($productionstage) {
            $usedInProductStage = FPproductionstage::where('productionstage_id', $productionstage->id)->where('del_status', 'Live')->exists();
            $productionstage->used_in_production_stage = $usedInProductStage;
            return $productionstage;
        });
        $title =  __('index.production_stage');
        $total_production_stages = ProductionStage::where('del_status', "Live")->count();
        return view('pages.productionstage.productionstages', compact('title', 'obj', 'total_production_stages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title =  __('index.add_production_stage');
        return view('pages.productionstage.addEditProductionStage', compact('title'));
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
                Rule::unique('tbl_production_stages', 'name')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'description' => 'max:100'
        ], [
            'name.required' => "The production stage name field is required",
            'name.unique' => "The production stage name already exists"
        ]);

        $obj = new \App\ProductionStage();
        $obj->name = ucwords(escape_output($request->get('name')));
        $obj->description = html_entity_decode($request->get('description'));
        $obj->save();
        return redirect('productionstages')->with(saveMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productionstage = ProductionStage::find(encrypt_decrypt($id, 'decrypt'));
        $title =  __('index.edit_production_stage');
        $obj = $productionstage;
        return view('pages.productionstage.addEditProductionStage', compact('title', 'obj'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductionStage $productionstage)
    {
        request()->validate([
            'name' => [
                'required',
                'max:50',
                'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\/&\-\s]+$/',
                Rule::unique('tbl_production_stages', 'name')->ignore($productionstage->id, 'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'description' => 'max:100'
        ], [
            'name.required' => "The production stage name field is required",
            'name.unique' => "The production stage name already exists"
        ]);

        $productionstage->name = ucwords(escape_output($request->get('name')));
        $productionstage->description = html_entity_decode($request->get('description'));
        $productionstage->save();
        return redirect('productionstages')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductionStage $productionstage)
    {
        $productionstage->del_status = "Deleted";
        $productionstage->save();
        return redirect('productionstages')->with(deleteMessage());
    }
}
