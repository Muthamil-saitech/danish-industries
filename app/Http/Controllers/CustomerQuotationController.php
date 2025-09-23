<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerQuotation;
use App\CustomerQuotationDetail;
use App\FinishedProduct;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CustomerQuotationController extends Controller
{
    public function index(Request $request)
    {
        $startDate = '';
        $endDate = '';
        $customer_id = escape_output($request->get('customer_id'));
        unset($request->_token);
        $quotation = CustomerQuotation::where('del_status', '!=', 'Deleted');
        if (isset($request->startDate) && $request->startDate != '') {
            $startDate = $request->startDate;
            $quotation->where('quote_date', '>=', date('Y-m-d', strtotime($request->startDate)));
        }
        if (isset($request->endDate) && $request->endDate != '') {
            $endDate = $request->endDate;
            $quotation->where('quote_date', '<=', date('Y-m-d', strtotime($request->endDate)));
        }
        if (isset($customer_id) && $customer_id != '') {
            $quotation->where('customer_id', $customer_id);
        }
        $obj = $quotation->orderBy('id', 'DESC')->get();
        $title = __('index.quotion_list');
        $customers = Customer::where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        $total_dc = CustomerQuotation::where('del_status', '!=', 'Deleted')->count();
        return view('pages.customer_quotation.index', compact('obj', 'title', 'customers', 'startDate', 'endDate', 'customer_id', 'total_dc'));
    }
    public function create()
    {
        $title = __('index.add_quotion');
        $customers = Customer::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $finishProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $obj_qo = CustomerQuotation::count();
        $ref_no = "QO-" . str_pad($obj_qo + 1, 6, '0', STR_PAD_LEFT);
        return view('pages.customer_quotation.addEdit', compact('title', 'ref_no', 'customers', 'finishProducts'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'quotation_no' => 'required',
            'customer_id' => 'required',
            'quote_date' => 'required',
            'selected_product_id' => 'required|array',
        ],
            [
                'selected_product_id.required' => __('index.selected_product_id_required'),
                'quotation_no.required' => __('index.quotation_no_required'),
            ]
        );
        $quotation = CustomerQuotation::create([
            'quotation_no' => null_check($request->quotation_no),
            'customer_id' => null_check($request->customer_id),
            'quote_date' => null_check(date('Y-m-d',strtotime($request->quote_date))),
            'subtotal' => null_check($request->subtotal),
            'other' => null_check($request->other),
            'grand_total' => null_check($request->grand_total),
            'discount' => null_check($request->discount),
            'note' => ($request->note),
            'user_id' => auth()->user()->id,
        ]);
        $quotation->save();
        if (is_array($request->selected_product_id)) {
            foreach ($request->selected_product_id as $key => $value) {
                CustomerQuotationDetail::create([
                    'customer_quotation_id' => null_check($quotation->id),
                    'product_id' => null_check($value),
                    'unit_price' => null_check($request->unit_price[$key]),
                    'quantity' => null_check($request->quantity[$key]),
                    'total' => null_check($request->total[$key]),
                ]);
            }
        }
        return redirect()->route('quotation.index')->with(saveMessage());
    }
    public function show($id)
    {
        $quotation = CustomerQuotation::findOrFail(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.quotation_details');
        $obj = $quotation;
        $quotation_details = $quotation->quotationDetails;
        return view('pages.customer_quotation.details', compact('title', 'obj', 'quotation_details'));
    }
    public function edit($id)
    {
        $quotation = CustomerQuotation::findOrFail(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.edit_quotation');
        $customers = Customer::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $finishProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $obj_qo = CustomerQuotation::count();
        $ref_no = "QO-" . str_pad($obj_qo + 1, 6, '0', STR_PAD_LEFT);
        $obj = $quotation;
        $quotation_details = $quotation->quotationDetails;
        return view('pages.customer_quotation.addEdit', compact('title', 'ref_no', 'customers', 'finishProducts', 'obj', 'quotation_details'));
    }
    public function update(Request $request, CustomerQuotation $quotation)
    {
        $request->validate([
            'quotation_no' => 'required',
            'customer_id' => 'required',
            'quote_date' => 'required',
            'selected_product_id' => 'required|array',
        ],
            [
                'selected_product_id.required' => __('index.selected_product_id_required'),
                'quotation_no.required' => __('index.quotation_no_required'),
            ]
        );

        $quotation->update([
            'quotation_no' => null_check($request->quotation_no),
            'customer_id' => null_check($request->customer_id),
            'quote_date' => date('Y-m-d',strtotime($request->quote_date)),
            'subtotal' => null_check($request->subtotal),
            'other' => null_check($request->other),
            'discount' => null_check($request->discount),
            'grand_total' => null_check($request->grand_total),
            'note' => $request->note,
            'user_id' => auth()->user()->id,
        ]);
        $quotation->save();
        if (is_array($request->selected_product_id)) {
            foreach ($request->selected_product_id as $key => $value) {
                $quotation_detail = CustomerQuotationDetail::where('product_id', $value)->where('customer_quotation_id', $quotation->id)->first();
                if ($quotation_detail) {
                    $quotation_detail->update([
                        'unit_price' => null_check($request->unit_price[$key]),
                        'quantity' => null_check($request->quantity[$key]),
                        'total' => null_check($request->total[$key]),
                    ]);
                } else {
                    CustomerQuotationDetail::create([
                        'product_id' => null_check($value),
                        'unit_price' => null_check($request->unit_price[$key]),
                        'quantity' => null_check($request->quantity[$key]),
                        'total' => null_check($request->total[$key]),
                        'customer_quotation_id' => null_check($quotation->id),
                    ]);
                }
            }
        }
        return redirect()->route('quotation.index')->with(saveMessage());
    }
    public function print($id)
    {
        $title = __('index.quotation_details');
        $obj = CustomerQuotation::findOrFail($id);
        $setting = getSettingsInfo();
        $quotation_details = $obj->quotationDetails;
        return view('pages.customer_quotation.view', compact('title', 'obj', 'quotation_details', 'setting'));
    }
    public function downloadInvoice($id) {
        $id = encrypt_decrypt($id, 'decrypt');
        $title = __('index.quotation_details');
        $obj = CustomerQuotation::findOrFail($id);
        $setting = getSettingsInfo();
        $quotation_details = $obj->quotationDetails;
        $pdf = Pdf::loadView('pages.customer_quotation.view', compact('title', 'obj', 'quotation_details', 'setting'))->setPaper('a4', 'landscape');
        return $pdf->download($obj->quotation_no . '.pdf');
    }
    public function destroy(CustomerQuotation $quotation) {
        $quotation->update([
            'del_status' => 'Deleted',
        ]);
        CustomerQuotationDetail::where('customer_quotation_id', $quotation->id)->update(['del_status' => 'Deleted']);
        return redirect()->route('quotation.index')->with(deleteMessage());
    }
}
