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
# This is QuotationController
##############################################################################
 */

namespace App\Http\Controllers;

use App\Account;
use App\AdminSettings;
use App\Customer;
use App\FinishedProduct;
use App\Http\Controllers\Controller;
use App\Manufacture;
use App\Quotation;
use App\QuotationDetail;
use App\QuotationQcLog;
use App\TaxItems;
use App\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class QuotationController extends Controller
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
        $quotation = Quotation::where('del_status', '!=', 'Deleted');
        if (isset($request->startDate) && $request->startDate != '') {
            $startDate = $request->startDate;
            $quotation->where('challan_date', '>=', date('Y-m-d', strtotime($request->startDate)));
        }
        if (isset($request->endDate) && $request->endDate != '') {
            $endDate = $request->endDate;
            $quotation->where('challan_date', '<=', date('Y-m-d', strtotime($request->endDate)));
        }
        if (isset($customer_id) && $customer_id != '') {
            $quotation->where('customer_id', $customer_id);
        }
        $obj = $quotation->orderBy('id', 'DESC')->get();
        $qc_employees = User::with('role')
            ->whereHas('role', function ($query) {
                $query->where('title', 'Quality Control');
            })
            ->where('del_status', 'Live')
            ->orderBy('emp_code', 'ASC')
            ->get();
        $title = __('index.dc_list');
        $customers = Customer::where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        $total_dc = Quotation::where('del_status', '!=', 'Deleted')->count();
        return view('pages.quotation.index', compact('obj', 'title', 'qc_employees', 'customers', 'startDate', 'endDate', 'customer_id', 'total_dc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('index.add_dc');
        $quote_customers = Quotation::where('del_status', 'Live')->pluck('customer_id')->unique();
        /* if($quote_customers->isEmpty()) {
            $customerIds = \App\Manufacture::where('manufacture_status', 'done')
                ->where('del_status', 'Live')
                ->pluck('customer_id')
                ->unique();
        } else {
            $customerIds = \App\Manufacture::where('manufacture_status', 'done')
            ->where('del_status', 'Live')
            ->whereNotIn('customer_id',$quote_customers)
            ->pluck('customer_id')
            ->unique();
        } */
        $customerIds = \App\Manufacture::where('manufacture_status', 'done')
            ->where('del_status', 'Live')
            ->whereHas('inspect_approval', function ($q) {
                $q->where('status', 2);
            })
            ->pluck('customer_id')
            ->unique();
        $customers = \App\Customer::whereIn('id', $customerIds)->get();
        $finishProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        return view('pages.quotation.addEdit', compact('title', 'customers', 'finishProducts', 'accounts'));
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
        $request->validate(
            [
                'challan_date' => 'required',
                'challan_no' => [
                    'required',
                    'max:50',
                    Rule::unique('tbl_quotations', 'challan_no')->where(function ($query) {
                        return $query->where('del_status', 'Live');
                    }),
                ],
                'material_doc_no' => [
                    'required',
                    'max:20',
                    Rule::unique('tbl_quotations', 'material_doc_no')->where(function ($query) {
                        return $query->where('del_status', 'Live');
                    }),
                ],
                'customer_id' => 'required',
                'product_id' => 'required|array',
                'customer_address' => 'required|max:250',
                'file_button.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx|max:5120',
            ],
            [
                'product_id.required' => __('index.selected_product_id_required'),
                'customer_id.required' => __('index.customer_required'),
                'challan_no.required' => __('index.challan_no_required'),
                'customer_address.required' => __('index.customer_address_required'),
                'customer_address.max' => __('index.customer_address_max'),
                'challan_no.unique' => __('index.challan_no_unique'),
                'material_doc_no.required' => __('index.material_doc_no_required'),
                'material_doc_no.unique' => __('index.material_doc_no_unique'),
                'file_button.*.mimes' => 'Each uploaded file must be a type of: jpg,jpeg,png,gif,pdf,doc,docx.',
                'file_button.*.max'   => 'Each file must be less than 5MB in size.',
            ]
        );
        $cust_parts = explode('|', $request->customer_id);
        $customer_id = $cust_parts[0];
        $quotation = Quotation::create([
            'challan_no' => null_check($request->challan_no),
            'material_doc_no' => null_check($request->material_doc_no),
            'customer_id' => $customer_id,
            'customer_address' => null_check($request->customer_address),
            'customer_gst' => null_check($request->customer_gst),
            'challan_date' => date('Y-m-d', strtotime($request->challan_date)),
            'subtotal' => null_check($request->subtotal),
            'other' => null_check($request->other),
            'grand_total' => null_check($request->grand_total),
            'discount' => null_check($request->discount),
            'note' => ($request->note),
            'user_id' => auth()->user()->id,
            'company_id' => 1,
        ]);

        $file = '';
        if ($request->hasFile('file_button')) {
            $files = $request->file('file_button');
            $fileNames = [];
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $fileNames[] = time() . "_" . $filename;
                $file->move(base_path('uploads/quotation'), $fileNames[count($fileNames) - 1]);
            }
            $quotation->file = implode(',', $fileNames);
        }
        $quotation->save();
        // dd($request->product_id);
        if (is_array($request->product_id)) {
            foreach ($request->product_id as $key => $value) {
                $parts = explode('|', $value);
                // dd($parts[0]);
                $product_id = $parts[0];
                $customer_order_id = $parts[1];
                QuotationDetail::create([
                    'product_id' => $product_id,
                    'customer_order_id' => $customer_order_id,
                    'product_quantity' => $request->product_quantity[$key],
                    'unit_id' => $request->unit_id[$key],
                    'po_no' => $request->po_no[$key],
                    'po_date' => date('Y-m-d', strtotime($request->po_date[$key])),
                    'dc_ref' => $request->dc_ref[$key],
                    'dc_ref_date' => $request->dc_ref_date[$key] != '' ? date('Y-m-d', strtotime($request->dc_ref_date[$key])) : date('Y-m-d'),
                    'challan_ref' => $request->challan_ref[$key],
                    'price' => 0.00,
                    'quotation_id' => $quotation->id,
                    'description' => $request->description[$key]
                ]);
            }
        }

        if ($request->button_click_type == 'download') {
            $title = "Quotation Invoice";
            $company = AdminSettings::orderBy('name_company_name', 'ASC')->where('del_status', "Live")->get();

            $obj = $quotation;
            $setting = getSettingsInfo();
            $quotation_details = $obj->quotationDetails;
            $pdf = Pdf::loadView('pages.quotation.invoice', compact('title', 'obj', 'quotation_details', 'setting'))->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->download($obj->reference_no . '.pdf');
        }

        if ($request->button_click_type == 'email') {
            $this->quotationEmail($quotation);
        }

        if ($request->button_click_type == 'print') {
            return redirect()->action('QuotationController@print', ['id' => $quotation->id]);
        }

        return redirect()->route('quotation.index')->with(saveMessage());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotation = Quotation::findOrFail(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.dc_details');
        $obj = $quotation;
        $quotation_details = $quotation->quotationDetails;
        // dd($quotation_details);
        return view('pages.quotation.details', compact('title', 'obj', 'quotation_details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quotation = Quotation::findOrFail(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.edit_quotation');
        $customerIds = \App\Manufacture::where('manufacture_status', 'done')
            ->where('del_status', 'Live')
            ->pluck('customer_id')
            ->unique();
        $customers = \App\Customer::whereIn('id', $customerIds)->get();
        $finishProducts = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $obj = $quotation;
        $quotation_details = $quotation->quotationDetails;
        $quotation_ids = Quotation::where('customer_id', $quotation->customer_id)
            ->where('del_status', 'Live')
            ->pluck('id');
        $quoted_order_ids = QuotationDetail::whereIn('quotation_id', $quotation_ids)
            ->where('del_status', 'Live')
            ->pluck('customer_order_id')
            ->toArray();
        $manufactures = Manufacture::where('customer_id', $quotation->customer_id)
            ->where('manufacture_status', 'done')
            ->where('del_status', 'Live')
            ->whereNotIn('customer_order_id', $quoted_order_ids)
            ->get();
        $products = FinishedProduct::whereIn('id', $manufactures->pluck('product_id'))
            ->where('del_status', 'Live')
            ->get();
        // dd($products);
        return view('pages.quotation.addEdit', compact('title', 'customers', 'obj', 'quotation_details', 'finishProducts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quotation $quotation)
    {
        // dd($request->all());
        $request->validate(
            [
                'challan_date' => 'required',
                'challan_no' => [
                    'required',
                    'max:50',
                    Rule::unique('tbl_quotations', 'challan_no')->ignore($quotation->id, 'id')->where(function ($query) {
                        return $query->where('del_status', 'Live');
                    }),
                ],
                'material_doc_no' => [
                    'required',
                    'max:20',
                    Rule::unique('tbl_quotations', 'material_doc_no')->ignore($quotation->id, 'id')->where(function ($query) {
                        return $query->where('del_status', 'Live');
                    }),
                ],
                'customer_id' => 'required',
                'selected_product_id' => 'required|array',
                // 'grand_total' => 'required',
                'customer_address' => 'required|max:250',
                'file_button.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx|max:5120',
            ],
            [
                'selected_product_id.required' => __('index.selected_product_id_required'),
                'customer_id.required' => __('index.customer_required'),
                'challan_no.required' => __('index.challan_no_required'),
                'challan_no.unique' => __('index.challan_no_unique'),
                'customer_address.required' => __('index.customer_address_required'),
                'customer_address.max' => __('index.customer_address_max'),
                'grand_total.required' => __('index.grand_total_required'),
                'material_doc_no.required' => __('index.material_doc_no_required'),
                'material_doc_no.unique' => __('index.material_doc_no_unique'),
                'file_button.*.mimes' => 'Each uploaded file must be a type of: JPG, PNG, PDF, DOC, or DOCX.',
                'file_button.*.max'   => 'Each file must be less than 5MB in size.',
            ]
        );
        $cust_parts = explode('|', $request->customer_id);
        $customer_id = $cust_parts[0];
        $quotation->update([
            'challan_no' => null_check($request->challan_no),
            'material_doc_no' => null_check($request->material_doc_no),
            'customer_id' => $customer_id,
            'customer_address' => null_check($request->customer_address),
            'customer_gst' => null_check($request->customer_gst),
            'challan_date' => date('Y-m-d', strtotime($request->challan_date)),
            'subtotal' => null_check($request->subtotal),
            'other' => null_check($request->other),
            'grand_total' => null_check($request->grand_total),
            'discount' => null_check($request->discount),
            'note' => ($request->note),
            'user_id' => auth()->user()->id,
            'company_id' => 1,
        ]);
        $file = $quotation->file;
        if ($request->hasFile('file_button')) {
            $files = $request->file('file_button');
            $fileNames = [];
            foreach ($files as $file) {
                @unlink(base_path('uploads/quotation/' . $file));
                $filename = $file->getClientOriginalName();
                $fileNames[] = time() . "_" . $filename;
                $file->move(base_path('uploads/quotation'), $fileNames[count($fileNames) - 1]);
            }
            $quotation->file = implode(',', $fileNames);
        } else {
            $quotation->file = $file;
        }
        $quotation->save();
        if (is_array($request->selected_product_id)) {
            foreach ($request->selected_product_id as $key => $value) {
                $parts = explode('|', $value);
                $product_id = $parts[0];
                $customer_order_id = $parts[1];
                $quotation_detail = QuotationDetail::where('product_id', $product_id)->where('quotation_id', $quotation->id)->first();
                if ($quotation_detail) {
                    $quotation_detail->update([
                        'product_id' => $product_id,
                        'customer_order_id' => $customer_order_id,
                        'product_quantity' => $quotation_detail->product_quantity,
                        // 'raw_qty' => $quotation_detail->raw_qty,
                        'unit_id' => $quotation_detail->unit_id,
                        'po_no' => $quotation_detail->po_no,
                        'po_date' => $quotation_detail->po_date,
                        'dc_ref' => $request->dc_ref[$key],
                        'dc_ref_date' => $request->dc_ref_date[$key] != '' ? date('Y-m-d', strtotime($request->dc_ref_date[$key])) : date('Y-m-d'),
                        'challan_ref' => $request->challan_ref[$key],
                        'price' => 0.00,
                        // 'sale_price' => $quotation_detail->sale_price,
                        // 'disc_val' => $quotation_detail->disc_val,
                        // 'tax_amount' => $quotation_detail->tax_amount,
                        // 'tax_type' => $quotation_detail->tax_type,
                        // 'tax_rate' => $quotation_detail->tax_rate,
                        // 'msale_price' => $quotation_detail->msale_price,
                        'quotation_id' => $quotation->id,
                        'description' => $request->description[$key]
                    ]);
                } else {
                    QuotationDetail::create([
                        'product_id' => $product_id,
                        'customer_order_id' => $customer_order_id,
                        'product_quantity' => $quotation_detail->product_quantity,
                        // 'raw_qty' => $quotation_detail->raw_qty,
                        'unit_id' => $quotation_detail->unit_id,
                        'po_no' => $quotation_detail->po_no,
                        'po_date' => $quotation_detail->po_date,
                        'dc_ref' => $request->dc_ref[$key],
                        'dc_ref_date' => $request->dc_ref_date[$key] != '' ? date('Y-m-d', strtotime($request->dc_ref_date[$key])) : date('Y-m-d'),
                        'challan_ref' => $request->challan_ref[$key],
                        'price' => 0.00,
                        // 'sale_price' => $quotation_detail->sale_price,
                        // 'disc_val' => $quotation_detail->disc_val,
                        // 'tax_amount' => $quotation_detail->tax_amount,
                        // 'tax_type' => $quotation_detail->tax_type,
                        // 'tax_rate' => $quotation_detail->tax_rate,
                        // 'msale_price' => $quotation_detail->msale_price,
                        'quotation_id' => $quotation->id,
                        'description' => $request->description[$key]
                    ]);
                }
            }
        }
        if ($request->button_click_type == 'download') {
            $title = __('index.dc_invoice');
            $company = AdminSettings::orderBy('name_company_name', 'ASC')->where('del_status', "Live")->get();
            $obj = $quotation;
            $setting = getSettingsInfo();
            $quotation_details = $obj->quotationDetails;
            $pdf = Pdf::loadView('pages.quotation.invoice', compact('title', 'obj', 'quotation_details', 'setting'))->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->download($obj->reference_no . '.pdf');
        }
        if ($request->button_click_type == 'email') {
            $this->quotationEmail($quotation);
        }
        if ($request->button_click_type == 'print') {
            return redirect()->action('QuotationController@print', ['id' => $quotation->id]);
        }
        return redirect()->route('quotation.index')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quotation $quotation)
    {
        $quotation->update([
            'del_status' => 'Deleted',
        ]);
        QuotationDetail::where('quotation_id', $quotation->id)->update(['del_status' => 'Deleted']);
        return redirect()->route('quotation.index')->with(deleteMessage());
    }

    /**
     * Download Invoice
     */
    public function downloadInvoice($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $title = __('index.dc_invoice');

        $company = AdminSettings::orderBy('name_company_name', 'ASC')->where('del_status', "Live")->get();

        $obj = Quotation::findOrFail($id);
        $setting = getSettingsInfo();
        $quotation_details = $obj->quotationDetails;
        $pdf = Pdf::loadView('pages.quotation.invoice', compact('title', 'obj', 'quotation_details', 'setting'))->setPaper('a4', 'landscape');
        return $pdf->download($obj->material_doc_no . '.pdf');
    }

    /**
     * print invoice
     * @access public
     * @param int
     * @return void
     */
    public function print($id)
    {
        $title = __('index.dc_invoice');

        $company = AdminSettings::orderBy('name_company_name', 'ASC')->where('del_status', "Live")->get();

        $obj = Quotation::findOrFail($id);
        $setting = getSettingsInfo();
        $quotation_details = $obj->quotationDetails;
        return view('pages.quotation.invoice', compact('title', 'obj', 'quotation_details', 'setting'));
    }

    /**
     * Quotation Email Send
     */
    private function quotationEmail($quotation)
    {
        $to_email = [$quotation->customer->email];
        if (!empty($to_email)) {
            $mail_data = [
                'to' => $to_email,
                'subject' => "Quotation for Requested Items from " . getCompanyInfo()->company_name,
                'user_name' => $quotation->customer->name,
                'details' => $quotation->quotationDetails,
                'quotation' => $quotation,
                'view' => 'quotation',
            ];
            MailSendController::sendMailToUser($mail_data);
        }
    }
    public function updateDcQcAssign(Request $request)
    {
        // dd($request->all());
        $qc_user_id = $request->qc_user_id;
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $complete_date = date('Y-m-d', strtotime($request->complete_date));
        $challan_id = $request->challan_id;
        $qc_note = $request->qc_note;
        $dc_qc_scheduling =  new QuotationQcLog();
        $dc_qc_scheduling->challan_id =  $challan_id;
        $dc_qc_scheduling->qc_user_id =  $qc_user_id;
        $dc_qc_scheduling->start_date =  $start_date;
        $dc_qc_scheduling->end_date =  $complete_date;
        $dc_qc_scheduling->note =  $qc_note;
        $dc_qc_scheduling->save();
        return response()->json(['result' => true, 'message' => "QC Added Successfully"]);
    }
    public function getDCQCAssignLog(Request $request)
    {
        $challan_id = $request->qc_challan_id;
        $qclog = [];
        if (!empty($challan_id)) {
            $qc_logs = QuotationQcLog::where('challan_id', $challan_id)->get();
            // dd($qc_logs);
            $delivery_challan = Quotation::where('id', $challan_id)->where('del_status', 'Live')->orderBy('id', 'DESC')->first();
            foreach ($qc_logs as $log) {
                $qclog[] = [
                    'id' => $log->id,
                    'challan_no' => $delivery_challan->challan_no,
                    'emp_name' => getEmpCode($log->qc_user_id),
                    'start_date' => date('d-m-Y', strtotime($log->start_date)),
                    'end_date' => date('d-m-Y', strtotime($log->end_date)),
                    'note' => $log->note,
                    'challan_status' => $delivery_challan->challan_status,
                ];
            }
        }
        return response()->json($qclog);
    }
    public function updateVerifiedStatus(Request $request)
    {
        $qc_challan_id = $request->qc_challan_id;
        $challan_status = $request->challan_status;
        $quotation = Quotation::find($qc_challan_id);
        if ($quotation) {
            $quotation->challan_status = "3";
            $quotation->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Challan not found.']);
        }
    }
    public function updateChallanStatus(Request $request)
    {
        $challan_id = $request->challan_id;
        $status = $request->status;
        $quotation = Quotation::find($challan_id);
        if ($quotation) {
            $quotation->challan_status = $status;
            $quotation->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Challan not found.']);
        }
    }
}
