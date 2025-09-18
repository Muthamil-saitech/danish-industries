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
  # This is SupplierController
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\RawMaterialPurchase;
use App\Supplier;
use App\SupplierContactInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
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
        $obj = Supplier::orderBy('id', 'DESC')->where('del_status', "Live")->get()->map(function ($supplier) {
            $usedInPurchase = RawMaterialPurchase::where('supplier', $supplier->id)->exists();
            $supplier->used_in_purchase = $usedInPurchase;
            return $supplier;
        });
        $title =  __('index.suppliers');
        $total_suppliers = Supplier::where('del_status', 'Live')->count();
        return view('pages.supplier.suppliers', compact('title', 'obj', 'total_suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title =  __('index.add_supplier');
        $obj_sup = Supplier::count();
        $supplier_id = "SUP" . str_pad($obj_sup + 1, 4, '0', STR_PAD_LEFT);
        return view('pages.supplier.addEditSupplier', compact('title', 'supplier_id'));
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
                'contact_person' => 'max:50|regex:/^[\pL\s]+$/u',
                'phone' => [
                    'required',
                    'max:50',
                    Rule::unique('tbl_suppliers', 'phone')->where(function ($query) {
                        return $query->where('del_status', 'Live');
                    }),
                ],
                'email' => [
                    'email:filter',
                    Rule::unique('tbl_suppliers', 'email')->where(function ($query) {
                        return $query->where('del_status', 'Live');
                    }),
                ],
                'gst_no' => [
                    'nullable',
                    'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][A-Z0-9]{3}$/',
                    Rule::unique('tbl_suppliers', 'gst_no')->where(function ($query) {
                        return $query->where('del_status', 'Live');
                    }),
                ],
                'ecc_no' => [
                    'nullable',
                    'regex:/^\d{1,9}$/',
                    Rule::unique('tbl_suppliers', 'ecc_no')->where(function ($query) {
                        return $query->where('del_status', 'Live');
                    }),
                ],
                'address' => 'max:250',
                'area' => 'max:50',
                'note' => 'max:250'
            ],
            [
                'name.required' => __('index.supplier_name_required'),
                'phone.required' => __('index.phone_required'),
                'email.email' => __('index.email_validation'),
                // 'gst_no.required' => __('index.gst_required'),
                'gst_no.regex' => __('index.gst_regex'),
                'ecc_no.regex' => __('index.ecc_regex'),
                'area.max' => __('index.landmark_max'),
            ]
        );

        $obj = new \App\Supplier;
        $obj->supplier_id = escape_output($request->get('supplier_id'));
        $obj->name = ucwords(escape_output($request->get('name')));
        $obj->contact_person = ucwords(escape_output($request->get('contact_person')));
        $obj->phone = escape_output($request->get('phone'));
        $obj->email = escape_output($request->get('email'));
        $obj->address = escape_output($request->get('address'));
        $obj->gst_no = escape_output($request->get('gst_no'));
        $obj->ecc_no = escape_output($request->get('ecc_no'));
        $obj->area = escape_output($request->get('area'));
        $obj->opening_balance = null_check(escape_output($request->get('opening_balance')));
        $obj->opening_balance_type = escape_output($request->get('opening_balance_type'));
        $obj->note = html_entity_decode($request->get('note'));
        $obj->added_by = auth()->user()->id;
        $obj->company_id = null_check(auth()->user()->company_id);
        $obj->credit_limit = null_check(escape_output($request->get('credit_limit')));
        $obj->save();

        if (isset($_POST['scp_name']) && is_array($_POST['scp_name']) && !empty($_POST['scp_name'])) {
            foreach ($_POST['scp_name'] as $row => $value) {
                $scp_info = new \App\SupplierContactInfo();
                $scp_info->supplier_id = $obj->id;
                $scp_info->scp_name = ucwords(escape_output($_POST['scp_name'][$row] ?? null));
                $scp_info->scp_department = escape_output($_POST['scp_department'][$row] ?? null);
                $scp_info->scp_designation = escape_output($_POST['scp_designation'][$row] ?? null);
                $scp_info->scp_phone = escape_output($_POST['scp_phone'][$row] ?? null);
                $scp_info->scp_email = escape_output($_POST['scp_email'][$row] ?? null);
                $scp_info->save();
            }
        }
        return redirect('suppliers')->with(saveMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::find(encrypt_decrypt($id, 'decrypt'));
        $supplier_contact_info = SupplierContactInfo::where('supplier_id',$supplier->id)->where('del_status','Live')->get();
        $title =  __('index.edit_supplier');
        $obj = $supplier;
        return view('pages.supplier.addEditSupplier', compact('title', 'obj', 'supplier_contact_info'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        request()->validate([
            'name' => 'required|max:50|regex:/^[\pL\s]+$/u',
            'contact_person' => 'max:50|regex:/^[\pL\s]+$/u',
            'phone' => [
                'required',
                'max:50',
                Rule::unique('tbl_suppliers', 'phone')->ignore($supplier->id, 'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'email' => [
                'email:filter',
                Rule::unique('tbl_suppliers', 'email')->ignore($supplier->id, 'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'address' => 'max:250',
            'gst_no' => [
                'nullable',
                'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][A-Z0-9]{3}$/',
                Rule::unique('tbl_suppliers', 'gst_no')->ignore($supplier->id, 'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'ecc_no' => [
                'nullable',
                'regex:/^\d{1,9}$/',
                Rule::unique('tbl_suppliers', 'ecc_no')->ignore($supplier->id, 'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'area' => 'max:50',
            'note' => 'max:250'
        ], [
            'name.required' => __('index.supplier_name_required'),
            'phone.required' => __('index.phone_required'),
            'email.email' => __('index.email_validation'),
            // 'gst_no.required' => __('index.gst_required'),
            'gst_no.regex' => __('index.gst_regex'),
            'ecc_no.regex' => __('index.ecc_regex'),
            'area.max' => __('index.landmark_max'),
        ]);

        $supplier->supplier_id = escape_output($request->get('supplier_id'));
        $supplier->name = ucwords(escape_output($request->get('name')));
        $supplier->contact_person = escape_output($request->get('contact_person'));
        $supplier->phone = escape_output($request->get('phone'));
        $supplier->email = escape_output($request->get('email'));
        $supplier->gst_no = escape_output($request->get('gst_no'));
        $supplier->ecc_no = escape_output($request->get('ecc_no'));
        $supplier->area = escape_output($request->get('area'));
        $supplier->opening_balance = null_check(escape_output($request->get('opening_balance')));
        $supplier->opening_balance_type = escape_output($request->get('opening_balance_type'));
        $supplier->address = escape_output($request->get('address'));
        $supplier->note = html_entity_decode($request->get('note'));
        $supplier->added_by = auth()->user()->id;
        $supplier->credit_limit = null_check(escape_output($request->get('credit_limit')));
        $supplier->save();
        SupplierContactInfo::where('supplier_id', $supplier->id)->update(['del_status' => "Deleted"]);
        if ($request->has('scp_name') && is_array($request->scp_name)) {
            foreach ($request->scp_name as $row => $value) {
                $scp_info = new \App\SupplierContactInfo();
                $scp_info->supplier_id = $supplier->id;
                $scp_info->scp_name = escape_output($request->scp_name[$row] ?? null);
                $scp_info->scp_department = escape_output($request->scp_department[$row] ?? null);
                $scp_info->scp_designation = escape_output($request->scp_designation[$row] ?? null);
                $scp_info->scp_phone = escape_output($request->scp_phone[$row] ?? null);
                $scp_info->scp_email = escape_output($request->scp_email[$row] ?? null);
                $scp_info->save();
            }
        }
        return redirect('suppliers')->with(updateMessage());
    }

    public function show($id)
    {
        $supplier = Supplier::find(encrypt_decrypt($id, 'decrypt'));
        $supplier_contact_details = SupplierContactInfo::where('supplier_id',$supplier->id)->where('del_status','Live')->get();
        $title = __('index.view_details_supplier');
        $obj = $supplier;
        return view('pages.supplier.viewDetails', compact('title', 'obj', 'supplier_contact_details'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        SupplierContactInfo::where('supplier_id',$supplier->id)->update(['del_status'=>'Deleted']);
        $supplier->del_status = "Deleted";
        $supplier->save();
        return redirect('suppliers')->with(deleteMessage());
    }
    public function contactDelete(Request $request)
    {
        SupplierContactInfo::where('id',$request->contact_id)->update(['del_status'=>'Deleted']);
        return response()->json(['status' => true, 'message' => 'Deleted Successfully.']);
    }
}
