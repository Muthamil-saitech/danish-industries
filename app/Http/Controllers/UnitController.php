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
  # This is UnitController
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\MaterialStock;
use App\Unit;
use App\RawMaterialPurchase;
use App\RMPurchase_model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UnitController extends Controller
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
        $obj = Unit::orderBy('id', 'DESC')->where('del_status', "Live")->get()->map(function ($unit) {
            $usedInPurchase = RMPurchase_model::where('mat_unit', $unit->id)->where('del_status', 'Live')->exists();
            $usedInStock = MaterialStock::where('unit_id', $unit->id)->where('del_status', 'Live')->exists();
            $unit->used_in_purchase = $usedInPurchase || $usedInStock;
            return $unit;
        });
        $title =  __('index.unit');
        $total_units = Unit::where('del_status', "Live")->count();
        return view('pages.unit.units', compact('title', 'obj', 'total_units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title =  __('index.add_unit');
        return view('pages.unit.addEditUnit', compact('title'));
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
                'regex:/^[\pL\s]+$/u',
                'max:10',
                Rule::unique('tbl_rmunits', 'name')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'description' => 'max:100'
        ], [
            'name.required' => "The unit name field is required",
            'name.unique'   => "The unit name field already exists",
        ]);

        $obj = new \App\Unit;
        $obj->name = strtoupper(escape_output($request->get('name')));
        $obj->description = html_entity_decode($request->get('description'));
        $obj->save();
        return redirect('units')->with(saveMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unit = Unit::find(encrypt_decrypt($id, 'decrypt'));
        $title =  __('index.edit_unit');
        $obj = $unit;
        return view('pages.unit.addEditUnit', compact('title', 'obj'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        request()->validate([
            'name' => [
                'required',
                'regex:/^[\pL\s]+$/u',
                'max:10',
                Rule::unique('tbl_rmunits', 'name')->ignore($unit->id, 'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'description' => 'max:100'
        ], [
            'name.required' => "The unit name field is required",
            'name.unique'   => "The unit name field already exists",
        ]);

        $unit->name = strtoupper(escape_output($request->get('name')));
        $unit->description = html_entity_decode($request->get('description'));
        $unit->save();
        return redirect('units')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        $unit->del_status = "Deleted";
        $unit->save();
        return redirect('units')->with(deleteMessage());
    }
}
