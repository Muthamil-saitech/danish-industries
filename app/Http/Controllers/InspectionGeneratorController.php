<?php

namespace App\Http\Controllers;

use App\FinishedProduct;
use App\Inspection;
use App\InspectionApprove;
use App\InspectionObservedDimension;
use App\InspectionParam;
use App\Manufacture;
use App\RawMaterial;
use App\MaterialStock;
use App\Role;
use App\User;
use App\Customer;
use App\InspectionReportFile;
use App\Mrmitem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InspectionGeneratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $startDate = '';
        $endDate = '';
        $customer_id = escape_output($request->get('customer_id'));
        unset($request->_token);
        $obj = \App\Manufacture::with('inspect_approval')->whereIn('manufacture_status', ['draft', 'inProgress', 'done'])->where('del_status', 'Live');
        if (isset($request->startDate) && $request->startDate != '') {
            $startDate = $request->startDate;
            $obj->where('start_date', '>=', date('Y-m-d', strtotime($request->startDate)));
        }
        if (isset($request->endDate) && $request->endDate != '') {
            $endDate = $request->endDate;
            $obj->where('complete_date', '<=', date('Y-m-d', strtotime($request->endDate)));
        }
        if (isset($customer_id) && $customer_id != '') {
            $obj->where('customer_id', $customer_id);
        }
        $manufactures = $obj->orderBy('id', 'DESC')->get();
        $customers = Customer::where('del_status', 'Live')->orderBy('id', 'DESC')->get();
        $title = __('index.inspect_list');
        $total_ins_reports = \App\Manufacture::with('inspect_approval')->whereIn('manufacture_status', ['draft', 'inProgress', 'done'])->where('del_status', 'Live')->count();
        //dd($manufactures);
        return view('pages.inspection.inspectionGenerate', compact('title', 'manufactures', 'customers', 'startDate', 'endDate', 'customer_id', 'total_ins_reports'));
    }
    public function show($id)
    {
        $manufacture = \App\Manufacture::with('rawMaterials')->where('id', encrypt_decrypt($id, 'decrypt'))->whereIn('manufacture_status', ['draft', 'inProgress', 'done'])->where('del_status', 'Live')->first();
        $finishProduct = FinishedProduct::where('id', $manufacture->product_id)->where('del_status', 'Live')->first();
        $material = RawMaterial::where('id', $manufacture->rawMaterials[0]->rmaterials_id)->where('del_status', 'Live')->first();
        $mrmaterial = Mrmitem::where('rmaterials_id', $material->id)->where('manufacture_id', $manufacture->id)->where('del_status', 'Live')->first();
        $material_stock = MaterialStock::where('id', $mrmaterial->stock_id)->where('del_status', 'Live')->first();
        $inspection = Inspection::with('details')
            ->where('mat_id', $manufacture->rawMaterials[0]->rmaterials_id)
            ->where('del_status', 'Live')
            ->first();
        $uniqueSetNos = InspectionObservedDimension::where('manufacture_id', $manufacture->id)
            ->where(function ($query) {
                $query->where('di_observed_dimension', '!=', '')
                    ->orWhere('ap_observed_dimension', '!=', '');
            })
            ->groupBy('set_no')
            ->orderBy('set_no', 'ASC')
            ->pluck('set_no')
            ->values();

        $totalSets = $uniqueSetNos->count();
        $perPage = 13; // 13 records per page
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $offset = min($offset, max(0, $totalSets - $perPage));

        // Calculate the range for the current page
        $start = $offset;
        $end = min($offset + $perPage, $totalSets);
        $paginatedSetNos = $uniqueSetNos->slice($start, $end - $start)->values();

        // Remap set_no for display (start from 1)
        $displaySetNos = $uniqueSetNos->mapWithKeys(function ($setNo, $index) {
            return [$setNo => $index + 1];
        });

        // Fetch dimensions for the paginated set_nos
        $di_inspect_dimensions = InspectionObservedDimension::where('manufacture_id', $manufacture->id)
            ->whereIn('set_no', $paginatedSetNos)
            ->where('di_observed_dimension', '!=', '')
            ->orderBy('set_no', 'ASC')
            ->get();

        $ap_inspect_dimensions = InspectionObservedDimension::where('manufacture_id', $manufacture->id)
            ->whereIn('set_no', $paginatedSetNos)
            ->where('ap_observed_dimension', '!=', '')
            ->orderBy('set_no', 'ASC')
            ->get();
        // dd($di_inspect_dimensions);
        if (isset($di_inspect_dimensions[0])) {
            $inspection_approval = InspectionApprove::where('del_status', 'Live')->where('mat_id', $material->id)->where('manufacture_id', $manufacture->id)->first();
        } else {
            $inspection_approval = '';
        }
        $manage_users = User::with('role')
            ->whereHas('role', function ($query) {
                $query->whereIn('title', ['Management', 'Quality Control']);
            })
            ->where('del_status', 'Live')
            ->orderBy('emp_code', 'ASC')
            ->get();
        $latest_form = InspectionReportFile::where('del_status', 'Live')->where('manufacture_id', $manufacture->id)->orderBy('id', 'DESC')->pluck('image')->first();
        $title = __('index.inspect_list');
        return view('pages.inspection.inspectionGenerateDetail', compact('title', 'manufacture', 'finishProduct', 'material', 'inspection', 'di_inspect_dimensions', 'ap_inspect_dimensions', 'inspection_approval', 'manage_users', 'latest_form', 'material_stock', 'totalSets', 'displaySetNos', 'perPage', 'currentPage'));
    }
    public function printInspectionDetail($id)
    {
        $manufacture = \App\Manufacture::with('rawMaterials')->where('id', $id)->whereIn('manufacture_status', ['draft', 'inProgress', 'done'])->where('del_status', 'Live')->first();
        $finishProduct = FinishedProduct::where('id', $manufacture->product_id)->where('del_status', 'Live')->first();
        $material = RawMaterial::where('id', $manufacture->rawMaterials[0]->rmaterials_id)->where('del_status', 'Live')->first();
        $mrmaterial = Mrmitem::where('rmaterials_id', $material->id)->where('manufacture_id', $manufacture->id)->where('del_status', 'Live')->first();
        $material_stock = MaterialStock::where('id', $mrmaterial->stock_id)->where('del_status', 'Live')->first();
        $inspection = Inspection::with('details')->where('mat_id', $manufacture->rawMaterials[0]->rmaterials_id)->where('del_status', 'Live')->get();
        $di_inspect_dimensions = InspectionObservedDimension::where('manufacture_id', $manufacture->id)->where('di_observed_dimension', '!=', '')->orderBy('id', 'ASC')->get();
        $ap_inspect_dimensions = InspectionObservedDimension::where('manufacture_id', $manufacture->id)->where('ap_observed_dimension', '!=', '')->get();
        if (isset($di_inspect_dimensions[0])) {
            $inspection_approval = InspectionApprove::where('del_status', 'Live')->where('mat_id', $manufacture->rawMaterials[0]->rmaterials_id)->where('inspect_id', $di_inspect_dimensions[0]->inspect_id)->first();
        } else {
            $inspection_approval = '';
        }
        $manage_users = User::with('role')
            ->whereHas('role', function ($query) {
                $query->whereIn('title', ['Management', 'Quality Control']);
            })
            ->where('del_status', 'Live')
            ->orderBy('emp_code', 'ASC')
            ->get();
        $title = 'Inspection Report';
        return view('pages.inspection.printInspectionReport', compact('title', 'manufacture', 'finishProduct', 'material', 'inspection', 'di_inspect_dimensions', 'ap_inspect_dimensions', 'inspection_approval', 'manage_users', 'material_stock'));
    }
    public function downloadInspectReport($id)
    {
        $manufacture = \App\Manufacture::with('rawMaterials')->where('id', encrypt_decrypt($id, 'decrypt'))->whereIn('manufacture_status', ['draft', 'inProgress', 'done'])->where('del_status', 'Live')->first();
        $finishProduct = FinishedProduct::where('id', $manufacture->product_id)->where('del_status', 'Live')->first();
        $material = RawMaterial::where('id', $manufacture->rawMaterials[0]->rmaterials_id)->where('del_status', 'Live')->first();
        $mrmaterial = Mrmitem::where('rmaterials_id', $material->id)->where('manufacture_id', $manufacture->id)->where('del_status', 'Live')->first();
        $material_stock = MaterialStock::where('id', $mrmaterial->stock_id)->where('del_status', 'Live')->first();
        $inspection = Inspection::with('details')->where('mat_id', $manufacture->rawMaterials[0]->rmaterials_id)->where('del_status', 'Live')->get();
        $di_inspect_dimensions = InspectionObservedDimension::where('manufacture_id', $manufacture->id)->where('di_observed_dimension', '!=', '')->orderBy('id', 'ASC')->get();
        $ap_inspect_dimensions = InspectionObservedDimension::where('manufacture_id', $manufacture->id)->where('ap_observed_dimension', '!=', '')->get();
        if (isset($di_inspect_dimensions[0])) {
            $inspection_approval = InspectionApprove::where('del_status', 'Live')->where('mat_id', $manufacture->rawMaterials[0]->rmaterials_id)->where('inspect_id', $di_inspect_dimensions[0]->inspect_id)->first();
        } else {
            $inspection_approval = '';
        }
        $manage_users = User::with('role')
            ->whereHas('role', function ($query) {
                $query->whereIn('title', ['Management', 'Quality Control']);
            })
            ->where('del_status', 'Live')
            ->orderBy('emp_code', 'ASC')
            ->get();
        $title = 'Inspection Report';
        $pdf = Pdf::loadView('pages.inspection.downloadInspectionReport', compact('title', 'manufacture', 'finishProduct', 'material', 'inspection', 'di_inspect_dimensions', 'ap_inspect_dimensions', 'inspection_approval', 'manage_users', 'material_stock'))->setPaper('a4', 'landscape');
        return $pdf->stream($manufacture->reference_no . '.pdf');
        // $pdf->setOption('defaultFont', 'Helvetica');
        // $pdf->setOption('isHtml5ParserEnabled', true);
        // $pdf->setOption('isPhpEnabled', true);
        // return $pdf->download($manufacture->reference_no . '.pdf');
    }
    public function getInspectionParams(Request $request)
    {
        $manufacture = \App\Manufacture::with('rawMaterials')->where('id', $request->id)->whereIn('manufacture_status', ['draft', 'inProgress', 'done'])->where('del_status', 'Live')->first();
        $material = RawMaterial::where('id', $manufacture->rawMaterials[0]->rmaterials_id)->where('del_status', 'Live')->first();
        $inspection = Inspection::where('mat_id', $material->id)->where('del_status', 'Live')->first();
        if ($inspection) {
            $inspectionParams = InspectionParam::with('inspectionDimensions')->where('inspect_id', $inspection->id)->where('del_status', 'Live')->get();
        } else {
            $inspectionParams = [];
        }
        return response()->json($inspectionParams);
    }
    public function updateInspectionDimension(Request $request)
    {
        // dd($request->all());
        $manufacture_id = $request->get('manufacture_id');
        $manufacture = \App\Manufacture::with('rawMaterials')->where('id', $manufacture_id)->whereIn('manufacture_status', ['draft', 'inProgress', 'done'])->where('del_status', 'Live')->first();
        $di_inspect_ids = $request->get('inspect_id');
        $di_param_ids = $request->get('ins_param_id');
        $di_observeds = $request->get('di_observed');
        $ap_inspect_ids = $request->get('ap_inspect_id');
        $ap_param_ids = $request->get('ap_param_id');
        $ap_observeds = $request->get('ap_observed');
        $merged = [];
        foreach ($di_param_ids as $i => $param_id) {
            $merged[$param_id] = [
                'inspect_id'        => $di_inspect_ids[$i],
                'inspect_param_id'  => $param_id,
                'di_observed'       => $di_observeds[$i] ?? '',
                'ap_observed'       => '',
            ];
        }
        foreach ($ap_param_ids as $i => $param_id) {
            if (isset($merged[$param_id])) {
                $merged[$param_id]['ap_observed'] = $ap_observeds[$i] ?? '';
            } else {
                $merged[$param_id] = [
                    'inspect_id'        => $ap_inspect_ids[$i],
                    'inspect_param_id'  => $param_id,
                    'di_observed'       => '',
                    'ap_observed'       => $ap_observeds[$i] ?? '',
                ];
            }
        }
        $max_set_no = InspectionObservedDimension::max('set_no');
        if ($max_set_no === null) {
            $max_set_no = 1;
        } else {
            $max_set_no++;
        }
        // dd($max_set_no);
        // if($max_set_no > 12) {
        //     return redirect('inspection-generate')->withErrors(['error' => 'Dimension Limit Exceeded.']);
        // } else {
        foreach ($merged as $row) {
            $inspect_dimension = new InspectionObservedDimension();
            $inspect_dimension->set_no = $max_set_no;
            $inspect_dimension->manufacture_id = $manufacture_id;
            $inspect_dimension->mat_id = $manufacture->rawMaterials[0]->rmaterials_id;
            $inspect_dimension->inspect_id = $row['inspect_id'];
            $inspect_dimension->inspect_param_id = $row['inspect_param_id'];
            $inspect_dimension->di_observed_dimension = $row['di_observed'];
            $inspect_dimension->ap_observed_dimension = $row['ap_observed'];
            $inspect_dimension->save();
        }
        return redirect('inspection-generate')->with(saveMessage());
        // }
    }
    public function updateInspectionApproval(Request $request)
    {
        // dd($request->all());
        $manufacture = \App\Manufacture::with('rawMaterials')->where('id', $request->manufacture_id)->whereIn('manufacture_status', ['draft', 'inProgress', 'done'])->where('del_status', 'Live')->first();
        $inspection = Inspection::where('mat_id', $manufacture->rawMaterials[0]->rmaterials_id)->where('del_status', 'Live')->first();
        $inspection_approval = new InspectionApprove();
        $inspection_approval->inspect_id = $inspection->id;
        $inspection_approval->manufacture_id = $request->manufacture_id;
        $inspection_approval->mat_id = $manufacture->rawMaterials[0]->rmaterials_id;
        $inspection_approval->inspected_by = $request->inspected_by;
        $inspection_approval->checked_by = $request->checked_by;
        $inspection_approval->remarks = $request->remarks;
        $inspection_approval->status = '2';
        $inspection_approval->save();
        return response()->json(['status' => 'success', 'message' => 'Updated Successfully']);
    }
    public function inspectionReportFileSubmit(Request $request)
    {
        // dd($request->all());
        $obj = new InspectionReportFile();
        $proofName = '';
        if ($request->hasFile('image')) {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = $image->getClientOriginalName();
                $proofName = time() . "_" . $filename;
                $image->move(base_path() . '/uploads/inspection_report_files/', $proofName);
            }
            $obj->image = $proofName;
        }
        $obj->manufacture_id = $request->manufacture_id;
        $obj->inspection_id = $request->ins_id;
        $obj->save();
        return response()->json(['status' => 'success', 'message' => 'File uploaded']);
    }
}
