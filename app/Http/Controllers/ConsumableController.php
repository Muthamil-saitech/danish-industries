<?php

namespace App\Http\Controllers;

use App\Consumable;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Manufacture;
use App\Mrmitem;
use App\Mstages;
use App\RawMaterial;
use App\User;
use Illuminate\Http\Request;

class ConsumableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request) {
        $obj = \App\Manufacture::whereIn('manufacture_status', ['draft','inProgress','done'])->where('del_status', 'Live');
        $manufactures = $obj->orderBy('id','DESC')->get();
        $customers = Customer::where('del_status','Live')->orderBy('id','DESC')->get();
        $title = __('index.consumable');
        //dd($manufactures);
        return view('pages.consumable.index', compact('title', 'manufactures','customers'));
    }
    public function show($id) {
        $manufacture = Manufacture::find(encrypt_decrypt($id, 'decrypt'));
        $consumable_materials = RawMaterial::where('category',1)->where('del_status','Live')->orderBy('id','DESC')->get();
        $m_stages = Mstages::orderBy('id', 'ASC')->where('manufacture_id', $manufacture->id)->where('del_status', "Live")->get();
        $employees = User::with('role')
        ->whereHas('role', function ($query) {
            $query->where('title', 'Operators');
        })
        ->where('del_status', 'Live')
        ->orderBy('emp_code', 'ASC')
        ->get();
        $consumables = Consumable::where('manufacture_id',$manufacture->id)->orderBy('id','DESC')->get();
        $title = 'Consumable Details';
        return view('pages.consumable.detail', compact('title','manufacture','consumable_materials','m_stages','employees','consumables'));
    }
    public function edit($id)
    {
        $title = __('index.edit_consumable');
        $manufacture = Manufacture::find(encrypt_decrypt($id, 'decrypt'));
        // $m_rmaterials = Mrmitem::orderBy('id', 'ASC')->where('manufacture_id', $manufacture->id)->where('del_status', "Live")->get();
        $consumable_materials = RawMaterial::where('category',1)->where('del_status','Live')->orderBy('id','DESC')->get();
        $m_stages = Mstages::orderBy('id', 'ASC')->where('manufacture_id', $manufacture->id)->where('del_status', "Live")->get();
        $employees = User::with('role')
        ->whereHas('role', function ($query) {
            $query->where('title', 'Operators');
        })
        ->where('del_status', 'Live')
        ->orderBy('emp_code', 'ASC')
        ->get();
        return view('pages.consumable.edit', compact('title', 'employees', 'manufacture', 'consumable_materials', 'm_stages'));
    }
    public function update(Request $request) {
        // dd($request->all());
        request()->validate([
            'ppcrc_no' => 'required',
            'mat_id' => 'required',
            'qty' => 'required|integer',
        ],[
            'qty.integer' => 'The Quantity must be a number.'
        ]);
        $consumable = $request->consumable_id ? Consumable::findOrFail($request->consumable_id) : new Consumable();
        $consumable->manufacture_id = $request->get('manufacture_id');
        $consumable->ppcrc_no = $request->get('ppcrc_no');
        $consumable->production_stage = $request->get('production_stage')=="" ? null : $request->get('production_stage');
        $consumable->user_id = $request->get('user_id') == "" ? null : $request->get('user_id');
        $consumable->mat_id = $request->get('mat_id');
        $consumable->qty = $request->get('qty');
        $consumable->save();
        if($request->consumable_id) {
            return response()->json(['status' => true, 'message' => 'Consumable updated successfully.']);
        } else {
            return redirect('consumable')->with(saveMessage());
        }
    }
}
