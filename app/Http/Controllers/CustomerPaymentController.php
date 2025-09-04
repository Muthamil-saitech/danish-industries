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
  # This is CustomerPaymentController Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Customer;
use App\CustomerDueReceive;
use App\User;
use App\Account;
use Barryvdh\DomPDF\Facade\Pdf;
use App\AdminSettings;
use App\CustomerOrder;
use App\CustomerOrderInvoice;
use App\FinishedProduct;


class CustomerPaymentController extends Controller
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
        $customer_id = escape_output($request->get('customer_id'));
        unset($request->_token);
        $order = CustomerOrder::with('orderInvoice')->where('order_status',1)->where('del_status',"Live");
        if (isset($request->startDate) && $request->startDate != '') {
            $startDate = date('Y-m-d 00:00:00', strtotime($request->startDate));
            $order->where('created_at', '>=', $startDate);
        }
        if (isset($request->endDate) && $request->endDate != '') {
            $endDate = date('Y-m-d 23:59:59', strtotime($request->endDate));
            $order->where('created_at', '<=', $endDate);
        }
        if (isset($customer_id) && $customer_id != '') {
            $order->where('customer_id', $customer_id);
        }
        $obj = $order->orderBy('id', 'DESC')->get();
        $title =  __('index.customer_due_receives');
        $customers = Customer::where('del_status','Live')->orderBy('id','DESC')->get();
        // dd($obj);
        return view('pages.customer_payment.index',compact('title','obj','customers','customer_id', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title =  __('index.add_customer_receive');

        $total_customerdue = CustomerDueReceive::count();
        $ref_no = str_pad($total_customerdue + 1, 6, '0', STR_PAD_LEFT);

        $company_id = auth()->user()->company_id;

        $customers = Customer::where('del_status',"Live")->get();
        $accountList = Account::where('del_status',"Live")->get();

        return view('pages.customer_payment.create',compact('title', 'ref_no', 'customers', 'accountList'));
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
            'reference_no' => 'required',
            'only_date' => 'required|date',
            'customer_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'account_id' => 'required'
        ],
            [
                'reference_no.required' => __('index.reference_no_required'),
                'only_date.required' => __('index.date_required'),
                'customer_id.required' => __('index.customer_required'),
                'amount.required' => __('index.amount_required'),
                'account_id.required' => __('index.account_required')
            ]
        );

        $obj = new \App\CustomerDueReceive;
        $obj->reference_no = escape_output($request->reference_no);
        $obj->only_date = escape_output($request->only_date);
        $obj->customer_id = escape_output($request->customer_id);
        $obj->amount = escape_output($request->amount);
        $obj->account_id = escape_output($request->account_id);
        $obj->note = escape_output($request->note);
        $obj->user_id = auth()->user()->id;
        $obj->company_id = auth()->user()->company_id;
        $obj->save();

        return redirect('customer-payment')->with(saveMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $customer_payment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer_payment = CustomerDueReceive::find(encrypt_decrypt($id, 'decrypt'));
        $title =  __('index.edit_customer_due_receive');
        $obj = $customer_payment;

        $company_id = auth()->user()->company_id;

        $customers = Customer::where('del_status',"Live")->get();
        $accountList = Account::where('del_status',"Live")->get();

        return view('pages.customer_payment.edit',compact('title','obj', 'customers', 'accountList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $customer_payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerDueReceive $customer_payment)
    {
        request()->validate([
            'reference_no' => 'required',
            'only_date' => 'required|date',
            'customer_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'account_id' => 'required'
        ],
            [
                'reference_no.required' => __('index.reference_no_required'),
                'only_date.required' => __('index.date_required'),
                'customer_id.required' => __('index.customer_required'),
                'amount.required' => __('index.amount_required'),
                'account_id.required' => __('index.account_required')
            ]
        );

        $customer_payment->reference_no = escape_output($request->reference_no);
        $customer_payment->only_date = escape_output($request->only_date);
        $customer_payment->customer_id = escape_output($request->customer_id);
        $customer_payment->amount = escape_output($request->amount);
        $customer_payment->account_id = escape_output($request->account_id);
        $customer_payment->note = escape_output($request->note);
        $customer_payment->save();

        return redirect('customer-payment')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $customer_payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerDueReceive $customer_payment)
    {
        $customer_payment->del_status = "Deleted";
        $customer_payment->save();
        return redirect('customer-payment')->with(deleteMessage());
    }
	
	public function download($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $title = __('index.customer_payment_invoice');

        $company = AdminSettings::orderBy('name_company_name', 'ASC')->where('del_status', "Live")->get();

        $customers = Customer::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $finishProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $fifoProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->where('stock_method', "fifo")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();

        $obj = CustomerDueReceive::findOrFail($id);
        
        return view('pages.customer_payment.invoice', compact('title', 'obj', 'customers', 'accounts', 'company'));
    }

    /* public function print($id)
    {
        $title = __('index.customer_payment_invoice');
        $obj = CustomerDueReceive::findOrFail($id);

        $customers = Customer::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $company = AdminSettings::orderBy('name_company_name', 'ASC')->where('del_status', "Live")->get();

        return view('pages.customer_payment.print_invoice', compact('title', 'obj', 'customers', 'accounts', 'company'));
    } */
   public function print($id)
    {
        $title = __('index.customer_payment_invoice');
        $customer_order = CustomerOrder::find($id);
        $customer_inv = CustomerOrderInvoice::where('customer_order_id',$id)->first();
        $customer_due_entries = CustomerDueReceive::where('order_id',$id)->orderBy('id','DESC')->get();
        $obj = $customer_order;
        $company = AdminSettings::orderBy('name_company_name', 'ASC')->where('del_status', "Live")->get();
        return view('pages.customer_payment.print_invoice', compact('title', 'obj', 'customer_inv', 'customer_due_entries', 'company'));
    }
    /* public function updatePayType(Request $request) {
        $payment_type = $request->payment_type;
        $order_id = $request->order_id;
        $order_details = CustomerOrder::with('orderInvoice')->where('id',$order_id)->where('del_status',"Live")->orderBy('id','DESC')->first();
        if ($order_details) {
            dd($order_details);
            // $qc_log->qc_status = $status;
            // $qc_log->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'QC not found.']);
        }
    } */
    public function customerDueEntry(Request $request) {
        // dd($request->all());
        $order_id = $request->order_id;
        $total_amount = $request->total_amount;
        $balance_amount = $request->balance_amount;
        $pay_amount = $request->pay_amount;
        $payment_type = $request->payment_type;
        $note = $request->note;
        $customer_order = CustomerOrder::where('id',$order_id)->where('order_status',1)->where('del_status','Live')->first();
        $customer_due = new CustomerDueReceive();
        $customer_due->order_id = $order_id;
        $customer_due->reference_no = $customer_order->reference_no;
        $customer_due->order_date = date('Y-m-d', strtotime($customer_order->created_at));
        $customer_due->customer_id = $customer_order->customer_id;
        $customer_due->total_amount = $total_amount;
        $customer_due->pay_amount = $pay_amount;
        $customer_due->balance_amount = $balance_amount - $pay_amount;
        $customer_due->payment_type = $payment_type;
        $customer_due->note = $note;
        $proofName = '';
        if ($request->hasFile('payment_img')) {
            if ($request->hasFile('payment_img')) {
                $payment_img = $request->file('payment_img');
                $filename = $payment_img->getClientOriginalName();
                $proofName = time() . "_" . $filename;
                $payment_img->move(base_path() . '/uploads/customer_due/', $proofName);
            }
            $customer_due->payment_proof = $proofName;
        }
        $customer_due->user_id = auth()->user()->id;
        // $customer_due->save();
        $order_invoice = CustomerOrderInvoice::where('customer_order_id',$order_id)->where('del_status','Live')->first();
        // dd($order_invoice);
        $order_invoice->paid_amount = $order_invoice->paid_amount + $pay_amount;
        $order_invoice->due_amount = $order_invoice->amount - $order_invoice->paid_amount;
        $order_invoice->save();
        return redirect('customer-payment')->with(saveMessage());
    }
    public function dueEntry($id) {
        $customer_order = CustomerOrder::find(encrypt_decrypt($id, 'decrypt'));
        $customer_inv = CustomerOrderInvoice::where('customer_order_id',encrypt_decrypt($id, 'decrypt'))->first();
        $title = __('index.customer_payment_invoice');
        $obj = $customer_order;
        $customer_due_entries = CustomerDueReceive::where('order_id',encrypt_decrypt($id, 'decrypt'))->orderBy('id','DESC')->get();
        // dd($customer_due_entries);
        return view('pages.customer_payment.invoice', compact('title', 'obj', 'customer_due_entries','customer_inv'));
    }
}
