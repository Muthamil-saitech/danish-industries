<?php
/*
##############################################################################
# iProduction - Production and Manufacture Management Software
##############################################################################
# AUTHOR:        Door Soft
##############################################################################
# EMAIL:        info@doorsoft.co
##############################################################################
# COPYRIGHT:        RESERVED BY Door Soft
##############################################################################
# WEBSITE:        https://www.doorsoft.co
##############################################################################
# This is SupplierPaymentController
##############################################################################
 */

namespace App\Http\Controllers;

use App\Account;
use App\AdminSettings;
use App\FinishedProduct;
use App\RawMaterialPurchase;
use App\Supplier;
use App\Supplier_payment;
use App\Customer;
use App\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SupplierPaymentController extends Controller
{
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
        $purchase = RawMaterialPurchase::with('supplierPayments')->where('status','Completed')->where('del_status','Live');
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
        $title = __('index.supplier_due_payment');
        $suppliers = Supplier::where('del_status','Live')->orderBy('id','DESC')->get();
        return view('pages.supplier_payment.index', compact('title', 'obj', 'suppliers', 'startDate', 'endDate', 'supplier_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('index.add_supplier_due_payment');

        $company_id = auth()->user()->company_id;

        $suppliers = Supplier::where('company_id', $company_id)->where('del_status', "Live")->get();
        $accountList = Account::where('del_status', "Live")->get();

        return view('pages.supplier_payment.create', compact('title', 'suppliers', 'accountList'));
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
            'date' => 'required|date',
            'supplier' => 'required',
            'amount' => 'required|numeric',
            'account_id' => 'required',
        ],
            [
                'date.required' => __('index.date_required'),
                'amount.required' => __('index.amount_required'),
                'account_id.required' => __('index.account_required'),
            ]);

        $obj = new \App\Supplier_payment;
        $obj->date = escape_output($request->date);
        $obj->supplier = escape_output($request->supplier);
        $obj->amount = escape_output($request->amount);
        $obj->account_id = escape_output($request->account_id);
        $obj->note = escape_output($request->note);
        $obj->added_by = auth()->user()->id;
        $obj->company_id = auth()->user()->company_id;
        $obj->save();

        return redirect('supplier-payment')->with(saveMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $supplier_payment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier_payment = Supplier_payment::find(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.edit_supplier_due_payment');
        $obj = $supplier_payment;

        $company_id = auth()->user()->company_id;

        $suppliers = Supplier::where('company_id', $company_id)->where('del_status', "Live")->get();
        $accountList = Account::where('del_status', "Live")->get();

        return view('pages.supplier_payment.edit', compact('title', 'obj', 'suppliers', 'accountList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $supplier_payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier_payment $supplier_payment)
    {
        request()->validate([
            'date' => 'required|date',
            'supplier' => 'required',
            'amount' => 'required|numeric',
            'account_id' => 'required',
        ], [
            'date.required' => __('index.date_required'),
            'amount.required' => __('index.amount_required'),
            'account_id.required' => __('index.account_required'),
        ]);

        $supplier_payment->date = escape_output($request->date);
        $supplier_payment->supplier = escape_output($request->supplier);
        $supplier_payment->amount = escape_output($request->amount);
        $supplier_payment->account_id = escape_output($request->account_id);
        $supplier_payment->note = escape_output($request->note);
        $supplier_payment->save();
        return redirect('supplier-payment')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $supplier_payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier_payment $supplier_payment)
    {
        $supplier_payment->del_status = "Deleted";
        $supplier_payment->save();
        return redirect('supplier-payment')->with(deleteMessage());
    }

    public function download($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $title = __('index.supplier_payment_invoice');

        $company = AdminSettings::orderBy('name_company_name', 'ASC')->where('del_status', "Live")->get();

        $suppliers = Supplier::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $finishProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $fifoProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->where('stock_method', "fifo")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();

        $obj = Supplier_payment::findOrFail($id);
        
        return view('pages.supplier_payment.invoice', compact('title', 'obj', 'suppliers', 'accounts', 'company'));
    }

    public function print($id)
    {
        $title = __('index.supplier_payment_invoice');

        $obj = Supplier_payment::findOrFail($id);
        $suppliers = Supplier::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $company = AdminSettings::orderBy('name_company_name', 'ASC')->where('del_status', "Live")->get();

        return view('pages.supplier_payment.print_invoice', compact('title', 'obj', 'suppliers', 'accounts', 'company'));
    }
    public function updateSupplierPayStatus(Request $request) {
        $status = $request->status;
        $purchase_id = $request->purchase_id;
        $purchase = RawMaterialPurchase::find($purchase_id);
        if ($purchase) {
            $supplier_payment = new Supplier_payment();
            $supplier_payment->purchase_id = $purchase_id;
            $supplier_payment->purchase_no = $purchase->reference_no;
            $supplier_payment->purchase_date = date('Y-m-d',strtotime($purchase->date));
            $supplier_payment->supplier = $purchase->supplier;
            $supplier_payment->amount = $purchase->subtotal;
            $supplier_payment->pay_amount = $purchase->paid;
            $supplier_payment->bal_amount = $purchase->due;
            $supplier_payment->payment_status = 2;
            $supplier_payment->added_by = auth()->user()->id;
            $supplier_payment->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully.']);
        } else {
            return response()->json(['status' => false, 'message' => 'Purchase not found.']);
        }
    }
    public function supplierPayEntry(Request $request) {
        // dd($request->all());
        $purchase_id = $request->purchase_id;
        $total_amount = $request->total_amount;
        $balance_amount = $request->balance_amount;
        $pay_amount = $request->pay_amount;
        $payment_type = $request->payment_type;
        $note = $request->note;
        $purchase = RawMaterialPurchase::where('id',$purchase_id)->where('status','Completed')->where('del_status','Live')->first();
        $supplier_pay = new Supplier_payment();
        $supplier_pay->purchase_id = $purchase_id;
        $supplier_pay->purchase_no = $purchase->reference_no;
        $supplier_pay->purchase_date = date('Y-m-d', strtotime($purchase->date));
        $supplier_pay->supplier = $purchase->supplier;
        $supplier_pay->amount = $total_amount;
        $supplier_pay->pay_amount = $pay_amount;
        if($pay_amount==$total_amount) {
            $supplier_pay->payment_status = 4;
        } else {
            $supplier_pay->payment_status = 3;
        }
        $supplier_pay->bal_amount = $balance_amount - $pay_amount;
        $supplier_pay->pay_type = $payment_type;
        $supplier_pay->note = $note;
        $proofName = '';
        if ($request->hasFile('payment_img')) {
            if ($request->hasFile('payment_img')) {
                $payment_img = $request->file('payment_img');
                $filename = $payment_img->getClientOriginalName();
                $proofName = time() . "_" . $filename;
                $payment_img->move(base_path() . '/uploads/supplier_payments/', $proofName);
            }
            $supplier_pay->payment_proof = $proofName;
        }
        $supplier_pay->added_by = auth()->user()->id;
        $supplier_pay->save();
        $material_purchase = RawMaterialPurchase::where('id',$purchase_id)->first();
        $material_purchase->paid = $material_purchase->paid + $pay_amount;
        $material_purchase->due = $balance_amount - $pay_amount;
        $material_purchase->save();
        return redirect('supplier-payment')->with(saveMessage());
    }
    public function supplierEntry($id) {
        $purchase = RawMaterialPurchase::find(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.supplier_payment_invoice');
        $obj = $purchase;
        $supplier_pay_entries = Supplier_payment::where('purchase_id',encrypt_decrypt($id, 'decrypt'))->orderBy('id','DESC')->where('pay_amount','!=',0)->get();
        $supplier = Supplier::where('del_status', "Live")->where('id',$purchase->supplier)->first();
        // dd($purchase->id);
        return view('pages.supplier_payment.invoice', compact('title', 'obj', 'supplier_pay_entries','supplier'));
    }
}
