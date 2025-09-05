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
# This is CustomerController Controller
##############################################################################
 */

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerContactInfo;
use App\CustomerOrder;
use App\MaterialStock;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
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
    public function index()
    {
        $obj = Customer::orderBy('id', 'DESC')->where('del_status', "Live")->get()->map(function ($customer) {
            $usedInStock = MaterialStock::where('customer_id', $customer->id)->exists();
            $usedInOrders = CustomerOrder::where('customer_id', $customer->id)->exists();
            $customer->used_in_stock_or_orders = $usedInStock || $usedInOrders;
            return $customer;
        });
        $title = __('index.customer');
        $total_customers = Customer::where('del_status', 'Live')->count();
        return view('pages.customer.customers', compact('title', 'obj', 'total_customers'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('index.add_customer');
        $obj_cust = Customer::count();
        $customer_id = "CUS" . str_pad($obj_cust + 1, 4, '0', STR_PAD_LEFT);
        // $vendor_code = rand(100000, 999999);
        return view('pages.customer.addEditCustomer', compact('title', 'customer_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(
            [
                'name' => 'required|max:50|regex:/^[\pL\s]+$/u',
                'customer_type' => 'required',
                'phone' => [
                    'required',
                    'max:50',
                    Rule::unique('tbl_customers', 'phone')->where(function ($query) {
                        return $query->where('del_status', 'Live');
                    }),
                ],
                'email' => [
                    'email:filter',
                    Rule::unique('tbl_customers', 'email')->where(function ($query) {
                        return $query->where('del_status', 'Live');
                    }),
                ],
                'address' => 'max:250',
                'hsn_sac_no' => [
                    'nullable',
                    'max:20'
                ],
                'gst_no' => [
                    'nullable',
                    'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][A-Z0-9]{3}$/',
                    Rule::unique('tbl_customers', 'gst_no')->where(function ($query) {
                        return $query->where('del_status', 'Live');
                    }),
                ],
                'pan_no' => [
                    'nullable',
                    'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                    Rule::unique('tbl_customers', 'pan_no')->where(function ($query) {
                        return $query->where('del_status', 'Live');
                    }),
                ],
                'ecc_no' => [
                    'nullable',
                    'regex:/^\d{1,9}$/',
                    Rule::unique('tbl_customers', 'ecc_no')->where(function ($query) {
                        return $query->where('del_status', 'Live');
                    }),
                ],
                'area' => 'max:50',
                'note' => 'max:250',
                /* 'vendor_code' => [
                'required',
                'max:20',
                Rule::unique('tbl_customers', 'vendor_code')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ], */
            ],
            [
                'customer_type.required' => "The Customer Type field is required",
                'name.required' => __('index.cust_name_required'),
                'phone.required' => __('index.phone_required'),
                'email.email' => __('index.email_validation'),
                'opening_balance.numeric' => __('index.opening_balance_numeric'),
                'gst_no.unique' => __('index.gst_unique'),
                'gst_no.regex' => __('index.gst_regex'),
                'pan_no.regex' => __('index.pan_regex'),
                'ecc_no.regex' => __('index.ecc_regex'),
                'area.max' => __('index.landmark_max'),
                /* 'vendor_code.required' => "The Customer Code field is required",
                'vendor_code.max' => "The Customer Code may not be greater than 20 characters",
                'vendor_code.unique' => "Customer Code already taken", */
            ]

        );

        $obj = new \App\Customer;
        $obj->customer_id = escape_output($request->get('customer_id'));
        $obj->name = ucwords(escape_output($request->get('name')));
        $obj->phone = escape_output($request->get('phone'));
        $obj->email = escape_output($request->get('email'));
        $obj->hsn_sac_no = escape_output($request->get('hsn_sac_no'));
        $obj->gst_no = escape_output($request->get('gst_no'));
        $obj->pan_no = escape_output($request->get('pan_no'));
        $obj->ecc_no = escape_output($request->get('ecc_no'));
        $obj->area = escape_output($request->get('area'));
        $obj->customer_type = escape_output($request->get('customer_type'));
        $obj->address = escape_output($request->get('address'));
        $obj->note = html_entity_decode($request->get('note'));
        $obj->added_by = auth()->user()->id;
        $obj->save();

        if (isset($_POST['cp_name']) && is_array($_POST['cp_name']) && !empty($_POST['cp_name'])) {
            foreach ($_POST['cp_name'] as $row => $value) {
                $cp_info = new \App\CustomerContactInfo();
                $cp_info->customer_id = $obj->id;
                $cp_info->cp_name = escape_output($_POST['cp_name'][$row] ?? null);
                $cp_info->cp_department = escape_output($_POST['cp_department'][$row] ?? null);
                $cp_info->cp_designation = escape_output($_POST['cp_designation'][$row] ?? null);
                $cp_info->cp_phone = escape_output($_POST['cp_phone'][$row] ?? null);
                $cp_info->cp_email = escape_output($_POST['cp_email'][$row] ?? null);
                $cp_info->save();
            }
        }
        return redirect('customers')->with(saveMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find(encrypt_decrypt($id, 'decrypt'));
        $customer_contact_info = CustomerContactInfo::where('customer_id',$customer->id)->where('del_status','Live')->get();
        $title = __('index.edit_customer');
        $obj = $customer;
        return view('pages.customer.addEditCustomer', compact('title', 'obj', 'customer_contact_info'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        // dd($request->all());
        request()->validate(
            [
                'name' => 'required|max:50|regex:/^[\pL\s]+$/u',
                'customer_type' => 'required',
                'phone' => [
                    'required',
                    'max:50',
                    Rule::unique('tbl_customers', 'phone')->ignore($customer->id, 'id')->where(function ($query) {
                        return $query->where('del_status', 'Live');
                    }),
                ],
                'email' => [
                    'email:filter',
                    Rule::unique('tbl_customers', 'email')->ignore($customer->id, 'id')->where(function ($query) {
                        return $query->where('del_status', 'Live');
                    }),
                ],
                'address' => 'max:250',
                'hsn_sac_no' => [
                    'nullable',
                    'max:20'
                ],
                'gst_no' => [
                    'nullable',
                    'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][A-Z0-9]{3}$/',
                    Rule::unique('tbl_customers', 'gst_no')->ignore($customer->id, 'id')->where(function ($query) {
                        return $query->where('del_status', 'Live');
                    }),
                ],
                'pan_no' => [
                    'nullable',
                    'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                    Rule::unique('tbl_customers', 'pan_no')->ignore($customer->id, 'id')->where(function ($query) {
                        return $query->where('del_status', 'Live');
                    }),
                ],
                'ecc_no' => [
                    'nullable',
                    'regex:/^\d{1,9}$/',
                    Rule::unique('tbl_customers', 'ecc_no')->ignore($customer->id, 'id')->where(function ($query) {
                        return $query->where('del_status', 'Live');
                    }),
                ],
                'area' => 'max:50',
                'note' => 'max:250',
                /* 'vendor_code' => [
                'required',
                'max:20',
                Rule::unique('tbl_customers', 'vendor_code')->ignore($customer->id,'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ], */
            ],
            [
                'customer_type.required' => "The Customer Type field is required",
                'name.required' => __('index.cust_name_required'),
                'phone.required' => __('index.phone_required'),
                'email.email' => __('index.email_validation'),
                'opening_balance.numeric' => __('index.opening_balance_numeric'),
                'gst_no.regex' => __('index.gst_regex'),
                'gst_no.unique' => __('index.gst_unique'),
                'pan_no.regex' => __('index.pan_regex'),
                'ecc_no.regex' => __('index.ecc_regex'),
                'area.max' => __('index.landmark_max'),
                // 'vendor_code.required' => "The Customer Code field is required",
                // 'vendor_code.max' => "The Customer Code may not be greater than 20 characters",
                // 'vendor_code.unique' => "Customer Code already taken",
            ]
        );
        $customer->customer_id = escape_output($request->get('customer_id'));
        // $customer->vendor_code = escape_output($request->get('vendor_code'));
        $customer->name = ucwords(escape_output($request->get('name')));
        $customer->phone = escape_output($request->get('phone'));
        $customer->email = escape_output($request->get('email'));
        $customer->hsn_sac_no = escape_output($request->get('hsn_sac_no'));
        $customer->gst_no = escape_output($request->get('gst_no'));
        $customer->pan_no = escape_output($request->get('pan_no'));
        $customer->ecc_no = escape_output($request->get('ecc_no'));
        $customer->area = escape_output($request->get('area'));
        $customer->customer_type = escape_output($request->get('customer_type'));
        $customer->address = escape_output($request->get('address'));
        $customer->note = html_entity_decode($request->get('note'));
        $customer->added_by = auth()->user()->id;
        $customer->save();
        CustomerContactInfo::where('customer_id', $customer->id)->update(['del_status' => "Deleted"]);
        if ($request->has('cp_name') && is_array($request->cp_name)) {
            foreach ($request->cp_name as $row => $value) {
                $cp_info = new \App\CustomerContactInfo();
                $cp_info->customer_id = $customer->id;
                $cp_info->cp_name = escape_output($request->cp_name[$row] ?? null);
                $cp_info->cp_department = escape_output($request->cp_department[$row] ?? null);
                $cp_info->cp_designation = escape_output($request->cp_designation[$row] ?? null);
                $cp_info->cp_phone = escape_output($request->cp_phone[$row] ?? null);
                $cp_info->cp_email = escape_output($request->cp_email[$row] ?? null);
                $cp_info->save();
            }
        }
        return redirect('customers')->with(updateMessage());
    }

    public function show($id)
    {
        $customer = Customer::find(encrypt_decrypt($id, 'decrypt'));
        $customer_contact_details = CustomerContactInfo::where('customer_id',$customer->id)->where('del_status','Live')->orderBy('id','DESC')->get();
        $title = __('index.view_details_customer');
        $obj = $customer;
        return view('pages.customer.viewDetails', compact('title', 'obj', 'customer_contact_details'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        CustomerContactInfo::where('customer_id',$customer->id)->update(['del_status'=>'Deleted']);
        $customer->del_status = "Deleted";
        $customer->save();
        return redirect('customers')->with(deleteMessage());
    }

    public function customerContactDelete(Request $request)
    {
        CustomerContactInfo::where('id',$request->contact_id)->update(['del_status'=>'Deleted']);
        return response()->json(['status' => true, 'message' => 'Deleted Successfully.']);
    }
}
