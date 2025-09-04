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
# This is CustomerOrdersController Controller
##############################################################################
 */

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerOrder;
use App\CustomerOrderDelivery;
use App\CustomerOrderDetails;
use App\CustomerOrderInvoice;
use App\FinishedProduct;
use App\FPrmitem;
use App\MaterialStock;
use App\Unit;
use App\TaxItems;
use App\RawMaterial;
use App\RawMaterialCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CustomerOrdersController extends Controller
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
        $total_orders = CustomerOrder::where('del_status', 'Live')->count();
        $startDate = '';
        $endDate = '';
        $customer_id = escape_output($request->get('customer_id'));
        unset($request->_token);
        $order = CustomerOrder::where('del_status', "Live");
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
        // dd($order->get());
        $obj = $order->orderBy('id', 'DESC')->get();
        $customers = Customer::where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        $title = __('index.customer_order');
        return view('pages.customer_order.index', compact('title', 'obj', 'customers', 'startDate', 'endDate', 'customer_id', 'total_orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('index.add_customer_order');
        // $total_customer = CustomerOrder::count();
        // $ref_no = "CO-" . str_pad($total_customer + 1, 6, '0', STR_PAD_LEFT);
        $customers = Customer::orderBy('id', 'DESC')->where('del_status', "Live")->get()
            ->mapWithKeys(function ($customer) {
                return [$customer->id => $customer->name . ' (' . $customer->customer_id . ')'];
            });
        $stock_customers = Customer::where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        $orderTypes = ['Quotation' => 'Labor', 'Work Order' => 'Sales'];
        $tax_types = TaxItems::where('del_status', 'Live')->where('collect_tax', 'Yes')->get();
        $units = Unit::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $rmaterialcats = RawMaterialCategory::where('del_status', "Live")
            ->where('id', '!=', 1)
            ->orderBy('name', 'ASC')
            ->get();
        $rawMaterialIds = RawMaterial::whereIn('category', $rmaterialcats->pluck('id'))
            ->where('del_status', 'Live')
            ->pluck('id');
        $productIds = FPrmitem::whereIn('rmaterials_id', $rawMaterialIds)
            ->pluck('finish_product_id')
            ->unique();
        $productList = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->whereIn('id', $productIds)->get();
        $product = $productList->pluck('name', 'id');
        return view('pages.customer_order.create', compact('title', 'customers', 'orderTypes', 'units', 'productList', 'product', 'tax_types', 'stock_customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->file());
        // dd($request->all());

        request()->validate([
            'reference_no' => [
                'required',
                'max:50',
                Rule::unique('tbl_customer_orders', 'reference_no')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'customer_id' => 'required',
            'order_type' => 'required',
            'po_date' => 'required',
        ]);
        try {
            $productList = $request->get('product');
            $customerOrder = new \App\CustomerOrder();
            $file = '';
            if ($request->hasFile('file_button')) {
                $file = $request->file('file_button');
                $filename = $file->getClientOriginalName();
                $fileName = time() . "_" . $filename;
                $file->move(base_path('uploads/order'), $fileName);
                $customerOrder->file = $fileName;
            }
            $customerOrder->reference_no = null_check(escape_output($request->get('reference_no')));
            $customerOrder->customer_id = null_check(escape_output($request->get('customer_id')));
            $customerOrder->order_type = escape_output($request->get('order_type'));
            $customerOrder->po_date = date('Y-m-d', strtotime($request->get('po_date')));
            $customerOrder->delivery_address = escape_output($request->get('delivery_address'));
            $customerOrder->total_product = null_check(sizeof($productList));
            $customerOrder->total_amount = null_check(escape_output($request->get('total_subtotal')));
            $customerOrder->quotation_note = html_entity_decode($request->get('quotation_note'));
            $customerOrder->internal_note = html_entity_decode($request->get('internal_note'));
            $customerOrder->order_status = '0';
            $customerOrder->created_by = auth()->user()->id;
            $customerOrder->created_at = date('Y-m-d h:i:s');
            $customerOrder->save();
            $inter_state = array_values($_POST['inter_state']);
            if (isset($_POST['product']) && is_array($_POST['product'])) {
                foreach ($_POST['product'] as $row => $productId) {
                    $obj = new \App\CustomerOrderDetails();
                    $obj->customer_order_id = $customerOrder->id;
                    $obj->product_id = null_check(escape_output($productId));
                    $obj->raw_material_id = null_check(escape_output($_POST['raw_material'][$row] ?? 0));
                    $obj->raw_qty = null_check(escape_output($_POST['raw_quantity'][$row] ?? 0));
                    $obj->quantity = null_check(escape_output($_POST['prod_quantity'][$row] ?? 0));
                    $obj->sale_price = null_check(escape_output($_POST['sale_price'][$row] ?? 0));
                    $obj->price = null_check(escape_output($_POST['price'][$row] ?? 0));
                    $obj->tax_type = escape_output($_POST['tax_type'][$row] ?? '');
                    $obj->inter_state = escape_output($inter_state[$row] ?? '');
                    $obj->cgst = escape_output($_POST['cgst'][$row] ?? '');
                    $obj->sgst = escape_output($_POST['sgst'][$row] ?? '');
                    $obj->igst = escape_output($_POST['igst'][$row] ?? '');
                    $obj->discount_percent = 0;
                    $obj->tax_amount = null_check(escape_output($_POST['tax_amount'][$row] ?? 0));
                    $obj->sub_total = null_check(escape_output($_POST['sub_total'][$row] ?? 0));
                    $obj->delivery_date = $_POST['delivery_date_product'][$row] != '' ? date('Y-m-d', strtotime(escape_output($_POST['delivery_date_product'][$row] ?? ''))) : null;
                    $obj->production_status = 0;
                    $obj->delivered_qty = 0;
                    // dd($);
                    $obj->save();
                }
            }
            // if (!empty($request->invoice_type)) {
            //     foreach ($request->invoice_type as $key => $value) {
            $inv_obj = new \App\CustomerOrderInvoice();
            $inv_obj->customer_order_id = null_check($customerOrder->id);
            $inv_obj->invoice_type = 'Quotation';
            $inv_obj->amount = null_check(escape_output($request->get('total_subtotal')));
            $inv_obj->invoice_date = null_check(date('Y-m-d', strtotime($request->get('po_date'))));
            $inv_obj->paid_amount = 0.00;
            $inv_obj->due_amount = null_check(escape_output($request->get('total_subtotal')));
            // $inv_obj->order_due_amount = null_check($request->invoice_order_due[$key]);
            $inv_obj->save();
            //     }
            // }
            return redirect('customer-orders')->with(saveMessage());
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->all())->with(dangerMessage($e->getMessage()));
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
        $customerOrder = CustomerOrder::find($id);
        $title = __('index.customer_order_details');
        $orderDetails = CustomerOrderDetails::where('customer_order_id', $customerOrder->id)->where('del_status', "Live")->get();
        // dd($orderDetails);
        $orderInvoice = CustomerOrderInvoice::where('customer_order_id', $customerOrder->id)->where('del_status', "Live")->orderBy('id', 'desc')->first();
        $orderDeliveries = CustomerOrderDelivery::where('customer_order_id', $customerOrder->id)->where('del_status', "Live")->orderBy('id', 'desc')->get();
        $obj = $customerOrder;
        return view('pages.customer_order.view', compact('title', 'obj', 'orderDetails', 'orderInvoice', 'orderDeliveries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customerOrder = CustomerOrder::find(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.edit_customer_order');
        $customers = Customer::orderBy('id', 'DESC')->where('del_status', "Live")->pluck('name', 'id');
        $orderTypes = ['Quotation' => 'Labor', 'Work Order' => 'Sales'];
        $units = Unit::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $rawMaterialList = RawMaterial::orderBy('name', 'ASC')->where('del_status', "Live")->where('category', '!=', 1)->get();
        $rmaterialcats = RawMaterialCategory::where('del_status', "Live")
            ->where('id', '!=', 1)
            ->orderBy('name', 'ASC')
            ->get();
        $rawMaterialIds = RawMaterial::whereIn('category', $rmaterialcats->pluck('id'))
            ->where('del_status', 'Live')
            ->pluck('id');
        $productIds = FPrmitem::whereIn('rmaterials_id', $rawMaterialIds)
            ->pluck('finish_product_id')
            ->unique();
        $productList = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->whereIn('id', $productIds)->get();
        $product = $productList->pluck('name', 'id');
        $orderDetails = CustomerOrderDetails::where('customer_order_id', $customerOrder->id)->where('del_status', "Live")->get();
        $orderInvoice = CustomerOrderInvoice::where('customer_order_id', $customerOrder->id)->where('del_status', "Live")->get();
        $tax_types = TaxItems::where('del_status', 'Live')->where('collect_tax', 'Yes')->get();
        $orderDeliveries = CustomerOrderDelivery::where('customer_order_id', $customerOrder->id)->where('del_status', "Live")->orderBy('id', 'desc')->get();
        return view('pages.customer_order.edit', compact('title', 'product', 'customerOrder', 'customers', 'orderTypes', 'units', 'productList', 'orderDetails', 'orderInvoice', 'orderDeliveries', 'tax_types', 'rawMaterialList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerOrder $customerOrder)
    {
        // dd($request->all());

        request()->validate([
            'reference_no' => [
                'required',
                'max:50',
                Rule::unique('tbl_customer_orders', 'reference_no')->ignore($customerOrder->id, 'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'customer_id' => 'required',
            'order_type' => 'required',
            'delivery_address' => 'required',
            'po_date' => 'required',
        ]);
        $productList = $request->get('product');
        $file = $request->get('file_old');
        if ($request->hasFile('file_button')) {
            $uploadedFile = $request->file('file_button');
            if (!empty($file)) {
                @unlink(base_path('uploads/order/' . $file));
            }
            $filename = time() . "_" . $uploadedFile->getClientOriginalName();
            $uploadedFile->move(base_path('uploads/order'), $filename);
            // dd($filename);
            $customerOrder->file = $filename;
        } else {
            // dd('not uploaded');
            if (!empty($file)) {
                $customerOrder->file = $file;
            }
        }
        $customerOrder->reference_no = null_check(escape_output($request->get('reference_no')));
        $customerOrder->customer_id = null_check(escape_output($request->get('customer_id')));
        $customerOrder->order_type = escape_output($request->get('order_type'));
        $customerOrder->po_date = date('Y-m-d', strtotime($request->get('po_date')));
        $customerOrder->delivery_address = escape_output($request->get('delivery_address'));
        $customerOrder->total_product = null_check(sizeof($productList));
        $customerOrder->total_amount = null_check(escape_output($request->get('total_subtotal')));
        $customerOrder->quotation_note = html_entity_decode($request->get('quotation_note'));
        $customerOrder->internal_note = html_entity_decode($request->get('internal_note'));
        // dd($customerOrder);
        $customerOrder->save();
        $last_id = $customerOrder->id;
        CustomerOrderDetails::where('customer_order_id', $last_id)->update(['del_status' => "Deleted"]);
        CustomerOrderInvoice::where('customer_order_id', $last_id)->update(['del_status' => "Deleted"]);
        $inter_state = array_values($_POST['inter_state']);
        if (isset($_POST['product']) && is_array($_POST['product'])) {
            foreach ($_POST['product'] as $row => $productId) {
                $obj = new \App\CustomerOrderDetails();
                $obj->customer_order_id = $customerOrder->id;
                $obj->product_id = null_check(escape_output($productId));
                $obj->raw_material_id = null_check(escape_output($_POST['raw_material'][$row] ?? 0));
                $obj->raw_qty = null_check(escape_output($_POST['raw_quantity'][$row] ?? 0));
                $obj->quantity = null_check(escape_output($_POST['prod_quantity'][$row] ?? 0));
                $obj->sale_price = null_check(escape_output($_POST['sale_price'][$row] ?? 0));
                $obj->price = null_check(escape_output($_POST['price'][$row] ?? 0));
                $obj->discount_percent = 0;
                $obj->tax_amount = null_check(escape_output($_POST['tax_amount'][$row] ?? 0));
                $obj->sub_total = null_check(escape_output($_POST['sub_total'][$row] ?? 0));
                $obj->tax_type = escape_output($_POST['tax_type'][$row] ?? '');
                $obj->inter_state = escape_output($inter_state[$row] ?? '');
                $obj->cgst = escape_output($_POST['cgst'][$row] ?? '');
                $obj->sgst = escape_output($_POST['sgst'][$row] ?? '');
                $obj->igst = escape_output($_POST['igst'][$row] ?? '');
                $obj->delivery_date = $_POST['delivery_date_product'][$row] != '' ? date('Y-m-d', strtotime(escape_output($_POST['delivery_date_product'][$row] ?? ''))) : null;
                $obj->production_status = 0;
                $obj->delivered_qty = 0;
                $obj->save();
            }
        }
        $inv_obj = new \App\CustomerOrderInvoice();
        $inv_obj->customer_order_id = null_check($customerOrder->id);
        $inv_obj->invoice_type = 'Quotation';
        $inv_obj->amount = null_check(escape_output($request->get('total_subtotal')));
        $inv_obj->invoice_date = null_check(date('Y-m-d', strtotime($request->get('po_date'))));
        $inv_obj->paid_amount = 0.00;
        $inv_obj->due_amount = null_check(escape_output($request->get('total_subtotal')));
        return redirect('customer-orders')->with(updateMessage());
    }

    /**
     * Store/Update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUpdateInvoice(Request $request)
    {
        request()->validate([
            'invoice_type' => 'required|max:150',
            'paid_amount' => 'required',
            'order_due_amount' => 'required',
            'customer_order_id' => 'required',
        ]);

        $orderInvoice = new CustomerOrderInvoice;
        $orderInvoice->customer_order_id = $request->customer_order_id;
        $orderInvoice->invoice_type = $request->invoice_type;
        $orderInvoice->paid_amount = $request->paid_amount;
        $orderInvoice->due_amount = $request->due_amount;
        $orderInvoice->order_due_amount = $request->order_due_amount;
        $orderInvoice->invoice_date = date('Y-m-d');
        $orderInvoice->save();

        return redirect('customer-orders/' . $request->customer_order_id . '/edit')->with(updateMessage());
    }

    /**
     * Store/Update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUpdateDelivery(Request $request)
    {
        request()->validate([
            'product_id' => 'required',
            'quantity' => 'required',
            'delivery_date' => 'required',
            'delivery_note' => 'required',
            'delivery_status' => 'required',
            'customer_order_id' => 'required',
        ]);

        $orderDelivery = new CustomerOrderDelivery;
        $orderDelivery->customer_order_id = $request->customer_order_id;
        $orderDelivery->product_id = $request->product_id;
        $orderDelivery->quantity = null_check($request->quantity);
        $orderDelivery->delivery_date = string_date_null_check(escape_output($request->delivery_date));
        $orderDelivery->delivery_note = escape_output($request->delivery_note) ?? null;
        $orderDelivery->delivery_status = escape_output($request->delivery_status) ?? null;
        $orderDelivery->save();

        return redirect('customer-orders/' . $request->customer_order_id . '/edit')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RawMaterialPurchase  $rawmaterialpurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerOrder $customerOrder)
    {
        //delete previous data before add
        CustomerOrderDetails::where('customer_order_id', $customerOrder->id)->update(['del_status' => "Deleted"]);
        CustomerOrderInvoice::where('customer_order_id', $customerOrder->id)->update(['del_status' => "Deleted"]);
        CustomerOrderDelivery::where('customer_order_id', $customerOrder->id)->update(['del_status' => "Deleted"]);

        $customerOrder->del_status = "Deleted";
        $customerOrder->save();
        return redirect('customer-orders')->with(deleteMessage());
    }

    /**
     * Download customer order invoice
     */

    public function downloadInvoice($id)
    {
        $obj = CustomerOrder::find(encrypt_decrypt($id, 'decrypt'));
        $orderDetails = CustomerOrderDetails::where('customer_order_id', $obj->id)->where('del_status', "Live")->get();
        $orderInvoice = CustomerOrderInvoice::where('customer_order_id', $obj->id)->where('del_status', "Live")->orderBy('id', 'desc')->get();
        $orderDeliveries = CustomerOrderDelivery::where('customer_order_id', $obj->id)->where('del_status', "Live")->orderBy('id', 'desc')->get();

        $pdf = PDF::loadView('pages.customer_order.invoice', compact('obj', 'orderDetails', 'orderInvoice', 'orderDeliveries'))->setPaper('a4', 'landscape');
        return $pdf->download($obj->reference_no . '.pdf');
    }

    /**
     * Print
     */

    public function print($id)
    {
        $obj = CustomerOrder::find($id);
        $orderDetails = CustomerOrderDetails::where('customer_order_id', $obj->id)->where('del_status', "Live")->get();
        $orderInvoice = CustomerOrderInvoice::where('customer_order_id', $obj->id)->where('del_status', "Live")->orderBy('id', 'desc')->get();
        $orderDeliveries = CustomerOrderDelivery::where('customer_order_id', $obj->id)->where('del_status', "Live")->orderBy('id', 'desc')->get();

        return view('pages.customer_order.invoice', compact('obj', 'orderDetails', 'orderInvoice', 'orderDeliveries'));
    }
}
