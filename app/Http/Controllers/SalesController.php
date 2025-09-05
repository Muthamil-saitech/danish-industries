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
# This is SalesController
##############################################################################
 */

namespace App\Http\Controllers;

use App\Account;
use App\AdminSettings;
use App\Customer;
use App\CustomerOrder;
use App\FinishedProduct;
use App\Manufacture;
use App\SaleDetail;
use App\Sales;
use App\Quotation;
use App\QuotationDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
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
        $salesQuery = DB::table('tbl_sales as s')
            ->leftJoin('tbl_sale_details as sd', 's.id', '=', 'sd.sale_id')
            ->leftJoin('tbl_quotations as q', 'q.id', '=', 's.challan_id')
            ->where('s.del_status', 'Live')
            ->where('sd.del_status', 'Live');
        if (!empty($customer_id)) {
            $salesQuery->where('s.customer_id', $customer_id);
        }
        if (isset($request->startDate) && $request->startDate != '') {
            $startDate = $request->startDate;
            $salesQuery->where('sale_date', '>=', date('Y-m-d', strtotime($request->startDate)));
        }
        if (isset($request->endDate) && $request->endDate != '') {
            $endDate = $request->endDate;
            $salesQuery->where('sale_date', '<=', date('Y-m-d', strtotime($request->endDate)));
        }
        $obj = $salesQuery
            ->select('s.*', 'sd.order_id', 'q.challan_no')
            ->orderBy('s.id', 'DESC')
            ->get()
            ->unique();

        // Add receive status and sum of pay_amount manually
        foreach ($obj as $sale) {
            $payAmount = DB::table('tbl_customer_due_receives')
                ->where('order_id', $sale->order_id)
                ->where('del_status', 'Live')
                ->sum('pay_amount');

            $balanceAmount = DB::table('tbl_customer_due_receives')
                ->where('order_id', $sale->order_id)
                ->where('del_status', 'Live')
                ->orderBy('id', 'DESC')
                ->value('balance_amount');

            if ($payAmount == 0) {
                $sale->receive_status = 'Initiated';
            } elseif ($balanceAmount == 0) {
                $sale->receive_status = 'Paid';
            } else {
                $sale->receive_status = 'Partially Paid';
            }

            $sale->pay = $payAmount;
            $sale->bal = $balanceAmount;
        }
        // dd($obj);
        $title = __('index.sales_list');
        $customers = Customer::where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        return view('pages.sales.sales', compact('title', 'obj', 'customers', 'startDate', 'endDate', 'customer_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('index.add_sale');
        $customers = Customer::orderBy('id', 'DESC')->where('del_status', "Live")->get();
        $finishProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $fifoProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->where('stock_method', "fifo")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $existing_challans = DB::table('tbl_sales')
            ->where('del_status', 'Live')
            ->pluck('challan_id')
            ->toArray();
        $delivery_challan_list = Quotation::where('challan_status', '3')->whereNotIn('id', $existing_challans)->where('del_status', "Live")->orderBy('id', 'DESC')->get();
        // $obj_rm = Sales::count();
        // $ref_no = "SO-" . str_pad($obj_rm + 1, 6, '0', STR_PAD_LEFT);
        return view('pages.sales.addEditSale', compact('title', 'customers', 'finishProducts', 'accounts', 'fifoProducts', 'delivery_challan_list'));
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
        request()->validate(
            [
                // 'reference_no' => 'required|max:50',
                'customer_id' => 'required',
                // 'status' => 'required|max:50',
                'date' => 'required',
                'selected_product_id' => 'required',
                // 'paid' => 'required|max:50',
                // 'account' => 'required|max:50',
            ],
            [
                // 'reference_no.required' => __('index.reference_no_required'),
                'customer_id.required' => __('index.customer_required'),
                // 'status.required' => __('index.status_required'),
                'date.required' => __('index.date_required'),
                'selected_product_id.required' => __('index.selected_product_id_required'),
                // 'paid.required' => __('index.paid_required'),
                // 'account.required' => __('index.account_required'),
            ]
        );
        DB::beginTransaction();
        try {
            $quantity_list = $request->get('quantity');
            $total_quantity = 0;
            for ($i = 0; $i < sizeof($quantity_list); $i++) {
                $total_quantity = $total_quantity + $quantity_list[$i];
            }
            $customer_order_id = QuotationDetail::where('quotation_id', $request->get('challan_id'))
                ->where('del_status', 'Live')
                ->pluck('customer_order_id')
                ->first();

            $customerOrder = CustomerOrder::where('id', $customer_order_id)
                ->where('del_status', 'Live')
                ->first();

            $prefix = ($customerOrder->order_type == 'Quotation') ? 'L/' : 'S/';
            $currentYear = date('y');
            $nextYear = $currentYear + 1;
            $yearRange = $currentYear . '-' . $nextYear;

            $lastRecord = \App\Sales::where('reference_no', 'like', $prefix . '%/' . $yearRange)
                ->orderBy('id', 'desc')
                ->first();

            if ($lastRecord) {
                preg_match('/' . preg_quote($prefix, '/') . '(\d+)\/' . $yearRange . '/', $lastRecord->reference_no, $matches);
                $lastNumber = isset($matches[1]) ? intval($matches[1]) : 0;
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            $sequence = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            $obj = new \App\Sales();
            $obj->challan_id = null_check(escape_output($request->get('challan_id')));
            $obj->reference_no = $prefix . $sequence . '/' . $yearRange;
            // $obj->reference_no = $prefix . str_pad($nextNumber, 8, '0', STR_PAD_LEFT);
            $obj->customer_id = null_check(escape_output($request->get('customer_id')));
            $obj->sale_date = escape_output(date('Y-m-d', strtotime($request->get('date'))));
            // $obj->status = escape_output($request->get('status'));
            $obj->product_quantity = null_check($total_quantity);
            $obj->subtotal = null_check(escape_output($request->get('subtotal')));
            $obj->other = null_check(escape_output($request->get('other')));
            $obj->discount = null_check(escape_output($request->get('discount')));
            $obj->grand_total = null_check(escape_output($request->get('grand_total')));
            // $obj->account_id = null_check(null_check(escape_output($request->get('account'))));
            $obj->paid = null_check(null_check(escape_output($request->get('paid'))));
            $obj->due = null_check(escape_output($request->get('due')));
            $obj->note = escape_output($request->get('note'));
            $obj->added_by = auth()->user()->id;
            $obj->created_at = date('Y-m-d H:i:s');
            $obj->save();

            $sale_details = $request->get('selected_product_id');
            $sale_price = $request->get('sale_price');
            $order_id = $request->get('order_id');
            $srn = $request->get('srn');
            // $total = $request->get('total');

            for ($x = 0; $x < sizeof($sale_details); $x++) {
                $obj2 = new \App\SaleDetail();
                $obj2->sale_id = null_check($obj->id);
                $obj2->product_id = null_check($sale_details[$x]);
                $obj2->order_id = null_check($order_id[$x]);
                $obj2->unit_price = null_check($sale_price[$x]);
                $obj2->product_quantity = null_check($quantity_list[$x]);
                $obj2->total_amount = null_check($sale_price[$x]);
                $obj2->srn = null_check($srn[$x]);
                $obj2->del_status = 'Live';
                $obj2->created_at = date('Y-m-d H:i:s');
                if (isset($request->manufacture_id[$x])) {
                    $obj2->manufacture_id = null_check($request->manufacture_id[$x]);
                }
                $obj2->save();
            }
            DB::commit();

            return redirect('sales')->with(saveMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(dangerMessage($e->getMessage()));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $title = __('index.view_sale_details');

        $customers = Customer::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $finishProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $fifoProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->where('stock_method', "fifo")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $obj = Sales::with('quotation.quotationDetails')->findOrFail($id);
        $sale_details = SaleDetail::where('sale_id', $id)->where('del_status', 'Live')->get();
        $challanInfo = Quotation::where('id', $obj->challan_id)->where('del_status', 'Live')->first();
        return view('pages.sales.viewSalesDetails', compact('title', 'obj', 'customers', 'finishProducts', 'accounts', 'fifoProducts', 'sale_details', 'challanInfo'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function invoice($id)
    {
        $title = __('index.sales_invoice');

        $company = AdminSettings::orderBy('name_company_name', 'ASC')->where('del_status', "Live")->get();

        $customers = Customer::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $finishProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $fifoProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->where('stock_method', "fifo")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();

        $obj = Sales::with('quotation.quotationDetails')->findOrFail($id);
        $setting = getSettingsInfo();
        $sale_details = SaleDetail::where('sale_id', $id)->where('del_status', 'Live')->get();
        $challanInfo = Quotation::where('id', $obj->challan_id)->where('del_status', 'Live')->first();
        return view('pages.sales.salesInvoice', compact('title', 'obj', 'customers', 'setting', 'finishProducts', 'accounts', 'fifoProducts', 'company', 'sale_details', 'challanInfo'));
    }

    public function downloadInvoice($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $title = __('index.sales_invoice');

        $company = AdminSettings::orderBy('name_company_name', 'ASC')->where('del_status', "Live")->get();

        $customers = Customer::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $finishProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $fifoProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->where('stock_method', "fifo")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();

        $obj = Sales::with('quotation.quotationDetails')->findOrFail($id);
        $setting = getSettingsInfo();
        $sale_details = SaleDetail::where('sale_id', $id)->where('del_status', 'Live')->get();
        $challanInfo = Quotation::where('id', $obj->challan_id)->where('del_status', 'Live')->first();
        $pdf = Pdf::loadView('pages.sales.salesInvoice', compact('title', 'obj', 'sale_details', 'setting', 'customers', 'finishProducts', 'accounts', 'fifoProducts', 'company', 'challanInfo'))->setPaper('a4', 'landscape');
        return $pdf->stream($obj->reference_no . '.pdf');
    }

    public function downloadChallan($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $title = __('index.challan');
        $company = AdminSettings::orderBy('name_company_name', 'ASC')->where('del_status', "Live")->get();

        $customers = Customer::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $finishProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $fifoProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->where('stock_method', "fifo")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();

        $obj = Sales::findOrFail($id);
        $setting = getSettingsInfo();
        $sale_details = DB::table('tbl_sale_details')
            ->select('product_id', DB::raw('sum(unit_price) as unit_price'), DB::raw('sum(product_quantity) as product_quantity'), DB::raw('sum(total_amount) as total_amount'))
            ->where('sale_id', $id)
            ->where('del_status', 'Live')
            ->groupBy('product_id')
            ->get();
        $baseURL = getBaseURL();
        $whiteLabelInfo = getWhiteLabelInfo();
        $pdf = Pdf::loadView('pages.sales.challan', compact('title', 'obj', 'sale_details', 'setting', 'customers', 'finishProducts', 'accounts', 'fifoProducts', 'company'))->setPaper('a4', 'landscape');
        return $pdf->download($obj->reference_no . '.pdf');
    }

    public function challan($id)
    {
        $title = __('index.challan');

        $company = AdminSettings::orderBy('name_company_name', 'ASC')->where('del_status', "Live")->get();

        $customers = Customer::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $finishProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $fifoProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->where('stock_method', "fifo")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();

        $obj = Sales::findOrFail($id);
        $setting = getSettingsInfo();
        $sale_details = DB::table('tbl_sale_details')
            ->select('product_id', DB::raw('sum(unit_price) as unit_price'), DB::raw('sum(product_quantity) as product_quantity'), DB::raw('sum(total_amount) as total_amount'))
            ->where('sale_id', $id)
            ->where('del_status', 'Live')
            ->groupBy('product_id')
            ->get();
        $baseURL = getBaseURL();
        $whiteLabelInfo = getWhiteLabelInfo();
        return view('pages.sales.challan', compact('title', 'obj', 'customers', 'setting', 'finishProducts', 'accounts', 'fifoProducts', 'company', 'sale_details', 'baseURL', 'whiteLabelInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $title = __('index.edit_sale');
        $customers = Customer::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $finishProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $fifoProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->where('stock_method', "fifo")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $obj = Sales::findOrFail($id);
        $sale_details = SaleDetail::where('sale_id', $id)->where('del_status', 'Live')->get();
        $delivery_challan_list = Quotation::where('challan_status', '3')->where('del_status', "Live")->orderBy('id', 'DESC')->get();
        return view('pages.sales.addEditSale', compact('title', 'obj', 'customers', 'finishProducts', 'accounts', 'fifoProducts', 'sale_details', 'delivery_challan_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            request()->validate(
                [
                    // 'reference_no' => 'required|max:50',
                    'customer_id' => 'required|max:150',
                    'status' => 'required|max:50',
                    'date' => 'required|max:50',
                    'selected_product_id' => 'required|max:50',
                    'paid' => 'required|max:50',
                    'account' => 'required|max:50',
                ],
                [
                    'reference_no.required' => __('index.reference_no_required'),
                    'customer_id.required' => __('index.customer_required'),
                    'status.required' => __('index.status_required'),
                    'date.required' => __('index.date_required'),
                    'selected_product_id.required' => __('index.selected_product_id_required'),
                    'paid.required' => __('index.paid_required'),
                    'account.required' => __('index.account_required'),
                ]
            );

            $quantity_list = $request->get('quantity_amount');
            $total_quantity = 0;
            for ($i = 0; $i < count($quantity_list); $i++) {
                $total_quantity = $total_quantity + $quantity_list[$i];
            }

            $obj = Sales::findOrFail($id);

            $obj->reference_no = null_check(escape_output($request->get('reference_no')));
            $obj->customer_id = null_check(escape_output($request->get('customer_id')));
            $obj->sale_date = escape_output($request->get('date'));
            $obj->status = escape_output($request->get('status'));
            $obj->product_quantity = null_check($total_quantity);
            $obj->subtotal = null_check(escape_output($request->get('subtotal')));
            $obj->other = null_check(escape_output($request->get('other')));
            $obj->discount = null_check(escape_output($request->get('discount')));
            $obj->grand_total = null_check(escape_output($request->get('grand_total')));
            $obj->account_id = null_check(escape_output($request->get('account')));
            $obj->paid = null_check(escape_output($request->get('paid')));
            $obj->due = null_check(escape_output($request->get('due')));
            $obj->note = escape_output($request->get('note'));
            $obj->updated_at = date('Y-m-d H:i:s');
            if ($request->get('change_currency')) {
                $obj->converted_currency_id = null_check(escape_output($request->get('currency_id')));
                $obj->converted_amount = null_check(escape_output($request->get('converted_amount')));
            }
            $obj->save();

            SaleDetail::where('sale_id', $id)->update(['del_status' => "Deleted"]);

            $sale_details = null_check($request->get('selected_product_id'));
            $unit_price = null_check($request->get('unit_price'));
            $total = null_check($request->get('total'));

            for ($x = 0; $x < sizeof($sale_details); $x++) {
                $obj2 = new \App\SaleDetail();
                $obj2->sale_id = $obj->id;
                $obj2->product_id = $sale_details[$x];
                $obj2->unit_price = $unit_price[$x];
                $obj2->product_quantity = $quantity_list[$x];
                $obj2->total_amount = $total[$x];
                $obj2->del_status = 'Live';
                if (isset($request->manufacture_id[$x])) {
                    $obj2->manufacture_id = null_check($request->manufacture_id[$x]);
                }
                $obj2->save();
            }
            DB::commit();

            return redirect(('sales'))->with(saveMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('sales')->with(dangerMessage($e->getMessage()));
        }
    }

    public function destroy($id)
    {
        Sales::where('id', $id)->update(['del_status' => "Deleted"]);
        return redirect('sales')->with(deleteMessage());
    }
}
