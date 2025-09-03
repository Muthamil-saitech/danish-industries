<?php

namespace App\Http\Controllers;

use App\Customer;
use App\MaterialStock;
use App\RawMaterial;
use App\RawMaterialCategory;
use App\RMPurchase_model;
use App\StockAdjustLog;
use App\Unit;
use App\Mrmitem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MaterialStockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        // dd($request->all());
        $title =  __('index.rm_stocks');
        $mat_id = escape_output($request->get('mat_id'));
        $mat_type = escape_output($request->get('mat_type'));
        $ins_type = escape_output($request->get('ins_type'));
        if ($mat_id != '' || $mat_type != '' || $ins_type != '') {
            $commonQuery = MaterialStock::where('del_status', 'Live');
            $obj = (clone $commonQuery)->orderBy('id', 'DESC')
                ->when($mat_id, fn($query) => $query->where('mat_id', $mat_id))
                ->when($mat_type, fn($query) => $query->where('mat_type', $mat_type))
                ->when($ins_type, fn($query) => $query->where('ins_type', $ins_type))
                ->get()
                ->map(function ($stock) {
                    $stock->used_in_manufacture = Mrmitem::where('stock_id', $stock->id)->exists();
                    return $stock;
                });
            $tot_mat = (clone $commonQuery)
                ->when($mat_id, fn($q) => $q->where('mat_id', $mat_id))
                ->when($mat_type, fn($q) => $q->where('mat_type', $mat_type))
                ->when($ins_type, fn($q) => $q->where('ins_type', $ins_type))
                ->where('mat_type', 1)
                ->count();
            $tot_raw_mat = (clone $commonQuery)
                ->when($mat_id, fn($q) => $q->where('mat_id', $mat_id))
                ->when($mat_type, fn($q) => $q->where('mat_type', $mat_type)) // added
                ->when($ins_type, fn($q) => $q->where('ins_type', $ins_type))
                ->where('mat_type', 2)
                ->count();
            $tot_ins = (clone $commonQuery)
                ->when($mat_id, fn($q) => $q->where('mat_id', $mat_id))
                ->when($mat_type, fn($q) => $q->where('mat_type', $mat_type)) // added
                ->when($ins_type, fn($q) => $q->where('ins_type', $ins_type))
                ->where('mat_type', 3)
                ->count();
            $tot_consumable = (clone $commonQuery)
                ->when($mat_id, fn($q) => $q->where('mat_id', $mat_id))
                ->when($mat_type, fn($q) => $q->where('mat_type', $mat_type))
                ->where('mat_type', 3)->where('ins_type', 1)
                ->count();
            $tot_non_cons = (clone $commonQuery)
                ->when($mat_id, fn($q) => $q->where('mat_id', $mat_id))
                ->when($mat_type, fn($q) => $q->where('mat_type', $mat_type))
                ->where('mat_type', 3)->where('ins_type', 2)
                ->count();
        } else {
            $obj = MaterialStock::orderBy('id', 'DESC')->where('del_status', "Live")->when($mat_id, function ($query, $mat_id) {
                return $query->where('mat_id', $mat_id);
            })->when($mat_type, function ($query, $mat_type) {
                return $query->where('mat_type', $mat_type);
            })->when($ins_type, function ($query, $ins_type) {
                return $query->where('ins_type', $ins_type);
            })->get()->map(function ($stock) {
                $stock->used_in_manufacture = Mrmitem::where('stock_id', $stock->id)->exists();
                return $stock;
            });
            $tot_mat = MaterialStock::where('mat_type', 1)->where('del_status', "Live")->count();
            $tot_raw_mat = MaterialStock::where('mat_type', 2)->where('del_status', "Live")->count();
            $tot_ins = MaterialStock::where('mat_type', 3)->where('del_status', "Live")->count();
            $tot_consumable = MaterialStock::where('mat_type', 3)->where('ins_type', 1)->where('del_status', "Live")->count();
            $tot_non_cons = MaterialStock::where('mat_type', 3)->where('ins_type', 2)->where('del_status', "Live")->count();
        }
        $material_ids = MaterialStock::where('del_status', "Live")
            ->where('mat_type', $mat_type)
            ->pluck('mat_id')
            ->unique();
        $materials = RawMaterial::whereIn('id', $material_ids)->get();
        $total_material_stocks = MaterialStock::where('del_status', "Live")->count();
        return view('pages.material_stock.materialstocks', compact('title', 'obj', 'materials', 'mat_id', 'mat_type', 'ins_type', 'tot_mat', 'tot_raw_mat', 'tot_ins', 'tot_consumable', 'tot_non_cons', 'total_material_stocks'));
    }
    public function create()
    {
        $title =  __('index.add_rm_stock');
        $units = Unit::where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        $mat_categories = RawMaterialCategory::where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        $materials = RawMaterial::where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        $customers = Customer::where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        return view('pages.material_stock.addEditMaterialStock', compact('title', 'mat_categories', 'materials', 'customers', 'units'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        request()->validate([
            'mat_cat_id' => 'required',
            'unit_id' => 'required',
            'mat_id' => 'required',
            'mat_type' => 'required',
            'current_stock' => 'required',
            'dc_no' => 'required|max:50',
            'heat_no' => 'required',
            'date' => 'required',
            'mat_doc_no' => 'max:100',
            // 'close_qty' => 'required',
        ]);

        $obj = new MaterialStock();
        $obj->mat_cat_id = $request->mat_cat_id;
        $exploded = explode('|', $request->mat_id);
        $obj->mat_id = $exploded[0];
        $obj->mat_type = $request->mat_type;
        $obj->unit_id = $request->unit_id;
        $obj->stock_type = $request->stock_type;
        $obj->old_mat_no = $request->old_mat_no;
        $obj->dc_no = $request->dc_no;
        $obj->heat_no = $request->heat_no;
        $obj->dc_date = date('Y-m-d', strtotime($request->date));
        $obj->mat_doc_no = $request->mat_doc_no;
        $obj->reference_no = $request->reference_no;
        $obj->ins_type = null;
        $obj->customer_id = ($request->mat_type == '1') ? $request->customer_id : ($request->customer_id ?: null);
        $obj->current_stock = $request->current_stock ? $request->current_stock : 0; //stock
        $obj->close_qty = $request->close_qty ? $request->close_qty : 0;
        $obj->float_stock = 0;
        $obj->dc_inward_price = !empty($request->dc_inward_price) ? $request->dc_inward_price : 0.00;
        $obj->material_price = !empty($request->material_price) ? $request->material_price : 0.00;
        $obj->hsn_no = $request->hsn_no ?? '';
        $obj->added_by = auth()->user()->id;
        $obj->save();
        return redirect('material_stocks')->with(saveMessage());
    }
    public function edit($id)
    {
        $title =  __('index.edit_rm_stock');
        $materialStock = MaterialStock::find(encrypt_decrypt($id, 'decrypt'));
        $units = Unit::where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        $mat_categories = RawMaterialCategory::where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        $materials = RawMaterial::where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        $customers = Customer::where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        $obj = $materialStock;
        if ($materialStock->stock_type == "purchase") {
            $purchases = RMPurchase_model::with('purchase')->where('rmaterials_id', $materialStock->mat_id)
                ->where('del_status', 'Live')
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $purchases = [];
        }
        return view('pages.material_stock.addEditMaterialStock', compact('title', 'obj', 'mat_categories', 'materials', 'customers', 'units', 'purchases'));
    }
    public function update(Request $request, MaterialStock $material_stock)
    {
        // dd($request->all());
        request()->validate([
            'mat_cat_id' => 'required',
            'unit_id' => 'required',
            'mat_id' => 'required',
            'mat_type' => 'required',
            'current_stock' => 'required',
            'dc_no' => 'required|max:50',
            'heat_no' => 'required',
            'date' => 'required',
            'mat_doc_no' => 'max:100',
            // 'close_qty' => 'required',
        ]);
        $material_stock->mat_cat_id = $request->mat_cat_id;
        $exploded = explode('|', $request->mat_id);
        $material_stock->mat_id = $exploded[0];
        $material_stock->mat_type = $request->mat_type;
        $material_stock->stock_type = $request->stock_type;
        $material_stock->reference_no = $request->reference_no;
        $material_stock->old_mat_no = $request->old_mat_no;
        $material_stock->dc_no = $request->dc_no;
        $material_stock->heat_no = $request->heat_no;
        $material_stock->dc_date = date('Y-m-d', strtotime($request->date));
        $material_stock->mat_doc_no = $request->mat_doc_no;
        $material_stock->ins_type = null;
        $material_stock->customer_id = ($request->mat_type == '1') ? $request->customer_id : ($request->customer_id ?: null);
        $material_stock->unit_id = $request->unit_id;
        $material_stock->current_stock = $request->current_stock ? $request->current_stock : 0;
        $material_stock->close_qty = $request->close_qty ? $request->close_qty : 0;
        $material_stock->dc_inward_price = !empty($request->dc_inward_price) ? $request->dc_inward_price : 0.00;
        $material_stock->material_price = !empty($request->material_price) ? $request->material_price : 0.00;
        $material_stock->hsn_no = $request->hsn_no ?? '';
        $material_stock->added_by = auth()->user()->id;
        $material_stock->save();
        return redirect('material_stocks')->with(updateMessage());
    }
    public function destroy(MaterialStock $material_stock)
    {
        $material_stock->del_status = "Deleted";
        $material_stock->save();
        return redirect('material_stocks')->with(deleteMessage());
    }
    public function materialStockAdjust(Request $request)
    {
        $mat_id = $request->mat_id;
        $mat_stock_id = $request->mat_stock_id;
        $adj_type = $request->adj_type;
        $stock_qty = $request->stock_qty;
        $stock_type = $request->stock_type;
        $reference_no = $request->reference_no;
        $dc_no = $request->dc_no;
        $mat_doc_no = $request->mat_doc_no;
        $heat_no = $request->heat_no;
        $dc_inward_price = !empty($request->dc_inward_price) ? $request->dc_inward_price : 0.00;
        $material_price = !empty($request->material_price) ? $request->material_price : 0.00;
        $hsn_no = $request->hsn_no ?? '';
        $dc_date = date('Y-m-d', strtotime($request->dc_date));
        $old_stock = MaterialStock::where('del_status', 'Live')->where('id', $mat_id)->sum('current_stock');
        if ($adj_type == "subtraction" && $old_stock <= $stock_qty) {
            return response()->json(['status' => false, 'message' => 'Stock quantity not enough to subtract.']);
        }
        $obj = new StockAdjustLog();
        $obj->mat_stock_id = $mat_stock_id;
        $obj->type = $adj_type;
        $obj->quantity = $stock_qty;
        $obj->stock_type = $stock_type;
        $obj->reference_no = $reference_no;
        $obj->dc_no = $dc_no;
        $obj->mat_doc_no = $mat_doc_no;
        $obj->heat_no = $heat_no;
        $obj->dc_date = $dc_date;
        $obj->dc_inward_price = $dc_inward_price;
        $obj->material_price = $material_price;
        $obj->hsn_no = $hsn_no;
        $obj->added_by = auth()->user()->id;
        $obj->save();
        $material_stock = MaterialStock::find($mat_stock_id);
        if ($adj_type == "addition") {
            $material_stock->current_stock = $material_stock->current_stock + $stock_qty;
        } else {
            $material_stock->current_stock = $material_stock->current_stock - $stock_qty;
        }
        $material_stock->save();
        return response()->json(['status' => true, 'message' => 'Stock adjusted successfully.']);
    }
    public function stock_adjustments($id)
    {
        $title =  __('index.stock_adjustment_list');
        $stock_id = encrypt_decrypt($id, 'decrypt');
        $stock_adjustments = StockAdjustLog::where('mat_stock_id', $stock_id)->where('del_status', 'Live')->get();
        $material_stock = MaterialStock::where('id', $stock_id)->where('del_status', 'Live')->first();
        if ($material_stock) {
            $material = RawMaterial::where('id', $material_stock->mat_id)->where('del_status', 'Live')->first();
        } else {
            $material = null;
        }
        return view('pages.material_stock.stockAdjustmentLog', compact('title', 'stock_adjustments', 'material_stock', 'material'));
    }
}
