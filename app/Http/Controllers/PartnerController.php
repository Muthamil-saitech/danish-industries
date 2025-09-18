<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Partner;
use App\PartnerContactInfo;
use App\PartnerIO;
use Illuminate\Validation\Rule;


class PartnerController extends Controller
{
    public function index() {
        $obj = Partner::orderBy('id', 'DESC')->where('del_status', "Live")->get()->map(function ($partner) {
            $usedInPartner = PartnerIO::where('partner_id', $partner->id)->exists();
            $partner->used_in_partner_po = $usedInPartner;
            return $partner;
        });
        $title = __('index.partners');
        return view('pages.partners.index', compact('title','obj'));
    }
    public function create() {
        $title = __('index.add_partner');
        $obj_part = Partner::count();
        $partner_id = "P" . str_pad($obj_part + 1, 4, '0', STR_PAD_LEFT);
        return view('pages.partners.addEditPartner', compact('title','partner_id'));
    }
    public function store(Request $request){
        request()->validate([
            'name' => [
                'required',
                'max:50',
            ],
            'phone' => [
                'required',
                'max:50',
                Rule::unique('tbl_partners', 'phone')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'email' => [
                'email:filter',
                Rule::unique('tbl_partners', 'email')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'gst_no' => [
                'nullable',
                'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][A-Z0-9]{3}$/',
                Rule::unique('tbl_partners', 'gst_no')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'ecc_no' => [
                'nullable',
                'regex:/^\d{1,9}$/',
                Rule::unique('tbl_partners', 'ecc_no')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'address' => 'max:250',
            'area' => 'max:50',
            'note' => 'max:250'
        ], [
            'name.required' => __('index.partner_name_required'),
            'phone.required' => __('index.phone_required'),
            'email.email' => __('index.email_validation'),
            // 'gst_no.required' => __('index.gst_required'),
            'gst_no.regex' => __('index.gst_regex'),
            'ecc_no.regex' => __('index.ecc_regex'),
            'area.max' => __('index.landmark_max'),
        ]);

        $obj = new \App\Partner;
        $obj->partner_id = escape_output($request->get('partner_id'));
        $obj->name = ucwords(escape_output($request->get('name')));
        $obj->phone = escape_output($request->get('phone'));
        $obj->email = escape_output($request->get('email'));
        $obj->address = escape_output($request->get('address'));
        $obj->gst_no = escape_output($request->get('gst_no'));
        $obj->ecc_no = escape_output($request->get('ecc_no'));
        $obj->area = escape_output($request->get('area'));
        $obj->note = html_entity_decode($request->get('note'));
        $obj->added_by = auth()->user()->id;
        $obj->save();

        if (isset($_POST['pcp_name']) && is_array($_POST['pcp_name']) && !empty($_POST['pcp_name'])) {
            foreach ($_POST['pcp_name'] as $row => $value) {
                $scp_info = new \App\PartnerContactInfo();
                $scp_info->partner_id = $obj->id;
                $scp_info->pcp_name = ucwords(escape_output($_POST['pcp_name'][$row] ?? null));
                $scp_info->pcp_department = escape_output($_POST['pcp_department'][$row] ?? null);
                $scp_info->pcp_designation = escape_output($_POST['pcp_designation'][$row] ?? null);
                $scp_info->pcp_phone = escape_output($_POST['pcp_phone'][$row] ?? null);
                $scp_info->pcp_email = escape_output($_POST['pcp_email'][$row] ?? null);
                $scp_info->save();
            }
        }
        return redirect('partners')->with(saveMessage());
    }
    public function edit($id)
    {
        $partner = Partner::find(encrypt_decrypt($id, 'decrypt'));
        $partner_contact_info = PartnerContactInfo::where('partner_id',$partner->id)->where('del_status','Live')->get();
        $title =  __('index.edit_partner');
        $obj = $partner;
        return view('pages.partners.addEditPartner', compact('title', 'obj', 'partner_contact_info'));
    }
    public function update(Request $request, Partner $partner)
    {
        request()->validate([
            'name' => 'required|max:50',
            'phone' => [
                'required',
                'max:50',
                Rule::unique('tbl_partners', 'phone')->ignore($partner->id, 'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'email' => [
                'email:filter',
                Rule::unique('tbl_partners', 'email')->ignore($partner->id, 'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'address' => 'max:250',
            'gst_no' => [
                'nullable',
                'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][A-Z0-9]{3}$/',
                Rule::unique('tbl_partners', 'gst_no')->ignore($partner->id, 'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'ecc_no' => [
                'nullable',
                'regex:/^\d{1,9}$/',
                Rule::unique('tbl_partners', 'ecc_no')->ignore($partner->id, 'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'area' => 'max:50',
            'note' => 'max:250'
        ], [
            'name.required' => __('index.partner_name_required'),
            'phone.required' => __('index.phone_required'),
            'email.email' => __('index.email_validation'),
            // 'gst_no.required' => __('index.gst_required'),
            'gst_no.regex' => __('index.gst_regex'),
            'ecc_no.regex' => __('index.ecc_regex'),
            'area.max' => __('index.landmark_max'),
        ]);

        $partner->partner_id = escape_output($request->get('partner_id'));
        $partner->name = ucwords(escape_output($request->get('name')));
        $partner->phone = escape_output($request->get('phone'));
        $partner->email = escape_output($request->get('email'));
        $partner->gst_no = escape_output($request->get('gst_no'));
        $partner->ecc_no = escape_output($request->get('ecc_no'));
        $partner->area = escape_output($request->get('area'));
        $partner->address = escape_output($request->get('address'));
        $partner->note = html_entity_decode($request->get('note'));
        $partner->added_by = auth()->user()->id;
        $partner->save();
        PartnerContactInfo::where('partner_id', $partner->id)->update(['del_status' => "Deleted"]);
        if ($request->has('pcp_name') && is_array($request->pcp_name)) {
            foreach ($request->pcp_name as $row => $value) {
                $scp_info = new \App\PartnerContactInfo();
                $scp_info->partner_id = $partner->id;
                $scp_info->pcp_name = escape_output($request->pcp_name[$row] ?? null);
                $scp_info->pcp_department = escape_output($request->pcp_department[$row] ?? null);
                $scp_info->pcp_designation = escape_output($request->pcp_designation[$row] ?? null);
                $scp_info->pcp_phone = escape_output($request->pcp_phone[$row] ?? null);
                $scp_info->pcp_email = escape_output($request->pcp_email[$row] ?? null);
                $scp_info->save();
            }
        }
        return redirect('partners')->with(updateMessage());
    }
    public function show($id)
    {
        $title = __('index.view_partner');
        $partner = Partner::find(encrypt_decrypt($id, 'decrypt'));
        $partner_contact_details = PartnerContactInfo::where('partner_id',$partner->id)->where('del_status','Live')->get();
        $obj = $partner;
        return view('pages.partners.view', compact('title', 'obj', 'partner_contact_details'));
    }
    public function destroy(Partner $partner)
    {
        PartnerContactInfo::where('partner_id',$partner->id)->update(['del_status'=>'Deleted']);
        $partner->del_status = "Deleted";
        $partner->save();
        return redirect('partners')->with(deleteMessage());
    }
    public function partnerContactDelete(Request $request)
    {
        PartnerContactInfo::where('id',$request->contact_id)->update(['del_status'=>'Deleted']);
        return response()->json(['status' => true, 'message' => 'Deleted Successfully.']);
    }
}
