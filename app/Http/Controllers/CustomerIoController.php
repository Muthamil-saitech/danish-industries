<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CustomerOrder;
use App\Customer;
use App\CustomerIO;
use App\CustomerIoDetail;
use App\InstrumentCategory;
use App\Instrument;

class CustomerIoController extends Controller
{
    public function index(Request $request) {
        $title = __('index.customer_io');
        $total_customer_ios = CustomerIo::where('del_status', 'Live')->count();
        $startDate = '';
        $endDate = '';
        $customer_id = escape_output($request->get('customer_id'));
        unset($request->_token);
        $customer_io = CustomerIO::where('del_status', "Live");
        if (isset($request->startDate) && $request->startDate != '') {
            $startDate = date('Y-m-d 00:00:00', strtotime($request->startDate));
            $customer_io->where('created_at', '>=', $startDate);
        }
        if (isset($request->endDate) && $request->endDate != '') {
            $endDate = date('Y-m-d 23:59:59', strtotime($request->endDate));
            $customer_io->where('created_at', '<=', $endDate);
        }
        if (isset($customer_id) && $customer_id != '') {
            $customer_io->where('customer_id', $customer_id);
        }
        $obj = $customer_io->with('details')->orderBy('id', 'DESC')->get();
        $customers = Customer::where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        return view('pages.customer_io.index', compact('title','obj', 'customers', 'startDate', 'endDate', 'customer_id','total_customer_ios'));
    }
    public function create() {
        $title = __('index.add_customer');
        $customer_orders = CustomerOrder::join('tbl_customer_order_details as cod','cod.customer_order_id','=','tbl_customer_orders.id')
        ->where('tbl_customer_orders.del_status', 'Live')
        ->where('cod.del_status', 'Live')
        ->where('cod.order_status', 1)
        ->select('tbl_customer_orders.*','cod.line_item_no', 'cod.id as codid', 'cod.product_id')
        ->orderBy('tbl_customer_orders.id', 'DESC')
        ->whereNotExists(function($q) {
            $q->selectRaw('1')
            ->from('tbl_customer_ios as cio')
            ->where('cio.del_status','Live')
            ->whereColumn('cio.po_no', 'tbl_customer_orders.reference_no') 
            ->whereColumn('cio.line_item_no', 'cod.line_item_no');               
        })->get();
        return view('pages.customer_io.addEditCustomerIO', compact('title','customer_orders'));
    }
    public function store(Request $request){
        // dd($request->all());
        request()->validate([
            'po_no' => 'required',
            'date' => 'required',
            'phn_no' => 'required',
            'd_address' => 'required'
        ]);

        $customer_io = new \App\CustomerIo();
        $file = '';
        if ($request->hasFile('file_button')) {
            $file = $request->file('file_button');
            $filename = $file->getClientOriginalName();
            $fileName = time() . "_" . $filename;
            $file->move(base_path('uploads/customer_io'), $fileName);
            $customer_io->file = $fileName;
        }
        $customer_io->po_no = null_check(escape_output($request->get('po_no')));
        $customer_io->line_item_no = null_check(escape_output($request->get('line_item_no')));
        $customer_io->customer_id = null_check(escape_output($request->get('customer_id')));
        $customer_io->date =  date('Y-m-d', strtotime($request->get('date')));
        $customer_io->d_address = escape_output($request->get('d_address'));
        $customer_io->save();

        if(isset($_POST['type']) && is_array($_POST['type'])) {
            foreach($_POST['type'] as $row => $type){
                $obj = new \App\CustomerIoDetail();
                $obj->customer_io_id = $customer_io->id;
                $obj->type = null_check(escape_output($type));
                $obj->ins_category = null_check(escape_output($_POST['ins_category'][$row] ?? '0')); 
                $obj->ins_name = null_check(escape_output($_POST['ins_name'][$row] ?? '0')); 
                $obj->qty = null_check(escape_output($_POST['qty'][$row] ?? ''));
                $obj->remarks = escape_output($_POST['remarks'][$row] ?? ''); 
                $obj->save();
            }
        }
        return redirect('customer_io')->with(saveMessage());
    }
    public function edit($id){
        $order_id = encrypt_decrypt($id, 'decrypt');
        $customer_orders = CustomerOrder::join('tbl_customer_order_details as cod','cod.customer_order_id','=','tbl_customer_orders.id')->where('tbl_customer_orders.del_status', 'Live')->where('cod.del_status', 'Live') ->where('cod.order_status', 1)->select('tbl_customer_orders.*','cod.line_item_no', 'cod.id as codid', 'cod.product_id') ->orderBy('tbl_customer_orders.id', 'DESC')->get();
        $order_io = CustomerIo::where('id', $order_id)->where('del_status', "Live")->where('del_status','Live')->first();
        $customer = Customer::where('id',$order_io->customer_id)->where('del_status',"Live")->first();
        $customer_io_details = CustomerIoDetail::where('customer_io_id',$order_io->id)->where('del_status','Live')->get();
        $types = $customer_io_details->pluck('type')->unique();
        $instrument_categories = InstrumentCategory::whereIn('type', $types)->orderBy('id','desc')->get();
        $categories = $customer_io_details->pluck('ins_category')->unique();
        $instruments = Instrument::whereIn('type',$types)->whereIn('category',$categories)->orderBy('id','desc')->get();
        $title = __('index.edit_customer_order');
        return view('pages.customer_io.addEditCustomerIO', compact('title', 'customer_orders', 'order_io', 'customer', 'customer_io_details', 'instrument_categories', 'instruments'));
    }
    public function update(Request $request, CustomerIo $customer_io) {
        request()->validate([
            'po_no' => 'nullable',
            'date' => 'required',
            'phn_no' => 'required',
            'd_address' => 'required'
        ]);
        $file = $request->get('file_old');
        if ($request->hasFile('file_button')) {
            $uploadedFile = $request->file('file_button');
            if (!empty($file)) {
                @unlink(base_path('uploads/customer_io/' . $file));
            }
            $filename = time() . "_" . $uploadedFile->getClientOriginalName();
            $uploadedFile->move(base_path('uploads/customer_io'), $filename);
            $customer_io->file = $filename;
        } else {
            if (!empty($file)) {
                $customer_io->file = $file;
            }
        }
        $customer_io->po_no = null_check(escape_output($request->get('po_no')));
        $customer_io->line_item_no = null_check(escape_output($request->get('line_item_no')));
        $customer_io->customer_id = null_check(escape_output($request->get('customer_id')));
        $customer_io->date =  date('Y-m-d', strtotime($request->get('date')));
        $customer_io->d_address = escape_output($request->get('d_address'));
        $customer_io->save();
        $last_id = $customer_io->id;
        $detail_id = $request->get('detail_id');
        CustomerIoDetail::where('customer_io_id', $last_id)->whereIn('id',$detail_id)->update(['del_status' => "Deleted"]);
        if(isset($_POST['type']) && is_array($_POST['type'])) {
            foreach($_POST['type'] as $row => $type){
                $obj = new \App\CustomerIoDetail();
                $obj->customer_io_id = $customer_io->id;
                $obj->type = null_check(escape_output($type));
                $obj->ins_category = null_check(escape_output($_POST['ins_category'][$row] ?? '0')); 
                $obj->ins_name = null_check(escape_output($_POST['ins_name'][$row] ?? '0')); 
                $obj->qty = null_check(escape_output($_POST['qty'][$row] ?? ''));
                $obj->remarks = escape_output($_POST['remarks'][$row] ?? ''); 
                $obj->save();
            }
        }
        return redirect('customer_io')->with(updateMessage());
    }
    public function inward_to_outward(Request $request){
        $customer_io_id = $request->get('customer_io_id');
        $customer_io = CustomerIo::where('id',$customer_io_id)->first();
        $customer_io->inward_date = date('Y-m-d',strtotime($request->get('inward_date')));
        $customer_io->notes = $request->notes ?? null;
        $customer_io->status = 'Outward';
        $customer_io->save();
        return response()->json(['success' => true]);
    }
    public function show($id) {
        $id = encrypt_decrypt($id, 'decrypt');
        $customer_io = CustomerIo::where('id',$id)->where('del_status', "Live")->first();
        $customer_io_details = CustomerIoDetail::where('customer_io_id',$customer_io->id)->where('del_status', "Live")->get();
        $title = __('index.view_customer_io');
        return view('pages.customer_io.view', compact('title','customer_io','customer_io_details'));
    }
    public function destroy(CustomerIO $customer_io) {
        CustomerIoDetail::where('customer_io_id', $customer_io->id)->update(['del_status' => 'Deleted']);
        $customer_io->del_status = 'Deleted';
        $customer_io->save();
        return redirect('customer_io')->with(deleteMessage());
    }

}
