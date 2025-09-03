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
# This is FinishedProductController
##############################################################################
*/

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerOrderDetails;
use App\Drawer;
use App\FinishedProduct;
use App\FPCategory;
use App\FPnonitem;
use App\FPproductionstage;
use App\ProductionStage;
use App\FPrmitem;
use App\NonIItem;
use App\RawMaterial;
use App\RawMaterialCategory;
use App\Tax;
use App\TaxItems;
use App\Unit;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FinishedProductController extends Controller
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
        $obj = FinishedProduct::leftJoin('tbl_rmunits', 'tbl_rmunits.id', '=', 'tbl_finish_products.unit')
            ->leftJoin('tbl_customers', 'tbl_customers.customer_id', '=', 'tbl_finish_products.customer_code')
            ->orderBy('tbl_finish_products.id', 'DESC')
            ->select('tbl_finish_products.*','tbl_rmunits.name as unit_name','tbl_customers.name as cust_name')
            ->where('tbl_finish_products.del_status', 'Live')
            ->get()->map(function ($fp) {
                $usedInOrder = CustomerOrderDetails::where('product_id', $fp->id)->where('del_status','Live')->exists();
                $fp->used_in_order = $usedInOrder;
                return $fp;
            });
        $title =  __('index.products');
        return view('pages.finished_product.finishedproducts',compact('title','obj'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $title =  __('index.add_product');
        // $rmaterials = RawMaterial::orderBy('name','ASC')->where('del_status',"Live")->get();
        $drawers = Drawer::where('del_status', 'Live')->get();
        $rmaterialcats = RawMaterialCategory::orderBy('name','ASC')->where('del_status',"Live")->where('id','!=',1)->get();
        $productionstage = ProductionStage::orderBy('id','ASC')->where('del_status',"Live")->get();
        $categories = FPCategory::orderBy('name','ASC')->where('del_status',"Live")->get();
        return view('pages.finished_product.addEditFinishedProduct',compact('title','rmaterialcats','productionstage','categories','drawers'));
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
            'name' => [
                'required',
                // 'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\/&\-\s]+$/',
                'max:150',
                // Rule::unique('tbl_finish_products', 'name')->where(function ($query) {
                //     return $query->where('del_status', 'Live');
                // }),
            ],
            'code' => [
                'required',
                // 'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\/&\-\s]+$/',
                'max:50',
                Rule::unique('tbl_finish_products', 'code')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            // 'hsn_sac_no' => [
            //     'max:20',
            //     Rule::unique('tbl_finish_products', 'hsn_sac_no')->where(function ($query) {
            //         return $query->where('del_status', 'Live');
            //     }),
            // ],
            // 'part_name' => 'nullable|max:50',
            // 'part_no' => 'nullable|max:20',
            'category' => 'required',
            'rev' => 'nullable',
            'operation' => 'nullable',
            'drawer_no' => 'required',
            'danish_sin_no' => 'nullable',
            'description' => 'required|max:250',
            'remarks' => 'nullable|max:100',
        ]);

        $obj = new \App\FinishedProduct;
        $obj->name = ucwords(escape_output($request->get('name')));
        $obj->code = escape_output($request->get('code'));
        $obj->category = escape_output($request->get('category'));
        $obj->hsn_sac_no = escape_output($request->get('hsn_sac_no'));
        // $obj->part_name = ucwords(escape_output($request->get('part_name')));
        // $obj->part_no = escape_output($request->get('part_no'));
        $obj->rev = escape_output($request->get('rev'));
        $obj->operation = escape_output($request->get('operation'));
        $obj->drawer_no = escape_output($request->get('drawer_no'));
        $obj->scope = escape_output($request->get('scope'));
        $obj->danish_sin_no = escape_output($request->get('danish_sin_no'));
        $obj->description = html_entity_decode($request->get('description'));
        $obj->remarks = html_entity_decode($request->get('remarks'));
        $obj->company_id = auth()->user()->company_id;
        $obj->added_by = auth()->user()->id;
        $obj->save();
        $last_id = $obj->id;

        $rm_id = $request->get('rm_id');
        foreach ($rm_id as $row=>$value){
            $obj = new \App\FPrmitem;
            $obj->mat_cat_id = null_check($request->get('mat_cat_id'));
            $obj->rmaterials_id = null_check($value);
            $obj->finish_product_id = null_check($last_id);
            $obj->company_id = auth()->user()->company_id;
            $obj->save();
        }
        $producstage_id = $request->get('producstage_id');
        if(isset($producstage_id) && $producstage_id) {
            foreach ($producstage_id as $row => $value) {
                $obj = new \App\FPproductionstage();
                $obj->productionstage_id = null_check($value);
                $obj->stage_month = 0;
                $obj->stage_day = 0;
                $obj->stage_hours = null_check(escape_output($_POST['stage_hours'][$row]));
                $obj->stage_minute = null_check(escape_output($_POST['stage_minute'][$row]));
                $obj->finish_product_id = null_check($last_id);
                $obj->company_id = auth()->user()->company_id;
                $obj->save();
            }
        }
        return redirect('finishedproducts')->with(saveMessage());
    }
    /**
    * Display the specified resource.
    *
    * @param  \App\FinishedProduct  $finishedproduct
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $finishedproduct = FinishedProduct::find(encrypt_decrypt($id, 'decrypt'));
        $title =  __('index.view_details');
        $categories = FPCategory::orderBy('name','ASC')->where('del_status',"Live")->get();
        $units = Unit::orderBy('name','ASC')->where('del_status',"Live")->get();
        $rmaterials = RawMaterial::orderBy('name','ASC')->where('del_status',"Live")->get();
        $tax_fields = Tax::orderBy('id','ASC')->where('del_status',"Live")->get();
        $nonitem = NonIItem::orderBy('name','ASC')->where('del_status',"Live")->get();
          $productionstage = ProductionStage::orderBy('id','ASC')->where('del_status',"Live")->get();
        $fp_rmaterials = FPrmitem::orderBy('id','ASC')->where('finish_product_id',$finishedproduct->id)->where('del_status',"Live")->get();
        $fp_nonitems = FPnonitem::orderBy('id','ASC')->where('finish_product_id',$finishedproduct->id)->where('del_status',"Live")->get();
        $fp_productionstages = FPproductionstage::orderBy('id','ASC')->where('finish_product_id',$finishedproduct->id)->where('del_status',"Live")->get();
        $obj = $finishedproduct;
        return view('pages.finished_product.duplicateProduct',compact('title','obj','rmaterials','categories','nonitem','productionstage','tax_fields','fp_rmaterials','fp_nonitems','fp_productionstages','units'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\FinishedProduct  $finishedproduct
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $finishedproduct = FinishedProduct::find(encrypt_decrypt($id, 'decrypt'));
        $title =  __('index.edit_product');
        $drawers = Drawer::where('del_status', 'Live')->get();
        $rmaterialcats = RawMaterialCategory::orderBy('name','ASC')->where('del_status',"Live")->where('id','!=',1)->get();
        $categories = FPCategory::orderBy('name','ASC')->where('del_status',"Live")->get();
        $productionstage = ProductionStage::orderBy('id','ASC')->where('del_status',"Live")->get();
        $fp_rmaterials = FPrmitem::orderBy('id','ASC')->where('finish_product_id',$finishedproduct->id)->where('del_status',"Live")->get();
        $rmaterials = RawMaterial::orderBy('name','ASC')->where('del_status',"Live")->where('category',$fp_rmaterials[0]['mat_cat_id'])->get();
        $fp_productionstages = FPproductionstage::orderBy('id','ASC')->where('finish_product_id',$finishedproduct->id)->where('del_status',"Live")->get();
        $obj = $finishedproduct;
        return view('pages.finished_product.addEditFinishedProduct',compact('title','obj','rmaterials','rmaterialcats','productionstage','fp_rmaterials','fp_productionstages','categories','drawers'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\FinishedProduct  $finishedproduct
    * @return \Illuminate\Http\Response
    */
    public function duplicate($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $title =  __('index.duplicate_product');
        $categories = FPCategory::orderBy('name','ASC')->where('del_status',"Live")->get();
        $units = Unit::orderBy('name','ASC')->where('del_status',"Live")->get();
        $rmaterials = RawMaterial::orderBy('name','ASC')->where('del_status',"Live")->get();
        $tax_fields = Tax::orderBy('id','ASC')->where('del_status',"Live")->get();
        $tax_items = TaxItems::first();
        $nonitem = NonIItem::orderBy('name','ASC')->where('del_status',"Live")->get();
          $productionstage = ProductionStage::orderBy('id','ASC')->where('del_status',"Live")->get();
        $fp_rmaterials = FPrmitem::orderBy('id','ASC')->where('finish_product_id',$id)->where('del_status',"Live")->get();
        $fp_nonitems = FPnonitem::orderBy('id','ASC')->where('finish_product_id',$id)->where('del_status',"Live")->get();
        $fp_productionstages = FPproductionstage::orderBy('id','ASC')->where('finish_product_id',$id)->where('del_status',"Live")->get();
        $obj = FinishedProduct::find($id);
        $obj_rm = FinishedProduct::count();
        $ref_no = "FP-".str_pad($obj_rm + 1, 6, '0', STR_PAD_LEFT);
        return view('pages.finished_product.duplicateProduct',compact('title','obj','rmaterials','categories','nonitem','productionstage','tax_fields','fp_rmaterials','fp_nonitems','fp_productionstages','units','tax_items','ref_no'));
    }

    public function duplicate_store(Request $request)
    {
        request()->validate([
            'name' => 'required|max:150',
            'code' => 'required|max:50',
            'category' => 'required|max:50',
            'unit' => 'required|max:50',
            'stock_method' => 'required|max:50'
        ]);

        $obj = new \App\FinishedProduct;
        $obj->code = escape_output($request->get('code'));
        $obj->name = escape_output($request->get('name'));
        $obj->category = null_check(escape_output($request->get('category')));
        $obj->stock_method = escape_output($request->get('stock_method'));
        $obj->unit = null_check(escape_output($request->get('unit')));
        $obj->rmcost_total = null_check(escape_output($request->get('rmcost_total')));
        $obj->noninitem_total = null_check(escape_output($request->get('noninitem_total')));
        $obj->total_cost = null_check(escape_output($request->get('total_cost')));
        $obj->profit_margin = null_check(escape_output($request->get('profit_margin')));
        $obj->sale_price = null_check(escape_output($request->get('sale_price')));
        $obj->company_id = auth()->user()->company_id;

        //generate json data for tax value
        $tax_information = array();
        if(!empty($_POST['tax_field_percentage'])){
            foreach($_POST['tax_field_percentage'] as $key=>$value){
                $single_info = array(
                    'tax_field_id' => escape_output($_POST['tax_field_id'][$key]),
                    'tax_field_name' => escape_output($_POST['tax_field_name'][$key]),
                    'tax_field_percentage' => ($_POST['tax_field_percentage'][$key] == "") ? 0 : escape_output($_POST['tax_field_percentage'][$key])
                );
                array_push($tax_information,$single_info);
            }
        }
        $tax_information = json_encode($tax_information);
        //end
        $obj->tax_information = $tax_information;
        $obj->added_by = auth()->user()->id;
        $obj->save();
        $last_id = $obj->id;

        $rm_id = $request->get('rm_id');
        foreach ($rm_id as $row=>$value){
            $obj = new \App\FPrmitem;
            $obj->rmaterials_id = null_check($value);
            $obj->unit_price = null_check(escape_output($_POST['unit_price'][$row]));
            $obj->consumption = null_check(escape_output($_POST['quantity_amount'][$row]));
            $obj->total_cost = null_check(escape_output($_POST['total'][$row]));
            $obj->finish_product_id = null_check($last_id);
            $obj->company_id = auth()->user()->company_id;
            $obj->save();
        }

        $noniitem_id = $request->get('noniitem_id');
        if(isset($noniitem_id) && $noniitem_id){
            foreach ($noniitem_id as $row=>$value){
                $obj = new \App\FPnonitem;
                $obj->noninvemtory_id = null_check($value);
                $obj->nin_cost = null_check(escape_output($_POST['total_1'][$row]));
                $obj->finish_product_id = null_check($last_id);
                $obj->company_id = auth()->user()->company_id;
                $obj->save();
            }
        }
        $producstage_id = $request->get('producstage_id');
        if(isset($producstage_id) && $producstage_id) {
            foreach ($producstage_id as $row => $value) {
                $obj = new \App\FPproductionstage();
                $obj->productionstage_id = null_check($value);
                $obj->stage_month = null_check(escape_output($_POST['stage_month'][$row]));
                $obj->stage_day = null_check(escape_output($_POST['stage_day'][$row]));
                $obj->stage_hours = null_check(escape_output($_POST['stage_hours'][$row]));
                $obj->stage_minute = null_check(escape_output($_POST['stage_minute'][$row]));
                $obj->finish_product_id = null_check($last_id);
                $obj->company_id = auth()->user()->company_id;
                $obj->save();
            }
        }
        return redirect('finishedproducts')->with(saveMessage());
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\FinishedProduct  $finishedproduct
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, FinishedProduct $finishedproduct)
    {
        request()->validate([
            'name' => [
                'required',
                // 'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\/&\-\s]+$/',
                'max:150',
                // Rule::unique('tbl_finish_products', 'name')->ignore($finishedproduct->id,'id')->where(function ($query) {
                //     return $query->where('del_status', 'Live');
                // }),
            ],
            'code' => [
                'required',
                // 'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\/&\-\s]+$/',
                'max:50',
                // Rule::unique('tbl_finish_products', 'code')->ignore($finishedproduct->id,'id')->where(function ($query) {
                //     return $query->where('del_status', 'Live');
                // }),
            ],
            // 'hsn_sac_no' => [
            //     'max:20',
            //     Rule::unique('tbl_finish_products', 'hsn_sac_no')->ignore($finishedproduct->id,'id')->where(function ($query) {
            //         return $query->where('del_status', 'Live');
            //     }),
            // ],
            // 'part_name' => 'nullable|max:50',
            // 'part_no' => 'nullable|max:20',
            'category' => 'required',
            'drawer_no' => 'required',
            'rev' => 'nullable',
            'operation' => 'nullable',
            'danish_sin_no' => 'nullable',
            'description' => 'required|max:250',
            'remarks' => 'nullable|max:100',
        ]);

        $finishedproduct->code = escape_output($request->get('code'));
        $finishedproduct->name = ucwords(escape_output($request->get('name')));
        $finishedproduct->customer_code = escape_output($request->get('customer_code'));
        $finishedproduct->hsn_sac_no = escape_output($request->get('hsn_sac_no'));
        // $finishedproduct->part_name = ucwords(escape_output($request->get('part_name')));
        // $finishedproduct->part_no = escape_output($request->get('part_no'));
        $finishedproduct->rev = escape_output($request->get('rev'));
        $finishedproduct->operation = escape_output($request->get('operation'));
        $finishedproduct->drawer_no = escape_output($request->get('drawer_no'));
        $finishedproduct->scope = escape_output($request->get('scope'));
        $finishedproduct->category = escape_output($request->get('category'));
        $finishedproduct->danish_sin_no = escape_output($request->get('danish_sin_no'));
        $finishedproduct->description = html_entity_decode($request->get('description'));
        $finishedproduct->remarks = html_entity_decode($request->get('remarks'));
        $finishedproduct->company_id = auth()->user()->company_id;
        $logoNameToStore = '';
        if ($request->hasFile('photo')) {
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $filename = $image->getClientOriginalName();
                $logoNameToStore = time() . "_" . $filename;
                $image_resize = Image::make($image->getRealPath());
                $image_resize->save(base_path() . '/uploads/finish_product/' . $logoNameToStore);
            }
        }
        $finishedproduct->added_by = auth()->user()->id;
        $finishedproduct->photo = ($logoNameToStore == '' ? $request->photo_old : $logoNameToStore);
        $finishedproduct->save();
        $last_id = $finishedproduct->id;

        //delete previous data before add
        FPrmitem::where('finish_product_id', $finishedproduct->id)->update(['del_status' => "Deleted"]);
        FPnonitem::where('finish_product_id', $finishedproduct->id)->update(['del_status' => "Deleted"]);
        FPproductionstage::where('finish_product_id', $finishedproduct->id)->update(['del_status' => "Deleted"]);

        $rm_id = $request->get('rm_id');
        if($rm_id){
            foreach ($rm_id as $row=>$value){
                $obj = new \App\FPrmitem;
                $obj->rmaterials_id = null_check($value);
                $obj->mat_cat_id = null_check($request->get('mat_cat_id'));
                $obj->finish_product_id = null_check($last_id);
                $obj->company_id = auth()->user()->company_id;
                $obj->save();
            }
        }
        $producstage_id = $request->get('producstage_id');
        if(isset($producstage_id) && $producstage_id) {
            foreach ($producstage_id as $row => $value) {
                $obj = new \App\FPproductionstage();
                $obj->productionstage_id = null_check($value);
                $obj->stage_month = 0;
                $obj->stage_day = 0;
                $obj->stage_hours = null_check(escape_output($_POST['stage_hours'][$row]));
                $obj->stage_minute = null_check(escape_output($_POST['stage_minute'][$row]));
                $obj->finish_product_id = null_check($last_id);
                $obj->company_id = auth()->user()->company_id;
                $obj->save();
            }
        }
        return redirect('finishedproducts')->with(updateMessage());
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\FinishedProduct  $finishedproduct
    * @return \Illuminate\Http\Response
    */
    public function destroy(FinishedProduct $finishedproduct)
    {
        //delete previous data before add
        FPrmitem::where('finish_product_id', $finishedproduct->id)->update(['del_status' => "Deleted"]);
        FPnonitem::where('finish_product_id', $finishedproduct->id)->update(['del_status' => "Deleted"]);

        $finishedproduct->del_status = "Deleted";
        $finishedproduct->save();
        return redirect('finishedproducts')->with(deleteMessage());
    }

    /**
    * Price History
    */

    public function priceHistory(Request $request)
    {
        $product_id = encrypt_decrypt($request->get('product'), 'decrypt');
        $title =  __('index.price_history');
        $products = FinishedProduct::orderBy('name','ASC')->where('del_status',"Live")->get();
        if($product_id){
            $obj = FinishedProduct::whereHas('sales')->orderBy('id','DESC')->where('del_status',"Live")->where('id',$product_id)->get();
        }else{
            $obj = null;
        }
        return view('pages.finished_product.priceHistory',compact('title','obj','products'));
    }
}
