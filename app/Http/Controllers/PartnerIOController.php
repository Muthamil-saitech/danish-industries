<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Partner;
use App\PartnerIo;
use App\PartnerIoDetail;
use App\InstrumentCategory;
use App\Instrument;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;


class PartnerIOController extends Controller
{
    public function index() {
        $title = __('index.partner_io');
        $total_partner_ios = PartnerIoDetail::where('del_status', 'Live')->count();
        $partner_io = PartnerIo::where('del_status', "Live");
        $obj = $partner_io->with('details')->orderBy('id', 'DESC')->get();
        $partners = Partner::where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        return view('pages.partner_io.index', compact('title','total_partner_ios','obj','partners'));
    }
    public function create() {
        $title = __('index.add_partner');
        $partners = Partner::where('del_status','Live')->get();
        return view('pages.partner_io.addEditPartner', compact('title','partners'));
    }
    public function store(Request $request) {
        request()->validate([
            'reference_no' => [
                'required',
                Rule::unique('tbl_partner_ios', 'reference_no')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'partner_id' => 'required',
            'io_date' => 'required',
            'phn_no' => 'required',
            'd_address' => 'required'
        ],[
            'reference_no.unique' => 'Reference No already exists'
        ]);
        
        $partner_io = new \App\PartnerIo();
        $file = '';
        if ($request->hasFile('file_button')) {
            $file = $request->file('file_button');
            $filename = $file->getClientOriginalName();
            $fileName = time() . "_" . $filename;
            $file->move(base_path('uploads/partner_io'), $fileName);
            $partner_io->file = $fileName;
        }
        $partner_io->reference_no = null_check(escape_output($request->get('reference_no')));
        $partner_io->partner_id = null_check(escape_output($request->get('partner_id')));
        $partner_io->io_date =  date('Y-m-d', strtotime($request->get('io_date')));
        $partner_io->d_address = escape_output($request->get('d_address'));
        $partner_io->save();

        if(isset($_POST['type']) && is_array($_POST['type'])) {
            foreach($_POST['type'] as $row => $type){
                $obj = new \App\PartnerIoDetail();
                $obj->partner_io_id = $partner_io->id;
                $obj->type = null_check(escape_output($type));
                $obj->ins_category = null_check(escape_output($_POST['ins_category'][$row] ?? '0')); 
                $obj->ins_name = null_check(escape_output($_POST['ins_name'][$row] ?? '0')); 
                $obj->qty = null_check(escape_output($_POST['qty'][$row] ?? ''));
                $obj->remarks = escape_output($_POST['remarks'][$row] ?? ''); 
                $obj->line_item_no = escape_output($_POST['line_item_no'][$row] ?? ''); 
                $obj->save();
            }
        }
        return redirect('partner_io')->with(saveMessage());
    }
    public function edit($id){
        $detail_id = encrypt_decrypt($id, 'decrypt');
        $partnerOrderDetails = PartnerIoDetail::where('id', $detail_id)->where('del_status', "Live")->first();
        $partners = Partner::where('del_status','Live')->get();
        $partner_io = PartnerIo::find($partnerOrderDetails->partner_io_id);
        $partner_detail = Partner::where('id',$partner_io->partner_id)->where('del_status','Live')->first();
        $types = $partnerOrderDetails->pluck('type')->unique();
        $instrument_categories = InstrumentCategory::whereIn('type', $types)->orderBy('id','desc')->get();
        $categories = $partnerOrderDetails->pluck('ins_category')->unique();
        $instruments = Instrument::whereIn('type',$types)->whereIn('category',$categories)->orderBy('id','desc')->get();
        $title = __('index.edit_partner_io');
        return view('pages.partner_io.addEditPartner', compact('title', 'partnerOrderDetails', 'partners', 'partner_io', 'partner_detail', 'instrument_categories', 'instruments'));
    }
    public function update(Request $request, PartnerIo $partner_io) {
        request()->validate([
            'reference_no' => [
                'required',
                Rule::unique('tbl_partner_ios', 'reference_no')->ignore($partner_io->id, 'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'partner_id' => 'required',
            'io_date' => 'required',
            'phn_no' => 'required',
            'd_address' => 'required'
        ],[
            'reference_no.unique' => 'Reference No already exists',
        ]);
        
        $file = '';
        if ($request->hasFile('file_button')) {
            $file = $request->file('file_button');
            $filename = $file->getClientOriginalName();
            $fileName = time() . "_" . $filename;
            $file->move(base_path('uploads/partner_io'), $fileName);
            $partner_io->file = $fileName;
        }
        $partner_io->reference_no = null_check(escape_output($request->get('reference_no')));
        $partner_io->partner_id = null_check(escape_output($request->get('partner_id')));
        $partner_io->io_date =  date('Y-m-d', strtotime($request->get('io_date')));
        $partner_io->d_address = escape_output($request->get('d_address'));
        $partner_io->save();

        $last_id = $partner_io->id;
        $detail_id = $request->get('detail_id');
        PartnerIoDetail::where('partner_io_id', $last_id)->where('id',$detail_id)->update(['del_status' => "Deleted"]);
        if(isset($_POST['type']) && is_array($_POST['type'])) {
            foreach($_POST['type'] as $row => $type){
                $obj = new \App\PartnerIoDetail();
                $obj->partner_io_id = $partner_io->id;
                $obj->type = null_check(escape_output($type));
                $obj->ins_category = null_check(escape_output($_POST['ins_category'][$row] ?? '0')); 
                $obj->ins_name = null_check(escape_output($_POST['ins_name'][$row] ?? '0')); 
                $obj->qty = null_check(escape_output($_POST['qty'][$row] ?? ''));
                $obj->remarks = escape_output($_POST['remarks'][$row] ?? ''); 
                $obj->line_item_no = escape_output($_POST['line_item_no'][$row] ?? ''); 
                $obj->save();
            }
        }
        return redirect('partner_io')->with(saveMessage());
    }
    public function inward_to_outward(Request $request){
        $partner_io_id = $request->get('partner_io_id');
        $partner_detail_io = PartnerIoDetail::where('id',$partner_io_id)->first();
        $partner_detail_io->inward_date = date('Y-m-d',strtotime($request->get('inward_date')));
        $partner_detail_io->notes = $request->notes ?? null;
        $partner_detail_io->status = 'Outward';
        $partner_detail_io->save();
        return response()->json(['success' => true]);
    }
    public function show($id) {
        $id = encrypt_decrypt($id, 'decrypt');
        $title = __('index.view_partner_io');
        $partner_io_detail = PartnerIoDetail::where('id',$id)->where('del_status','Live')->first();
        $partner_io = PartnerIo::find($partner_io_detail->partner_io_id)->first();
        return view('pages.partner_io.view', compact('title','partner_io_detail','partner_io'));
    }
    public function destroy(PartnerIoDetail $partner_io_detail) {
        PartnerIo::where('id', $partner_io_detail->partner_io_id)->update(['del_status' => 'Deleted']);
        $partner_io_detail->del_status = 'Deleted';
        $partner_io_detail->save();
        return redirect('partner_io')->with(deleteMessage());
    }
    public function downloadIo($id)
    {
        $detail_id = encrypt_decrypt($id, 'decrypt');
        $partner_io_detail = PartnerIoDetail::where('id',$detail_id)->where('del_status', "Live")->first();
        $partner_io = PartnerIo::where('id',$partner_io_detail->partner_io_id)->first();
        $pdf = PDF::loadView('pages.partner_io.print_partner_io', compact('partner_io_detail', 'partner_io'))->setPaper('a4', 'landscape');
        return $pdf->download($partner_io->reference_no . '.pdf');
    }
    public function print($id)
    {
        $partner_io_detail = PartnerIoDetail::where('id',$id)->where('del_status', "Live")->first();
        $partner_io = PartnerIo::where('id',$partner_io_detail->partner_io_id)->first();
        return view('pages.partner_io.print_partner_io', compact('partner_io','partner_io_detail'));
    }
}
