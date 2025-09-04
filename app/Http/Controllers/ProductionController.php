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
# This is ProductionController
##############################################################################
 */

namespace App\Http\Controllers;

use App\Account;
use App\Customer;
use App\CustomerOrder;
use App\FinishedProduct;
use App\FPproductionstage;
use App\Manufacture;
use App\Mnonitem;
use App\Mrmitem;
use App\Mstages;
use App\NonIItem;
use App\ProductionHistory;
use App\ProductionScheduling;
use App\ProductionStage;
use App\RawMaterial;
use App\MaterialStock;
use App\Tax;
use App\TaxItems;
use App\Unit;
use App\User;
use App\Drawer;
use App\QcStatus;
use App\Quotation;
use App\QuotationDetail;
use App\ProductionQCScheduling;
use App\RouteCardEntry;
use App\JobCardEntry;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = request()->get('status');
        $product_id = request()->get('finish_p_id');
        $batch_no = request()->get('batch_no');
        $customer = request()->get('customer');

        $obj = Manufacture::orderBy('id', 'DESC')
            ->status($status)
            ->product($product_id)
            ->batchNo($batch_no)
            ->customer($customer)
            ->where('del_status', "Live")
            ->get();
        $title = __('index.manufactures');
        $finishProduct = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $customers = Customer::orderBy('id', 'DESC')->where('del_status', "Live")->get();
        $total_productions = Manufacture::where('del_status', "Live")->count();
        return view('pages.manufacture.manufactures', compact('title', 'obj', 'finishProduct', 'customers', 'status', 'product_id', 'batch_no', 'customer', 'total_productions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($coid = null, $pid = null)
    {
        $coid = encrypt_decrypt($coid, 'decrypt');
        $pid = encrypt_decrypt($pid, 'decrypt');
        $title = __('index.add_manufacture');
        $obj_rm = Manufacture::count();
        $units = Unit::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $rmaterials = RawMaterial::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $nonitem = NonIItem::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        // $p_stages = DB::select("SELECT * FROM tbl_finished_products_productionstage WHERE del_status='Live' AND finish_product_id='$pid' ORDER BY id ASC");
        $p_stages = ProductionStage::orderBy('id', 'ASC')->where('del_status', "Live")->get();
        $employees = User::with('role')
            ->whereHas('role', function ($query) {
                $query->where('title', 'Operators');
            })
            ->where('del_status', 'Live')
            ->orderBy('emp_code', 'ASC')
            ->get();
        $drawers = Drawer::where('del_status', 'Live')->get();
        $tax_items = TaxItems::where('collect_tax', 'YES')->get();
        $lab_tax_items = TaxItems::where('collect_tax', 'YES')->where('tax_type', 'Labor')->first();
        $sale_tax_items = TaxItems::where('collect_tax', 'YES')->where('tax_type', 'Sales')->first();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $rm = RawMaterial::all();
        $ref_no = "MP-" . str_pad($obj_rm + 1, 6, '0', STR_PAD_LEFT);
        $customers = Customer::orderBy('id', 'DESC')->where('del_status', "Live")->get();
        if ($coid && $pid) {
            $product = FinishedProduct::where('id', $pid)->where('del_status', 'Live')->first();
            $selected_product_id = $product->id;
            $selected_st_method = $product->stock_method;
            $selected_customer_id = CustomerOrder::where('id', $coid)->where('del_status', 'Live')->where('order_status', '1')->pluck('customer_id')->first();
            $selected_customer_order_id = CustomerOrder::where('id', $coid)->where('del_status', 'Live')->where('order_status', '1')->pluck('id')->first();
            $customerOrderList = CustomerOrder::where('customer_id', $selected_customer_id)->where('del_status', "Live")->where('order_status', '1')->orderBy('id', 'DESC')->get();
            $manufactures = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
            // dd($selected_product_id);
        } else {
            $selected_product_id = null;
            $selected_st_method = null;
            $selected_customer_id = null;
            $selected_customer_order_id = null;
            $customerOrderList = [];
            $manufactures = [];
        }
        // dd($p_stages);
        return view('pages.manufacture.addEditManufacture', compact('title', 'ref_no', 'rmaterials', 'p_stages', 'nonitem', 'units', 'tax_items', 'lab_tax_items', 'sale_tax_items', 'manufactures', 'rm', 'accounts', 'customers', 'selected_customer_id', 'selected_customer_order_id', 'selected_product_id', 'selected_st_method', 'customerOrderList', 'employees', 'drawers'));
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
        request()->validate([
            // 'manufacture_type' => 'required|max:150',
            'stk_mat_type' => 'required',
            /* 'reference_no' => [
                'required',
                'max:50',
                Rule::unique('tbl_manufactures', 'reference_no')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ], */
            'manufacture_status' => 'required|max:50',
            'product_id' => 'required|max:50',
            'product_quantity' => 'required|max:50',
            'note' => 'nullable|max:200',
            'drawer_no' => 'required',
            'start_date_m' => 'required',
            'complete_date_m' => 'required_if:manufacture_status,done',
            'file_button.*' => 'max:5120|mimes:jpeg,jpg,png,gif,doc,docx,pdf,txt',
        ]);

        DB::beginTransaction();
        try {
            $product_id = $request->get('product_id');
            $p_id = explode('|', $product_id);
            $obj = new \App\Manufacture();
            // $obj->manufacture_type = escape_output($request->get('manufacture_type'));
            $obj->manufacture_status = escape_output($request->get('manufacture_status'));
            $obj->product_id = null_check(escape_output($p_id[0]));
            $obj->drawer_no = null_check(escape_output($request->get('drawer_no')));
            $obj->product_quantity = null_check(escape_output($request->get('product_quantity')));
            $obj->tax_type = null_check(escape_output($request->get('tax_type')));
            $obj->tax_value = null_check(escape_output($request->get('tax_value')));
            $obj->batch_no = null_check(escape_output($request->get('batch_no')));
            $obj->expiry_days = null_check(escape_output($request->get('expiry_days')));
            $obj->start_date = date('Y-m-d', strtotime(escape_output($request->get('start_date_m'))));
            $obj->complete_date = $request->get('complete_date_m') ? date('Y-m-d', strtotime(escape_output($request->get('complete_date_m')))) : null;
            $obj->mrmcost_total = null_check(escape_output($request->get('mrmcost_total')));
            $obj->mnoninitem_total = null_check(escape_output($request->get('mnoninitem_total')));
            $obj->mtotal_cost = null_check(escape_output($request->get('mtotal_cost')));
            $obj->mprofit_margin = null_check(escape_output($request->get('mprofit_margin')));
            $obj->msale_price = null_check(escape_output($request->get('msale_price')));
            $obj->note = html_entity_decode($request->get('note'));
            $obj->stage_counter = null_check(escape_output($request->get('stage_counter')));
            $obj->stage_name = escape_output($request->get('stage_name'));
            $obj->stk_mat_type = escape_output($request->get('stk_mat_type'));
            $obj->rev = escape_output($request->get('rev'));
            $obj->operation = escape_output($request->get('operation'));
            // $obj->dc_no = escape_output($request->get('dc_no'));

            // if ($request->get('manufacture_type') == 'fco') {
            if ($request->get('selected_customer_id') != '' && $request->get('selected_customer_order_id') != '') {
                $obj->customer_id = null_check(escape_output($request->get('selected_customer_id')));
                $obj->customer_order_id = null_check(escape_output($request->get('selected_customer_order_id')));
            } else {
                $obj->customer_id = null_check(escape_output($request->get('customer_id')));
                $obj->customer_order_id = null_check(escape_output($request->get('customer_order_id')));
            }
            // }
            $customerOrder = CustomerOrder::where('id', $obj->customer_order_id)->where('del_status', 'Live')->first();
            if ($customerOrder->order_type == 'Quotation') {
                $prefix = 'L';
            } else {
                $prefix = 'S';
            }
            $lastRecord = Manufacture::where('reference_no', 'like', $prefix . '%')
                ->orderBy('id', 'desc')
                ->first();
            if ($lastRecord) {
                $lastNumber = intval(substr($lastRecord->reference_no, 1));
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }
            $obj->reference_no = $prefix . str_pad($nextNumber, 8, '0', STR_PAD_LEFT);
            $file = '';
            if ($request->hasFile('file_button')) {
                $files = $request->file('file_button');
                $fileNames = [];
                foreach ($files as $file) {
                    $filename = $file->getClientOriginalName();
                    $fileNames[] = time() . "_" . $filename;
                    $file->move(base_path('uploads/manufacture'), $fileNames[count($fileNames) - 1]);
                }
                $obj->file = implode(',', $fileNames);
            }
            $obj->added_by = auth()->user()->id;

            $obj->save();
            $last_id = $obj->id;
            $rm_id = $request->get('rm_id');
            foreach ($rm_id as $row => $value) {
                $rmId = explode('|', $value);
                $obj = new \App\Mrmitem();
                $obj->rmaterials_id = null_check($rmId[0]);
                $obj->stock_id = null_check(escape_output($_POST['stock_id'][$row]));
                $obj->stock = null_check(escape_output($_POST['stock'][$row]));
                $obj->consumption = null_check(escape_output($_POST['quantity_amount'][$row]));
                $obj->manufacture_id = null_check($last_id);
                $obj->save();

                $stock = MaterialStock::find($_POST['stock_id'][$row]);
                $stock->current_stock = $stock->current_stock - $_POST['quantity_amount'][$row];
                $stock->float_stock = $_POST['quantity_amount'][$row];
                $stock->save();
            }
            $noniitem_id = $request->get('noniitem_id');
            if (isset($noniitem_id) && $noniitem_id) {
                foreach ($noniitem_id as $row => $value) {
                    $noiId = explode('|', $value);
                    $obj = new \App\Mnonitem();
                    $obj->noninvemtory_id = null_check($noiId[0]);
                    $obj->nin_cost = null_check(escape_output($_POST['total_1'][$row]));
                    $obj->account_id = null_check(escape_output($_POST['account_id'][$row]));
                    $obj->manufacture_id = null_check($last_id);
                    $obj->save();
                }
            }

            // $total_months = $request->t_month;
            // $total_days = $request->t_day;
            $total_hours = $request->t_hours;
            $total_minutes = $request->t_minute;
            $producstage_id = $request->get('producstage_id');
            $product_quantity = $request->get('product_quantity');
            if (isset($producstage_id) && $producstage_id) {
                foreach ($producstage_id as $row => $value) {
                    $obj = new \App\Mstages();
                    $obj->productionstage_id = null_check($value);
                    $obj->stage_month = 0;
                    $obj->stage_day = 0;
                    $obj->stage_hours = null_check(escape_output($_POST['stage_hours'][$row]));
                    $obj->stage_minute = null_check(escape_output($_POST['stage_minute'][$row]));
                    $obj->manufacture_id = null_check($last_id);
                    $obj->save();
                }
            }
            if ($request->productionstage_id_scheduling != null) {
                foreach ($request->productionstage_id_scheduling as $key => $value) {
                    $productionstage_id_scheduling = $value;
                    $productionstage_id_scheduling = explode('|', $productionstage_id_scheduling);
                    $productionScheduling = new ProductionScheduling();
                    $productionScheduling->manufacture_id = null_check($last_id);
                    $productionScheduling->production_stage_id = null_check($productionstage_id_scheduling[0]);
                    $productionScheduling->task = $request->task[$key];
                    $productionScheduling->task_note = $request->task_note[$key];
                    $productionScheduling->task_status = $request->task_status[$key] ?? "1";
                    $productionScheduling->user_id = $request->user_id_scheduling[$key];
                    $productionScheduling->task_hours = $request->task_hours[$key] ? $request->task_hours[$key] : 0;
                    $productionScheduling->start_date = date('Y-m-d', strtotime($request->start_date[$key]));
                    $productionScheduling->end_date = date('Y-m-d', strtotime($request->complete_date[$key]));
                    $productionScheduling->save();
                }
            }

            $str_consumed_time = " Hour(s): " . $total_hours . " Min.(s) :" . $total_minutes;

            //update for consumed time
            $obj = Manufacture::find($last_id);
            $obj->consumed_time = $str_consumed_time;
            $obj->save();

            //update finish product stock for done
            if ($obj->manufacture_status == 'done') {
                $finishedProduct = FinishedProduct::findOrFail($obj->product_id);

                $newStock = $finishedProduct->current_total_stock + $obj->product_quantity;

                $finishedProduct->current_total_stock = $newStock;
                $finishedProduct->save();
            }

            DB::commit();

            return redirect('productions')->with(saveMessage());
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
        $manufacture = Manufacture::find(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.view_details_manufactures');
        $units = Unit::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $manufactures = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $rmaterials = RawMaterial::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $nonitem = NonIItem::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $p_stages = ProductionStage::orderBy('id', 'ASC')->where('del_status', "Live")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        // $tax_items = TaxItems::where('tax_type',$manufacture->tax_type)->first();
        // $tax_fields = Tax::where('tax_id',$tax_items->id)->where('del_status', "Live")->orderBy('id', 'ASC')->get();
        $m_rmaterials = Mrmitem::orderBy('id', 'ASC')->where('manufacture_id', $manufacture->id)->where('del_status', "Live")->get();
        $m_nonitems = Mnonitem::orderBy('id', 'ASC')->where('manufacture_id', $manufacture->id)->where('del_status', "Live")->get();
        $m_stages = Mstages::orderBy('id', 'ASC')->where('manufacture_id', $manufacture->id)->where('del_status', "Live")->get();
        $obj = $manufacture;
        $productionScheduling = ProductionScheduling::where('manufacture_id', $manufacture->id)->get();
        return view('pages.manufacture.viewDetails', compact('title', 'obj', 'rmaterials', 'productionScheduling', 'p_stages', 'manufactures', 'nonitem', 'accounts', 'm_rmaterials', 'm_nonitems', 'm_stages', 'units'));
    }

    public function printManufactureDetails($id)
    {
        $title = __('index.view_details_manufactures');
        $units = Unit::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $manufactures = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $rmaterials = RawMaterial::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $nonitem = NonIItem::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $p_stages = ProductionStage::orderBy('id', 'ASC')->where('del_status', "Live")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $tax_fields = Tax::orderBy('id', 'ASC')->where('del_status', "Live")->get();
        $tax_items = TaxItems::first();
        $m_rmaterials = Mrmitem::orderBy('id', 'ASC')->where('manufacture_id', $id)->where('del_status', "Live")->get();
        $m_nonitems = Mnonitem::orderBy('id', 'ASC')->where('manufacture_id', $id)->where('del_status', "Live")->get();
        $m_stages = Mstages::orderBy('id', 'ASC')->where('manufacture_id', $id)->where('del_status', "Live")->get();
        $obj = Manufacture::find($id);
        return view('pages.manufacture.print_manufacture_details', compact('title', 'obj', 'rmaterials', 'p_stages', 'manufactures', 'nonitem', 'accounts', 'tax_fields', 'm_rmaterials', 'm_nonitems', 'm_stages', 'units', 'tax_items'));
    }

    public function downloadManufactureDetails($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $title = __('index.view_details_manufactures');
        $units = Unit::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $manufactures = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $rmaterials = RawMaterial::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $nonitem = NonIItem::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $p_stages = ProductionStage::orderBy('id', 'ASC')->where('del_status', "Live")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $tax_fields = Tax::orderBy('id', 'ASC')->where('del_status', "Live")->get();
        $tax_items = TaxItems::first();
        $m_rmaterials = Mrmitem::orderBy('id', 'ASC')->where('manufacture_id', $id)->where('del_status', "Live")->get();
        $m_nonitems = Mnonitem::orderBy('id', 'ASC')->where('manufacture_id', $id)->where('del_status', "Live")->get();
        $m_stages = Mstages::orderBy('id', 'ASC')->where('manufacture_id', $id)->where('del_status', "Live")->get();
        $obj = Manufacture::find($id);

        $pdf = Pdf::loadView('pages.manufacture.print_manufacture_details', compact('title', 'obj', 'rmaterials', 'p_stages', 'manufactures', 'nonitem', 'accounts', 'tax_fields', 'm_rmaterials', 'm_nonitems', 'm_stages', 'units', 'tax_items'))->setPaper('a4', 'landscape');
        return $pdf->download($obj->reference_no . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $manufacture = Manufacture::find(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.edit_manufacture');
        $units = Unit::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $manufactures = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $rmaterials = RawMaterial::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $nonitem = NonIItem::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        // $p_stages = ProductionStage::orderBy('id', 'ASC')->where('del_status', "Live")->get();
        $p_stages = DB::select("SELECT * FROM tbl_finished_products_productionstage WHERE del_status='Live' AND finish_product_id='$manufacture->product_id' ORDER BY id ASC");
        $employees = User::with('role')
            ->whereHas('role', function ($query) {
                $query->where('title', 'Operators');
            })
            ->where('del_status', 'Live')
            ->orderBy('emp_code', 'ASC')
            ->get();
        $qc_employees = User::with('role')
            ->whereHas('role', function ($query) {
                $query->where('title', 'Quality Control');
            })
            ->where('del_status', 'Live')
            ->orderBy('emp_code', 'ASC')
            ->get();
        $drawers = Drawer::where('del_status', 'Live')->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $tax_fields = Tax::orderBy('id', 'ASC')->where('del_status', "Live")->get();
        $tax_items = TaxItems::first();
        $m_rmaterials = Mrmitem::orderBy('id', 'ASC')->where('manufacture_id', $manufacture->id)->where('del_status', "Live")->get();
        $m_nonitems = Mnonitem::orderBy('id', 'ASC')->where('manufacture_id', $manufacture->id)->where('del_status', "Live")->get();
        $m_stages = Mstages::orderBy('id', 'ASC')->where('manufacture_id', $manufacture->id)->where('del_status', "Live")->get();
        $obj = $manufacture;
        $obj2 = new FPproductionstage();
        $finishProductStage = $obj->getProductStages($manufacture->id);
        $customers = Customer::orderBy('id', 'DESC')->where('del_status', "Live")->get();
        $productionScheduling = ProductionScheduling::where('manufacture_id', $manufacture->id)->where('del_status', "Live")->get();
        $selected_customer_id = $obj->customer_id;
        $selected_customer_order_id = $obj->customer_order_id;
        $customerOrderList = CustomerOrder::where('customer_id', $manufacture->customer_id)->where('del_status', "Live")->where('order_status', '1')->orderBy('id', 'DESC')->get();
        $qc_statuses = QcStatus::orderBy('id', 'ASC')->get();
        $move_to_next = ProductionScheduling::where('manufacture_id', $manufacture->id)->where('del_status', 'Live')->orderBy('id', 'DESC')->pluck('move_to_next')->first();
        return view('pages.manufacture.addEditManufacture', compact('title', 'obj', 'rmaterials', 'productionScheduling', 'p_stages', 'manufactures', 'nonitem', 'accounts', 'tax_fields', 'm_rmaterials', 'm_nonitems', 'm_stages', 'units', 'tax_items', 'finishProductStage', 'customers', 'selected_customer_id', 'selected_customer_order_id', 'customerOrderList', 'employees', 'drawers', 'qc_employees', 'qc_statuses', 'move_to_next'));
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
        // dd($request->all());
        $manufacture = Manufacture::find($id);
        request()->validate([
            // 'manufacture_type' => 'required|max:150',
            /* 'reference_no' => [
                'required',
                'max:50',
                Rule::unique('tbl_manufactures', 'reference_no')->ignore($manufacture->id,'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ], */
            'manufacture_status' => 'required|max:50',
            'note' => 'nullable|max:200',
            'product_id' => 'required|max:50',
            'product_quantity' => 'required|max:50',
            'drawer_no' => 'required',
        ]);
        // $manufacture->reference_no = null_check(escape_output($request->get('reference_no')));
        // $manufacture->manufacture_type = escape_output($request->get('manufacture_type'));
        $manufacture->manufacture_status = escape_output($request->get('manufacture_status'));
        $manufacture->product_id = null_check(escape_output($request->get('product_id')));
        $manufacture->product_quantity = null_check(escape_output($request->get('product_quantity')));
        $manufacture->drawer_no = null_check(escape_output($request->get('drawer_no')));
        $manufacture->batch_no = null_check(escape_output($request->get('batch_no')));
        $manufacture->expiry_days = null_check(escape_output($request->get('expiry_days')));
        $manufacture->start_date = date('Y-m-d', strtotime(escape_output($request->get('start_date_m'))));
        $manufacture->complete_date = $request->get('complete_date_m') ? date('Y-m-d', strtotime(escape_output($request->get('complete_date_m')))) : null;
        $manufacture->tax_type = null_check(escape_output($request->get('tax_type')));
        $manufacture->tax_value = null_check(escape_output($request->get('tax_value')));
        $manufacture->mrmcost_total = null_check(escape_output($request->get('mrmcost_total')));
        $manufacture->mnoninitem_total = null_check(escape_output($request->get('mnoninitem_total')));
        $manufacture->mtotal_cost = null_check(escape_output($request->get('mtotal_cost')));
        $manufacture->mprofit_margin = null_check(escape_output($request->get('mprofit_margin')));
        $manufacture->msale_price = null_check(escape_output($request->get('msale_price')));
        $manufacture->note = html_entity_decode($request->get('note'));
        $manufacture->stage_counter = null_check(escape_output($request->get('stage_counter')));
        $manufacture->stage_name = escape_output($request->get('stage_name'));
        $manufacture->rev = escape_output($request->get('rev'));
        $manufacture->operation = escape_output($request->get('operation'));
        // $manufacture->dc_no = escape_output($request->get('dc_no'));

        //generate json data for tax value
        // if ($request->get('manufacture_type') == 'fco') {
        $manufacture->customer_id = null_check(escape_output($request->get('selected_customer_id')));
        $manufacture->customer_order_id = null_check(escape_output($request->get('selected_customer_order_id')));
        // }
        $file = $manufacture->file;
        if ($request->hasFile('file_button')) {
            $files = $request->file('file_button');
            $fileNames = [];
            foreach ($files as $file) {
                @unlink(base_path('uploads/manufacture/' . $file));
                $filename = $file->getClientOriginalName();
                $fileNames[] = time() . "_" . $filename;
                $file->move(base_path('uploads/manufacture'), $fileNames[count($fileNames) - 1]);
            }
            $manufacture->file = implode(',', $fileNames);
        } else {
            $manufacture->file = $file;
        }
        $manufacture->save();
        $last_id = $manufacture->id;

        Mrmitem::where('manufacture_id', $manufacture->id)->update(['del_status' => "Deleted"]);
        Mnonitem::where('manufacture_id', $manufacture->id)->update(['del_status' => "Deleted"]);
        Mstages::where('manufacture_id', $manufacture->id)->update(['del_status' => "Deleted"]);

        $rm_id = $request->get('rm_id');
        foreach ($rm_id as $row => $value) {
            $obj = new \App\Mrmitem();
            $obj->rmaterials_id = null_check($value);
            $obj->stock_id = null_check(escape_output($_POST['stock_id'][$row]));
            $obj->stock = null_check(escape_output($_POST['stock'][$row]));
            $obj->consumption = null_check(escape_output($_POST['quantity_amount'][$row]));
            $obj->manufacture_id = null_check($last_id);
            $obj->save();
        }

        $noniitem_id = $request->get('noniitem_id');
        if (isset($noniitem_id) && $noniitem_id) {
            foreach ($noniitem_id as $row => $value) {
                $obj = new \App\Mnonitem();
                $obj->noninvemtory_id = null_check($value);
                $obj->nin_cost = null_check(escape_output($_POST['total_1'][$row]));
                $obj->account_id = null_check(escape_output($_POST['account_id'][$row]));
                $obj->manufacture_id = null_check($last_id);
                $obj->save();
            }
        }
        // $total_months = $request->t_month;
        // $total_days = $request->t_day;
        $total_hours = $request->t_hours;
        $total_minutes = $request->t_minute;
        $producstage_id = $request->get('producstage_id');
        $product_quantity = $request->get('product_quantity');
        if (isset($producstage_id) && $producstage_id) {
            foreach ($producstage_id as $row => $value) {
                $obj = new \App\Mstages();
                $obj->productionstage_id = $value;
                $obj->stage_month = 0;
                $obj->stage_day = 0;
                $obj->stage_hours = null_check(escape_output($_POST['stage_hours'][$row]));
                $obj->stage_minute = null_check(escape_output($_POST['stage_minute'][$row]));
                $obj->manufacture_id = null_check($last_id);
                $obj->save();
            }
        }

        if ($request->productionstage_id_scheduling != null) {
            foreach ($request->productionstage_id_scheduling as $key => $value) {
                $split = explode('|', $value);
                $productionStageId = null_check($split[0]);
                $task = $request->task[$key];
                $userId = $request->user_id_scheduling[$key];
                $taskNote = $request->task_note[$key];
                $taskStatus = $request->task_status[$key];
                $taskHours = $request->task_hours[$key] ? $request->task_hours[$key] : 0;
                $startDate = date('Y-m-d', strtotime($request->start_date[$key]));
                $endDate = date('Y-m-d', strtotime($request->complete_date[$key]));
                $existing = ProductionScheduling::where('manufacture_id', $last_id)
                    ->where('production_stage_id', $productionStageId)
                    ->where('del_status', '!=', 'Deleted')
                    ->first();
                if ($existing) {
                    if ($existing->user_id != $userId || $existing->task_status != $taskStatus) {
                        $existing->del_status = 'Deleted';
                        $existing->save();
                        $new = new ProductionScheduling();
                        $new->manufacture_id = null_check($last_id);
                        $new->production_stage_id = $productionStageId;
                        $new->task = $task;
                        $new->user_id = $userId;
                        $new->task_note = $taskNote;
                        $new->task_status = $taskStatus;
                        $new->task_hours = $taskHours;
                        $new->start_date = $startDate;
                        $new->end_date = $endDate;
                        $new->save();
                    }
                } else {
                    $new = new ProductionScheduling();
                    $new->manufacture_id = null_check($last_id);
                    $new->production_stage_id = $productionStageId;
                    $new->task = $task;
                    $new->user_id = $userId;
                    $new->task_note = $taskNote;
                    $new->task_status = $taskStatus;
                    $new->task_hours = $taskHours;
                    $new->start_date = $startDate;
                    $new->end_date = $endDate;
                    $new->save();
                }
            }
        }

        $str_consumed_time = " Hour(s): " . $total_hours . " Min.(s) :" . $total_minutes;

        //update for consumed time
        $obj = Manufacture::find($last_id);
        $obj->consumed_time = $str_consumed_time;
        $obj->save();

        $previous_status = $request->previous_status;
        if ($previous_status == 'done') {
            if ($obj->manufacture_status == 'inProgress' || $obj->manufacture_status == 'draft') {
                $finishedProduct = FinishedProduct::findOrFail($obj->product_id);
                $newStock = $finishedProduct->current_total_stock - $obj->product_quantity;
                $finishedProduct->current_total_stock = $newStock;
                $finishedProduct->save();
            }
        }

        //update finish product stock for done
        if ($obj->manufacture_status == 'done') {
            $finishedProduct = FinishedProduct::findOrFail($obj->product_id);

            $newStock = $finishedProduct->current_total_stock + $obj->product_quantity;

            $finishedProduct->current_total_stock = $newStock;
            $finishedProduct->save();
        }

        return redirect('productions')->with(updateMessage());
    }

    public function destroy(Manufacture $manufacture)
    {
        Mrmitem::where('manufacture_id', $manufacture->id)->update(['del_status' => "Deleted"]);
        Mnonitem::where('manufacture_id', $manufacture->id)->update(['del_status' => "Deleted"]);
        Mstages::where('manufacture_id', $manufacture->id)->update(['del_status' => "Deleted"]);

        $manufacture->del_status = "Deleted";
        $manufacture->save();
        
        return redirect('productions')->with(deleteMessage());
    }
    public function duplicate($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $title = __('index.duplicate_manufacture');
        $units = Unit::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $manufactures = FinishedProduct::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $rmaterials = RawMaterial::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $nonitem = NonIItem::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $p_stages = ProductionStage::orderBy('id', 'ASC')->where('del_status', "Live")->get();
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $tax_fields = Tax::orderBy('id', 'ASC')->where('del_status', "Live")->get();
        $tax_items = TaxItems::first();
        $m_rmaterials = Mrmitem::orderBy('id', 'ASC')->where('manufacture_id', $id)->where('del_status', "Live")->get();
        $m_nonitems = Mnonitem::orderBy('id', 'ASC')->where('manufacture_id', $id)->where('del_status', "Live")->get();
        $m_stages = Mstages::orderBy('id', 'ASC')->where('manufacture_id', $id)->where('del_status', "Live")->get();
        $obj = Manufacture::find($id);
        $obj_rm = Manufacture::count();
        $ref_no = "MP-" . str_pad($obj_rm + 1, 6, '0', STR_PAD_LEFT);

        $customers = Customer::orderBy('id', 'DESC')->where('del_status', "Live")->get();
        return view('pages.manufacture.duplicateManufacture', compact('customers', 'title', 'obj', 'rmaterials', 'p_stages', 'manufactures', 'nonitem', 'accounts', 'tax_fields', 'm_rmaterials', 'm_nonitems', 'm_stages', 'units', 'tax_items', 'ref_no'));
    }

    public function duplicate_store(Request $request)
    {
        request()->validate([
            'manufacture_type' => 'required|max:150',
            'reference_no' => 'required|max:50',
            'manufacture_status' => 'required|max:50',
            'product_id' => 'required|max:50',
            'product_quantity' => 'required|max:50',
        ]);

        $obj = new \App\Manufacture();
        $obj->reference_no = null_check(escape_output($request->get('reference_no')));
        $obj->manufacture_type = escape_output($request->get('manufacture_type'));
        $obj->manufacture_status = escape_output($request->get('manufacture_status'));
        $obj->product_id = null_check(escape_output($request->get('product_id')));
        $obj->product_quantity = null_check(escape_output($request->get('product_quantity')));
        $obj->batch_no = null_check(escape_output($request->get('batch_no')));
        $obj->expiry_days = null_check(escape_output($request->get('expiry_days')));
        $obj->start_date = escape_output($request->get('start_date'));
        $obj->complete_date = escape_output($request->get('complete_date'));
        $obj->mrmcost_total = null_check(escape_output($request->get('mrmcost_total')));
        $obj->mnoninitem_total = null_check(escape_output($request->get('mnoninitem_total')));
        $obj->mtotal_cost = null_check(escape_output($request->get('mtotal_cost')));
        $obj->mprofit_margin = null_check(escape_output($request->get('mprofit_margin')));
        $obj->msale_price = null_check(escape_output($request->get('msale_price')));
        $obj->note = escape_output($request->get('note'));
        $obj->stage_counter = null_check(escape_output($request->get('stage_counter')));
        $file = '';
        if ($request->hasFile('file_button')) {
            if ($request->hasFile('file_button')) {
                $image = $request->file('file_button');
                $filename = $image->getClientOriginalName();
                $file = time() . "_" . $filename;
                $request->file_button->move(base_path('uploads/manufacture'), $file);
            }
        }
        $obj->file = $file;

        $obj->added_by = auth()->user()->id;
        $obj->save();
        $last_id = $obj->id;

        $rm_id = $request->get('rm_id');
        foreach ($rm_id as $row => $value) {
            $obj = new \App\Mrmitem();
            $obj->rmaterials_id = null_check($value);
            $obj->unit_price = null_check(escape_output($_POST['unit_price'][$row]));
            $obj->consumption = null_check(escape_output($_POST['quantity_amount'][$row]));
            $obj->total_cost = null_check(escape_output($_POST['total'][$row]));
            $obj->manufacture_id = null_check($last_id);
            $obj->save();
        }
        $noniitem_id = $request->get('noniitem_id');
        if (isset($noniitem_id) && $noniitem_id) {
            foreach ($noniitem_id as $row => $value) {
                $obj = new \App\Mnonitem();
                $obj->noninvemtory_id = null_check($value);
                $obj->nin_cost = null_check(escape_output($_POST['total_1'][$row]));
                $obj->account_id = null_check(escape_output($_POST['account_id'][$row]));
                $obj->manufacture_id = null_check($last_id);
                $obj->save();
            }
        }

        $total_month = 0;
        $total_day = 0;
        $total_hour = 0;
        $total_mimute = 0;

        $total_months = 0;
        $total_days = 0;
        $total_hours = 0;
        $total_minutes = 0;
        $checker = false;
        $producstage_id = $request->get('producstage_id');
        $product_quantity = $request->get('product_quantity');
        if (isset($producstage_id) && $producstage_id) {
            foreach ($producstage_id as $row => $value) {
                $stage_check = $request->get('stage_counter');
                $tmp_row = $row + 1;
                if ($checker == false) {
                    $total_value = (($_POST['stage_month'][$row] * 2592000) + ($_POST['stage_day'][$row] * 86400) + ($_POST['stage_hours'][$row] * 3600) + ($_POST['stage_minute'][$row] * 60)) * $product_quantity;
                    $months = floor($total_value / 2592000);
                    $hours = floor(($total_value % 86400) / 3600);
                    $days = floor(($total_value % 2592000) / 86400);
                    $minuts = floor(($total_value % 3600) / 60);

                    $total_month += $months;
                    $total_hour += $hours;
                    $total_day += $days;
                    $total_mimute += $minuts;
                    $total_stages = ($total_month * 2592000) + ($total_hour * 3600) + ($total_day * 86400) + $total_mimute * 60;
                    $total_months = floor($total_stages / 2592000);
                    $total_hours = floor(($total_stages % 86400) / 3600);
                    $total_days = floor(($total_stages % 2592000) / 86400);
                    $total_minutes = floor(($total_stages % 3600) / 60);
                }

                $obj = new \App\Mstages();
                $obj->productionstage_id = $value;
                $obj->stage_month = null_check(escape_output($_POST['stage_month'][$row]));
                $obj->stage_day = null_check(escape_output($_POST['stage_day'][$row]));
                $obj->stage_hours = null_check(escape_output($_POST['stage_hours'][$row]));
                $obj->stage_minute = null_check(escape_output($_POST['stage_minute'][$row]));
                $obj->manufacture_id = null_check($last_id);
                $obj->save();

                if ($stage_check == $tmp_row) {
                    $checker = true;
                }
            }
        }

        $str_consumed_time = "Month(s): " . $total_months . " Day(s): " . $total_days . " Hour(s): " . $total_hours . " Min.(s) :" . $total_minutes;

        //update for consumed time
        $obj = Manufacture::find($last_id);
        $obj->consumed_time = $str_consumed_time;
        $obj->save();
        return redirect('productions')->with(saveMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Partillay Done the specified resource from storage.
     */

    public function changePartiallyDone(Request $request)
    {
        $manufacture = Manufacture::find($request->manufacture_id);
        $total_quantity = $manufacture->product_quantity;
        $partially_done_quantity = $manufacture->partially_done_quantity;
        $remaining_quantity = $total_quantity - $partially_done_quantity;

        $input_partially_done_quantity = $request->partially_done_quantity;
        if ($input_partially_done_quantity > $remaining_quantity) {
            return redirect('productions')->with(dangerMessage(__('index.partially_done_quantity_cannot_greater')));
        }

        $manufacture->partially_done_quantity += $input_partially_done_quantity;
        $manufacture->save();

        if ($manufacture->product_quantity == $manufacture->partially_done_quantity) {
            $manufacture->complete_date = date('Y-m-d');
            $manufacture->manufacture_status = 'done';
            $manufacture->save();
        }

        if ($manufacture->manufacture_status == 'done') {
            $finishedProduct = FinishedProduct::findOrFail($manufacture->product_id);

            $newStock = $finishedProduct->current_total_stock + $input_partially_done_quantity;

            $finishedProduct->current_total_stock = $newStock;
            $finishedProduct->save();
        }

        return redirect('productions')->with(updateMessage());
    }

    /**
     * updateProducedQuantityData
     */

    public function updateProducedQuantityData(Request $request)
    {
        $manufacture = Manufacture::find($request->id);
        $customer_id = $manufacture->customer_order_id;

        $productionHistory = ProductionHistory::where('work_order_id', $customer_id)->get();

        $table = '';
        if (empty($productionHistory)) {
            $table .= '<tr>';
            $table .= '<td colspan="3" class="text-center">' . __('index.no_data_found') . '</td>';
            $table .= '</tr>';
        } else {
            foreach ($productionHistory as $key => $value) {
                $table .= '<tr>';
                $table .= '<td>' . ++$key . '</td>';
                $table .= '<td class="text-center">' . $value->produced_quantity . '</td>';
                $table .= '<td>' . getDateFormat($value->produced_date) . '</td>';
                $table .= '</tr>';
            }
        }

        $totalProducedQuantity = ProductionHistory::where('work_order_id', $customer_id)->sum('produced_quantity');
        $totalQuantity = $manufacture->product_quantity;
        $remainingQuantity = $totalQuantity - $totalProducedQuantity;

        $array = [
            'table' => $table,
            'remainingQuantity' => $remainingQuantity,
        ];

        return response()->json($array);
    }

    public function updateProducedQuantity(Request $request)
    {
        $manufacture = Manufacture::find($request->manufacture_id);
        $customer_id = $manufacture->customer_order_id;

        $productionHistory = new ProductionHistory();
        $productionHistory->work_order_id = $customer_id;
        $productionHistory->produced_quantity = $request->produced_quantity;
        $productionHistory->produced_date = date('Y-m-d');
        $productionHistory->save();

        return redirect('productions')->with(updateMessage());
    }

    public function getProductionScheduling(Request $request)
    {
        $id = $request->id;
        //Production Schedule get with production stage name
        $productionScheduling = ProductionScheduling::where('manufacture_id', $id)->where('del_status', 'Live')->get();
        $productionScheduling = $productionScheduling->map(function ($item) {
            $item->production_stage_name = getProductionStages($item->production_stage_id);
            return $item;
        });

        return response()->json($productionScheduling);
    }

    public function task_track($id)
    {
        $manufacture = Manufacture::find(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.track_sch_task');
        $obj = $manufacture;
        $productionScheduling = ProductionScheduling::where('manufacture_id', $manufacture->id)->get();
        return view('pages.manufacture.track_sch_task', compact('title', 'obj', 'productionScheduling'));
    }
    public function drawer_image($id)
    {
        $manufacture = Manufacture::find(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.view_drawer_img');
        $obj = $manufacture;
        $drawer = Drawer::where('drawer_no', $manufacture->drawer_no)->first();
        return view('pages.manufacture.view_drawer_img', compact('title', 'obj', 'drawer'));
    }
    public function updateQcScheduling(Request $request)
    {
        // dd($request->all());
        $qc_user_id = $request->qc_user_id;
        // $qc_status = $request->qc_status;
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $complete_date = date('Y-m-d', strtotime($request->complete_date));
        $manufacture_id = $request->manufacture_id;
        $scheduling_id = $request->scheduling_id;
        $qc_note = $request->qc_note;
        $production_stage_id = $request->production_stage_id;
        $production_qc_scheduling =  new ProductionQCScheduling();
        $production_qc_scheduling->qc_user_id =  $qc_user_id;
        $production_qc_scheduling->qc_status =  "0";
        $production_qc_scheduling->start_date =  $start_date;
        $production_qc_scheduling->complete_date =  $complete_date;
        $production_qc_scheduling->manufacture_id =  $manufacture_id;
        $production_qc_scheduling->scheduling_id =  $scheduling_id;
        $production_qc_scheduling->production_stage_id =  $production_stage_id;
        $production_qc_scheduling->note =  $qc_note;
        $production_qc_scheduling->save();
        return response()->json(['result' => true, 'message' => "QC Added Successfully"]);
    }
    public function getQCAssignLog(Request $request)
    {
        $manufacture_id = $request->manufacture_id;
        $production_stage_id = $request->production_stage_id;
        $scheduling_id = $request->scheduling_id;
        $qclog = [];
        if (!empty($scheduling_id)) {
            $qc_logs = ProductionQCScheduling::where('scheduling_id', $scheduling_id)->where('manufacture_id', $manufacture_id)->where('production_stage_id', $production_stage_id)->where('del_status', 'Live')->get();
            $production_scheduling = ProductionScheduling::where('id', $scheduling_id)->where('del_status', 'Live')->orderBy('id', 'DESC')->first();
            foreach ($qc_logs as $log) {
                $statuses = QcStatus::orderBy('id', 'ASC')->get();
                $stage_name = getProductionStage($log->production_stage_id);
                $qclog[] = [
                    'id' => $log->id,
                    'stage_name' => $stage_name,
                    'emp_name' => getEmpCode($log->qc_user_id),
                    'start_date' => date('d-m-Y', strtotime($log->start_date)),
                    'complete_date' => date('d-m-Y', strtotime($log->complete_date)),
                    'statuses' => $statuses,
                    'status' => $log->qc_status,
                    'note' => $log->note,
                    'move_to_next' => $production_scheduling->move_to_next,
                ];
            }
        }
        return response()->json($qclog);
    }
    public function updateQCStatus(Request $request)
    {
        $status = $request->status;
        $id = $request->qc_id;
        $qc_log = ProductionQCScheduling::find($id);
        if ($qc_log) {
            $qc_log->qc_status = $status;
            $qc_log->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'QC not found.']);
        }
    }
    public function updateMoveStatus(Request $request)
    {
        $qa_scheduling_id = $request->qa_scheduling_id;
        $move_to_next = $request->move_to_next;
        $product_schedule = ProductionScheduling::find($qa_scheduling_id);
        if ($product_schedule) {
            $product_schedule->move_to_next = 'Y';
            $product_schedule->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Scheduling not found.']);
        }
    }

    public function route_card($id)
    {
        $manufacture = Manufacture::find(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.route_card_detail');
        $units = Unit::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $drawer = Drawer::where('del_status', "Live")->where('drawer_no', $manufacture->drawer_no)->first();
        $product = FinishedProduct::where('del_status', "Live")->where('id', $manufacture->product_id)->first();
        $order = CustomerOrder::where('del_status', "Live")->where('id', $manufacture->customer_order_id)->first();
        $m_rmaterial = Mrmitem::with('materialStock')->where('manufacture_id', $manufacture->id)->where('del_status', "Live")->first();
        $rmaterial = RawMaterial::where('id', $m_rmaterial->rmaterials_id)->where('del_status', "Live")->first();
        $obj = $manufacture;
        $quotation_id = QuotationDetail::where('customer_order_id', $manufacture->customer_order_id)->where('product_id', $manufacture->product_id)->where('del_status', 'Live')->pluck('quotation_id')->first();
        $delivery_challan = Quotation::find($quotation_id);
        $productionScheduling = ProductionScheduling::where('manufacture_id', $manufacture->id)->get();
        $obj2 = new FPproductionstage();
        $finishProductStages = $obj2->getFinishProductStages($manufacture->product_id);
        $latest_form = RouteCardEntry::where('del_status', 'Live')->where('manufacture_id', $manufacture->id)->orderBy('id', 'DESC')->pluck('image')->first();
        return view('pages.manufacture.route_card', compact('title', 'obj', 'rmaterial', 'productionScheduling', 'product', 'm_rmaterial', 'units', 'order', 'drawer', 'delivery_challan', 'finishProductStages', 'latest_form'));
    }
    public function job_card($id)
    {
        $title = __('index.job_card');
        $manufacture = Manufacture::find(encrypt_decrypt($id, 'decrypt'));
        $obj = $manufacture;
        $p_stages = ProductionStage::where('del_status', 'Live')->get();
        $latest_form = JobCardEntry::where('del_status', 'Live')->where('manufacture_id', $manufacture->id)->orderBy('id', 'DESC')->pluck('image')->first();
        return view('pages.manufacture.job_card', compact('title', 'obj', 'p_stages', 'latest_form'));
    }
    public function printRouteCardDetails($id)
    {
        $manufacture = Manufacture::find($id);
        $title = __('index.route_card_detail');
        $units = Unit::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $drawer = Drawer::where('del_status', "Live")->where('drawer_no', $manufacture->drawer_no)->first();
        $product = FinishedProduct::where('del_status', "Live")->where('id', $manufacture->product_id)->first();
        $order = CustomerOrder::where('del_status', "Live")->where('id', $manufacture->customer_order_id)->first();
        $m_rmaterial = Mrmitem::where('manufacture_id', $manufacture->id)->where('del_status', "Live")->first();
        $rmaterial = RawMaterial::where('id', $m_rmaterial->rmaterials_id)->where('del_status', "Live")->first();
        $obj = $manufacture;
        $quotation_id = QuotationDetail::where('customer_order_id', $manufacture->customer_order_id)->where('product_id', $manufacture->product_id)->where('del_status', 'Live')->pluck('quotation_id')->first();
        $delivery_challan = Quotation::find($quotation_id);
        $productionScheduling = ProductionScheduling::where('manufacture_id', $manufacture->id)->get();
        $obj2 = new FPproductionstage();
        $finishProductStages = $obj2->getFinishProductStages($manufacture->product_id);
        $latest_form = RouteCardEntry::where('del_status', 'Live')->where('manufacture_id', $manufacture->id)->orderBy('id', 'DESC')->pluck('image')->first();
        return view('pages.manufacture.print_route_card', compact('title', 'obj', 'rmaterial', 'productionScheduling', 'product', 'm_rmaterial', 'units', 'order', 'drawer', 'delivery_challan', 'finishProductStages', 'latest_form'));
    }
    public function downloadRouteCard($id)
    {
        $manufacture = Manufacture::find(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.route_card_detail');
        $units = Unit::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $drawer = Drawer::where('del_status', "Live")->where('drawer_no', $manufacture->drawer_no)->first();
        $product = FinishedProduct::where('del_status', "Live")->where('id', $manufacture->product_id)->first();
        $order = CustomerOrder::where('del_status', "Live")->where('id', $manufacture->customer_order_id)->first();
        $m_rmaterial = Mrmitem::where('manufacture_id', $manufacture->id)->where('del_status', "Live")->first();
        $rmaterial = RawMaterial::where('id', $m_rmaterial->rmaterials_id)->where('del_status', "Live")->first();
        $obj = $manufacture;
        $quotation_id = QuotationDetail::where('customer_order_id', $manufacture->customer_order_id)->where('product_id', $manufacture->product_id)->where('del_status', 'Live')->pluck('quotation_id')->first();
        $delivery_challan = Quotation::find($quotation_id);
        $productionScheduling = ProductionScheduling::where('manufacture_id', $manufacture->id)->get();
        $obj2 = new FPproductionstage();
        $finishProductStages = $obj2->getFinishProductStages($manufacture->product_id);
        $latest_form = RouteCardEntry::where('del_status', 'Live')->where('manufacture_id', $manufacture->id)->orderBy('id', 'DESC')->pluck('image')->first();
        $pdf = Pdf::loadView('pages.manufacture.print_route_card', compact('title', 'obj', 'rmaterial', 'productionScheduling', 'product', 'm_rmaterial', 'units', 'order', 'drawer', 'delivery_challan', 'finishProductStages', 'latest_form'))->setPaper('a4', 'landscape');
        return $pdf->download($obj->reference_no . '.pdf');
    }
    public function printJobCardDetails($id)
    {
        $manufacture = Manufacture::find($id);
        $title = __('index.job_card');
        $obj = $manufacture;
        $p_stages = ProductionStage::where('del_status', 'Live')->get();
        $latest_form = JobCardEntry::where('del_status', 'Live')->where('manufacture_id', $manufacture->id)->orderBy('id', 'DESC')->pluck('image')->first();
        return view('pages.manufacture.print_job_card', compact('title', 'obj', 'p_stages', 'latest_form'));
    }
    public function downloadJobDetails($id)
    {
        $manufacture = Manufacture::find(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.job_card');
        $obj = $manufacture;
        $p_stages = ProductionStage::where('del_status', 'Live')->get();
        $latest_form = JobCardEntry::where('del_status', 'Live')->where('manufacture_id', $manufacture->id)->orderBy('id', 'DESC')->pluck('image')->first();
        $pdf = Pdf::loadView('pages.manufacture.print_job_card', compact('title', 'obj', 'p_stages', 'latest_form'))->setPaper('a4', 'landscape');
        return $pdf->download($obj->reference_no . '.pdf');
    }
    public function routeCardSubmit(Request $request)
    {
        // dd($request->all());
        $obj = new RouteCardEntry();
        $proofName = '';
        if ($request->hasFile('image')) {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = $image->getClientOriginalName();
                $proofName = time() . "_" . $filename;
                $image->move(base_path() . '/uploads/route_card_form/', $proofName);
            }
            $obj->image = $proofName;
        }
        $obj->manufacture_id = $request->manufacture_id;
        $obj->save();
        return response()->json(['status' => 'success', 'message' => 'File uploaded']);
    }
    public function jobCardSubmit(Request $request)
    {
        // dd($request->all());
        $obj = new JobCardEntry();
        $proofName = '';
        if ($request->hasFile('image')) {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = $image->getClientOriginalName();
                $proofName = time() . "_" . $filename;
                $image->move(base_path() . '/uploads/job_card_form/', $proofName);
            }
            $obj->image = $proofName;
        }
        $obj->manufacture_id = $request->manufacture_id;
        $obj->save();
        return response()->json(['status' => 'success', 'message' => 'File uploaded']);
    }
}
