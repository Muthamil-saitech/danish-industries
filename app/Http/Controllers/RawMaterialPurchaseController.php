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
  # This is RawMaterialPurchaseController
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Account;
use App\AdminSettings;
use App\CustomerOrder;
use App\FinishedProduct;
use App\Manufacture;
use App\RawMaterial;
use App\RawMaterialPurchase;
use App\RMPurchase_model;
use App\Supplier;
use App\Unit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RawMaterialPurchaseController extends Controller
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
    public function index(Request $request)
    {
        $startDate = '';
        $endDate = '';
        $supplier_id = escape_output($request->get('supplier_id'));
        unset($request->_token);
        $purchase = RawMaterialPurchase::with('supplierPayments')->where('del_status','Live');
        if (isset($request->startDate) && $request->startDate != '') {
            $startDate = $request->startDate;
            $purchase->where('date', '>=', date('Y-m-d',strtotime($request->startDate)));
        }
        if (isset($request->endDate) && $request->endDate != '') {
            $endDate = $request->endDate;
            $purchase->where('date', '<=', date('Y-m-d',strtotime($request->endDate)));
        }
        if (isset($supplier_id) && $supplier_id != '') {
            $purchase->where('supplier', $supplier_id);
        }
        $obj = $purchase->orderBy('id', 'DESC')->get();
        $suppliers = Supplier::where('del_status','Live')->orderBy('id','DESC')->get();
        $title = __('index.supplier_purchase');
        return view('pages.purchase.purchases', compact('title', 'obj', 'startDate', 'endDate', 'supplier_id', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('index.add_purchase');
        $suppliers = Supplier::orderBy('id', 'DESC')->where('del_status', "Live")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        // $rmaterials = RawMaterial::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $manufactures = Manufacture::orderBy('reference_no', 'ASC')->where('manufacture_status', '!=', 'done')->where('del_status', "Live")->get();
        $units = Unit::where('del_status', "Live")->get();
        $products = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $orders = CustomerOrder::orderBy('id', 'ASC')->where('del_status', "Live")->get();
        return view('pages.purchase.addEditPurchase', compact('title', 'suppliers', 'accounts', 'manufactures', 'products', 'orders','units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        request()->validate([
            /* 'reference_no' => [
                'required',
                'max:50',
                Rule::unique('tbl_purchase', 'reference_no')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ], */
            'supplier' => 'required|max:50',
            // 'paid' => 'required|max:50',
            // 'account' => 'required|max:50',
            'file_button' => 'max:5120',
            'date' => 'required|max:50',
            // 'status' => 'required',
        ]);
        $obj = new \App\RawMaterialPurchase;
        $prefix = 'SPO';
        $lastRecord = RawMaterialPurchase::where('reference_no', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->reference_no, strlen($prefix)));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
        $obj->reference_no = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        // $obj->reference_no = null_check(escape_output($request->get('reference_no')));
        $obj->supplier = null_check(escape_output($request->get('supplier')));
        $obj->date = date('Y-m-d',strtotime(escape_output($request->get('date'))));
        $file = '';
        if ($request->hasFile('file_button')) {
            if ($request->hasFile('file_button')) {
                $image = $request->file('file_button');
                $filename = $image->getClientOriginalName();
                $file = time() . "_" . $filename;
                $request->file_button->move(base_path('uploads/purchase'), $file);
            }
        }
        $obj->file = $file;
        $obj->subtotal = null_check(escape_output($request->get('subtotal')));
        $obj->grand_total = null_check(escape_output($request->get('grand_total')));
        $obj->paid = null_check(escape_output($request->get('paid')));
        $obj->due = null_check(escape_output($request->get('due')));
        $obj->other = null_check(escape_output($request->get('other')));
        $obj->discount = null_check(escape_output($request->get('discount')));
        $obj->note = escape_output($request->get('note'));
        $obj->status = 'Draft';
        $obj->account = null_check(escape_output($request->get('account')));
        $obj->invoice_no = null_check(escape_output($request->get('invoice_no')));
        $obj->added_by = auth()->user()->id;
        // $matTypes = $request->input('mat_type');
        // if (is_array($matTypes)) {
        //     $joinedMatType = implode(',', $matTypes);
        // } else {
        //     $joinedMatType = $matTypes;
        // }
        $obj->mat_type = $request->input('mat_type');
        // $obj->ins_type = escape_output($request->get('ins_type'));
        /* if($request->get('change_currency')){
            $obj->converted_currency_id = null_check(escape_output($request->get('currency_id')));
            $obj->converted_amount = null_check(escape_output($request->get('converted_amount')));
        } */
        $obj->save();
        $last_id = $obj->id;

        $rm_id = $request->get('rm_id');
        foreach ($rm_id as $row => $value) {
            $obj = new \App\RMPurchase_model;
            $obj->rmaterials_id = null_check($value);
            $obj->mat_unit = null_check(escape_output($_POST['mat_unit'][$row]));
            $obj->unit_price = null_check(escape_output($_POST['unit_price'][$row]));
            $obj->quantity_amount = null_check(escape_output($_POST['quantity_amount'][$row]));
            $obj->total = null_check(escape_output($_POST['total'][$row]));
            $obj->purchase_id = null_check($last_id);
            $obj->save();
        }
        return redirect('rawmaterialpurchases')->with(saveMessage());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RawMaterialPurchase  $rawmaterialpurchase
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rawmaterialpurchase = RawMaterialPurchase::find(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.view_purchase_details');
        $company = AdminSettings::orderBy('name_company_name', 'ASC')->where('del_status', "Live")->get();
        $obj = RawMaterialPurchase::find($rawmaterialpurchase->id);
        $suppliers = Supplier::where('id', $rawmaterialpurchase->supplier)->get();
        $rmaterials = RawMaterial::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $pruchse_rmaterials = RMPurchase_model::where('purchase_id', $rawmaterialpurchase->id)->where('del_status', "Live")->get();
        return view('pages.purchase.viewDetails', compact('title', 'company', 'obj', 'suppliers', 'rmaterials', 'pruchse_rmaterials', 'accounts'));
    }

    public function printPurchase($id)
    {
        $title = __('index.view_purchase_details');
        $company = AdminSettings::orderBy('name_company_name', 'ASC')->where('del_status', "Live")->get();
        $obj = RawMaterialPurchase::find($id);
        $suppliers = Supplier::where('id', $obj->supplier)->get();
        $rmaterials = RawMaterial::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $pruchse_rmaterials = RMPurchase_model::where('purchase_id', $id)->where('del_status', "Live")->get();
        $setting = getSettingsInfo();
        return view('pages.purchase.print_purchase_invoice', compact('title', 'company', 'obj', 'suppliers', 'rmaterials', 'pruchse_rmaterials', 'accounts', 'setting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RawMaterialPurchase  $rawmaterialpurchase
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rawmaterialpurchase = RawMaterialPurchase::find(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.edit_purchase');
        $obj = $rawmaterialpurchase;
        $suppliers = Supplier::orderBy('id', 'DESC')->where('del_status', "Live")->get();
        // $rmaterials = RawMaterial::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $pruchse_rmaterials = RMPurchase_model::orderBy('id', 'ASC')->where('purchase_id', $rawmaterialpurchase->id)->where('del_status', "Live")->get();
        $products = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $orders = CustomerOrder::orderBy('id', 'ASC')->where('del_status', "Live")->get();
        $units = Unit::where('del_status', "Live")->get();
        return view('pages.purchase.addEditPurchase', compact('title', 'obj', 'suppliers', 'pruchse_rmaterials', 'accounts', 'products', 'orders','units'));
    }

    /**
     * Download Invoice
     */

    public function downloadPurchase($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $obj = RawMaterialPurchase::find($id);
        $company = AdminSettings::orderBy('name_company_name', 'ASC')->where('del_status', "Live")->get();
        $suppliers = Supplier::where('id', $obj->supplier)->get();
        $rmaterials = RawMaterial::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $pruchse_rmaterials = RMPurchase_model::where('purchase_id', $obj->id)->where('del_status', "Live")->get();
        $setting = getSettingsInfo();
        $pdf = PDF::loadView('pages.purchase.print_purchase_invoice', compact('obj', 'company', 'suppliers', 'rmaterials', 'pruchse_rmaterials', 'accounts', 'setting'))->setPaper('a4', 'landscape');
        return $pdf->download($obj->reference_no . '.pdf');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RawMaterialPurchase  $rawmaterialpurchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RawMaterialPurchase $rawmaterialpurchase)
    {
        // dd($request->all());
        request()->validate([
            /* 'reference_no' => [
                'required',
                'max:50',
                Rule::unique('tbl_purchase', 'reference_no')->ignore($rawmaterialpurchase->id,'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ], */
            'supplier' => 'required|max:50',
            'file_button' => 'max:5120',
            'date' => 'required|max:50',
        ]);

        // $rawmaterialpurchase->reference_no = null_check(escape_output($request->get('reference_no')));
        $rawmaterialpurchase->supplier = null_check(escape_output($request->get('supplier')));
        $rawmaterialpurchase->date = date('Y-m-d',strtotime(escape_output($request->get('date'))));
        $rawmaterialpurchase->subtotal = null_check(escape_output($request->get('subtotal')));
        $rawmaterialpurchase->grand_total = null_check(escape_output($request->get('grand_total')));
        $rawmaterialpurchase->paid = null_check(escape_output($request->get('paid')));
        $rawmaterialpurchase->due = null_check(escape_output($request->get('due')));
        $rawmaterialpurchase->other = null_check(escape_output($request->get('other')));
        $rawmaterialpurchase->discount = null_check(escape_output($request->get('discount')));
        $rawmaterialpurchase->note = (escape_output($request->get('note')));
        $rawmaterialpurchase->account = null_check(escape_output($request->get('account')));
        $rawmaterialpurchase->invoice_no = null_check(escape_output($request->get('invoice_no')));
        /* $matTypes = $request->input('mat_type');
        if (is_array($matTypes)) {
            $joinedMatType = implode(',', $matTypes);
        } else {
            $joinedMatType = $matTypes;
        } */
        $rawmaterialpurchase->mat_type = $request->input('mat_type');
        // $rawmaterialpurchase->ins_type = escape_output($request->get('ins_type'));
        /* if($request->get('change_currency')){
            $obj->converted_currency_id = null_check(escape_output($request->get('currency_id')));
            $obj->converted_amount = null_check(escape_output($request->get('converted_amount')));
        } */
        $file = '';
        if ($request->hasFile('file_button')) {
            $image = $request->file('file_button');
            $filename = $image->getClientOriginalName();
            $file = time() . "_" . $filename;
            $request->file_button->move(base_path('uploads/purchase'), $file);
        }
        $rawmaterialpurchase->file = ($file == '' ? $request->file_old : $file);
        $rawmaterialpurchase->added_by = auth()->user()->id;
        $rawmaterialpurchase->save();

        //delete previous data before add
        RMPurchase_model::where('purchase_id', $rawmaterialpurchase->id)->update(['del_status' => "Deleted"]);

        $rm_id = $request->get('rm_id');
        foreach ($rm_id as $row => $value) {
            $obj = new \App\RMPurchase_model;
            $obj->rmaterials_id = null_check($value);
            $obj->mat_unit = null_check(escape_output($_POST['mat_unit'][$row]));
            $obj->unit_price = null_check(escape_output($_POST['unit_price'][$row]));
            $obj->quantity_amount = null_check(escape_output($_POST['quantity_amount'][$row]));
            $obj->total = null_check(escape_output($_POST['total'][$row]));
            $obj->purchase_id = null_check($rawmaterialpurchase->id);
            $obj->save();
        }
        return redirect('rawmaterialpurchases')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RawMaterialPurchase  $rawmaterialpurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(RawMaterialPurchase $rawmaterialpurchase)
    {
        //delete previous data before add
        RMPurchase_model::where('purchase_id', $rawmaterialpurchase->id)->update(['del_status' => "Deleted"]);

        $rawmaterialpurchase->del_status = "Deleted";
        $rawmaterialpurchase->save();
        return redirect('rawmaterialpurchases')->with(deleteMessage());
    }

    public function purchaseGenerate(Request $request)
    {
        $rm_id = [];
        $shortage = [];
        if($request->rm_id!='') {
            foreach ($request->rm_id as $key => $value) {
                if($request->status[$key] == "need_purchase"){
                    $rm_id[] = $value;
                    $shortage[] = $request->shortage[$key];
                }
            }
        }

        $title = __('index.add_purchase');
        $suppliers = Supplier::orderBy('id', 'DESC')->where('del_status', "Live")->get();
        $obj_rm = RawMaterialPurchase::count();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $rmaterials = RawMaterial::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        //generate code
        $ref_no = "PO-" . str_pad($obj_rm + 1, 6, '0', STR_PAD_LEFT);
        $pruchse_rmaterials = RMPurchase_model::orderBy('id', 'DESC')->whereIn('rmaterials_id', $rm_id)->where('del_status', "Live")->take(count($rm_id))->get();
        $subtotal_shoratage = 0;
        foreach ($pruchse_rmaterials as $key => $value) {
            $value->shortage = $shortage[$key];
            $value->shortage_total = $value->rate_per_unit * $shortage[$key];
            $subtotal_shoratage += $value->shortage_total;
        }

        if(count($pruchse_rmaterials) <= 0){
            $pruchse_rmaterials = RawMaterial::whereIn('id', $rm_id)->get();
            
            foreach ($pruchse_rmaterials as $key => $value) {
                $value->shortage = $shortage[$key];
                $value->shortage_total = $value->rate_per_unit * $shortage[$key];
                $subtotal_shoratage += $value->shortage_total;
                $value->rmaterials_id = $value->id;
                $value->unit_price = $value->rate_per_unit;
                $value->total = $value->rate_per_unit * $shortage[$key];
            }
        }

        $manufactures = Manufacture::orderBy('reference_no', 'ASC')->where('manufacture_status', '!=', 'done')->where('del_status', "Live")->get();
        $products = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $orders = CustomerOrder::orderBy('id', 'ASC')->where('del_status', "Live")->get();
        $units = Unit::where('del_status', "Live")->get();
        // dd($pruchse_rmaterials);
        return view('pages.purchase.addEditPurchase', compact('title', 'ref_no', 'suppliers', 'rmaterials', 'accounts', 'pruchse_rmaterials', 'subtotal_shoratage', 'manufactures', 'products', 'orders','units'));
    }

    public function generatePurchase($id)
    {
        $rawmaterialpurchase = RawMaterialPurchase::find(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.edit_purchase');
        $obj = $rawmaterialpurchase;
        $suppliers = Supplier::orderBy('id', 'DESC')->where('del_status', "Live")->get();
        $rmaterials = RawMaterial::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $pruchse_rmaterials = RMPurchase_model::orderBy('id', 'ASC')->where('purchase_id', $rawmaterialpurchase->id)->where('del_status', "Live")->get();
        $products = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $orders = CustomerOrder::orderBy('id', 'ASC')->where('del_status', "Live")->get();
        $obj_rm = RawMaterialPurchase::count();
        $ref_no = "PO-" . str_pad($obj_rm + 1, 6, '0', STR_PAD_LEFT);
        return view('pages.purchase.generate_purchase', compact('title', 'obj', 'suppliers', 'rmaterials', 'pruchse_rmaterials', 'accounts', 'products', 'orders', 'ref_no'));
    }
    public function updatePurchaseStatus(Request $request) {
        // dd($request->all());
        $status = $request->status;
        $purchase_id = $request->purchase_id;
        $purchase = RawMaterialPurchase::find($purchase_id);
        if ($purchase) {
            $purchase->status = $status;
            $purchase->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Purchase not found.']);
        }
    }
}
