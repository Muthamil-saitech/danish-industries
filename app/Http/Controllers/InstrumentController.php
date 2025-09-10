<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Instrument;
use App\InstrumentCategory;
use Illuminate\Validation\Rule;
use App\Unit;
use App\Customer;


class InstrumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $obj = Instrument::orderBy('id','DESC')->where('del_status','Live')->get();
        $title =  __('index.instruments');
        return view('pages.instruments.index', compact('title','obj'));
    }
    public function create() {
        $title = __('index.add_instrument');
        $instrument_categories = InstrumentCategory::where('del_status','Live')->get();
        $units = Unit::where('del_status','Live')->get();
        $customers = Customer::where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        return view('pages.instruments.addEditInstrument', compact('title','instrument_categories','units','customers'));
    }
    public function store(Request $request)
    {
        request()->validate([
            'type' => 'required',
            'category' => 'required',
            'code' => [
                'required',
                'max:50',
                Rule::unique('tbl_instruments', 'instrument_name')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'instrument_name' => [
                'required',
                'max:50',
                Rule::unique('tbl_instruments', 'instrument_name')
                ->where(function ($query) use ($request) {
                    return $query->where('del_status', 'Live')
                                ->where('type', $request->type)
                                ->where('category', $request->category);
                }),
            ],
            'unit' => 'required',
            'owner_type' => 'required',
            'customer_id' => 'required_if:owner_type,2',
            'range' => [
                'required',
                'max:25',
            ],
            'accuracy' => [
                'required',
                'max:25'
            ],
            'make' => [
                'required',
                'max:25'
            ],
            'calibration_due' => 'required',
            'remarks' => 'nullable'
        ], [
            'code.required' => "The instrument code field is required",
            'code.unique' => "The instrument code field already exists",
            'instrument_name.required' => "The instrument name field is required",
            'instrument_name.unique' => "The instrument name field already exists",
            'type.required' => "The type field is required",
            'category.required' => "The instrument category field is required",
            'unit.required' => "The unit field is required",
            'owner_type.required' => "The owner field is required",
            'customer_id.required_if' => 'The customers field is required',
            'range.required' => "The range/size field is required",
            'accuracy.required' => "The accuracy field is required",
            'make.required' => "The make field is required",
            'calibration_due.required' => "The calibration due field is required",
        ]);

        $obj = new \App\Instrument;
        $obj->code = escape_output($request->get('code'));
        $obj->instrument_name = escape_output($request->get('instrument_name'));
        $obj->type = $request->get('type');
        $obj->category = $request->get('category');
        $obj->unit = $request->get('unit');
        $obj->owner_type = $request->get('owner_type');
        $obj->customer_id = $request->get('customer_id') ?: null;
        $obj->range = escape_output($request->get('range'));
        $obj->accuracy = escape_output($request->get('accuracy'));
        $obj->make = escape_output($request->get('make'));
        $obj->calibration_due = date('Y-m-d', strtotime($request->get('calibration_due')));
        $obj->remarks = escape_output($request->get('remarks'));
        $obj->save();
        return redirect('instruments')->with(saveMessage());
    }
    public function edit($id)
    {
        $instrument = Instrument::find(encrypt_decrypt($id, 'decrypt'));
        $title =  __('index.edit_instrument');
        $instrument_categories = InstrumentCategory::where('del_status','Live')->where('type',$instrument->type)->get();
        $units = Unit::where('del_status','Live')->get();
        $customers = Customer::where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        $obj = $instrument;
        return view('pages.instruments.addEditInstrument', compact('title', 'obj','instrument_categories','units','customers'));
    }
    public function update(Request $request, Instrument $instrument)
    {
        request()->validate([
            'code' => [
                'required',
                'max:50',
                Rule::unique('tbl_instruments', 'instrument_name')->ignore($instrument->id, 'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'instrument_name' => [
                'required',
                'max:50',
                Rule::unique('tbl_instruments', 'instrument_name')
                    ->ignore($instrument->id,'id')
                    ->where(function ($query) use ($request) {
                        return $query->where('del_status', 'Live')
                                    ->where('type', $request->type)
                                    ->where('category', $request->category);
                    }),
            ],
            'type' => 'required',
            'category' => 'required',
            'unit' => 'required',
            'owner_type' => 'required',
            'range' => [
                'required',
                'max:25',
            ],
            'accuracy' => [
                'required',
                'max:25'
            ],
            'make' => [
                'required',
                'max:25'
            ],
            'calibration_due' => 'required',
            'remarks' => [
                'nullable',
                'max:255'
            ]
        ], [
            'code.required' => "The instrument code field is required",
            'instrument_name.required' => "The instrument name field is required",
            'type.required' => "The type field is required",
            'category.required' => "The category field is required",
            'unit.required' => "The unit field is required",
            'owner_type.required' => "The owner type field is required",
            'range.required' => "The range field is required",
            'accuracy.required' => "The accuracy field is required",
            'make.required' => "The make field is required",
            'calibration_due.required' => "The calibration due field is required",
        ]);

        $instrument->type = $request->get('type');
        $instrument->category = $request->get('category');
        $instrument->code = escape_output($request->get('code'));
        $instrument->instrument_name = ucwords(escape_output($request->get('instrument_name')));
        $instrument->unit = $request->get('unit');
        $instrument->owner_type = $request->get('owner_type');
        $instrument->customer_id = $request->get('customer_id') ?: null;
        $instrument->range = escape_output($request->get('range'));
        $instrument->accuracy = escape_output($request->get('accuracy'));
        $instrument->make = escape_output($request->get('make'));
        $instrument->calibration_due = date('Y-m-d', strtotime($request->get('calibration_due')));
        $instrument->remarks = escape_output($request->get('remarks'));
        $instrument->save();
        return redirect('instruments')->with(saveMessage());
    }
    public function destroy(Instrument $instrument)
    {
        $instrument->del_status = "Deleted";
        $instrument->save();
        return redirect('instruments')->with(deleteMessage());
    }
}
