<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\InstrumentCategory;
use App\Instrument;
use Illuminate\Validation\Rule;

class InstrumentCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
     public function index()
    {
        $obj = InstrumentCategory::orderBy('id','DESC')->where('del_status','Live')->get()->map(function($category) {
            $usedInInstrument = Instrument::where('category', $category->id)->where('del_status', 'Live')->exists();
            $category->used_in_instrument = $usedInInstrument;
            return $category;
        });
        $title =  __('index.instrument_category');
        return view('pages.instrument_category.index', compact('title','obj'));
    }
    public function create() {
        $title = __('index.add_instrument_category');
        return view('pages.instrument_category.addEditInstrumentCategory', compact('title'));
    }
    public function store(Request $request)
    {
        request()->validate([
            'type' => 'required',
            'category' => [
                'required',
                'regex:/^[\pL\s]+$/u',
                'max:50',
                Rule::unique('tbl_instrument_categories', 'category')->where(function ($query) use ($request) {
                    return $query->where('del_status', 'Live')->where('type', $request->type);
                }),
            ],
        ], [
            'type.required' => "The type field is required",
            'category.required' => "The instrument category field is required",
            'category.unique' => "The instrument category field already exists",
        ]);

        $obj = new \App\InstrumentCategory;
        $obj->type = escape_output($request->get('type'));
        $obj->category = ucwords(escape_output($request->get('category')));
        $obj->save();
        return redirect('instrument_category')->with(saveMessage());
    }
    public function edit($id)
    {
        $instrument_category = InstrumentCategory::find(encrypt_decrypt($id, 'decrypt'));
        $title =  __('index.edit_instrument_category');
        $obj = $instrument_category;
        return view('pages.instrument_category.addEditInstrumentCategory', compact('title', 'obj'));
    }
    public function update(Request $request, InstrumentCategory $instrument_category)
    {
        request()->validate([
            'type' => 'required',
            'category' => [
                'required',
                'max:50',
                Rule::unique('tbl_instrument_categories', 'category')
                ->ignore($instrument_category->id, 'id')
                ->where(function ($query) use ($request) {
                    return $query->where('del_status', 'Live')
                                ->where('type', $request->input('type'));
                }),
            ],
        ], [
            'type.required' => "The type field is required",
            'category.required' => "The instrument category field is required",
            'category.unique' => "The instrument category field already exists",
        ]);

        $instrument_category->type = escape_output($request->get('type'));
        $instrument_category->category = escape_output($request->get('category'));
        $instrument_category->save();
        return redirect('instrument_category')->with(updateMessage());
    }
    public function destroy(InstrumentCategory $instrument_category)
    {
        $instrument_category->del_status = "Deleted";
        $instrument_category->save();
        return redirect('instrument_category')->with(deleteMessage());
    }
}
