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
# This is AjaxController Controller
##############################################################################
 */

namespace App\Http\Controllers;

use App\Account;
use App\Customer;
use App\CustomerOrder;
use App\CustomerOrderDetails;
use App\CustomerOrderInvoice;
use App\FinishedProduct;
use App\FPnonitem;
use App\FPproductionstage;
use App\FPrmitem;
use App\Manufacture;
use App\MaterialStock;
use App\Mrmitem;
use App\ProductionScheduling;
use App\ProductionQCScheduling;
use App\Quotation;
use App\QuotationDetail;
use App\RawMaterial;
use App\RawMaterialCategory;
use App\RawMaterialPurchase;
use App\RMPurchase_model;
use App\Stage;
use App\Stock;
use App\Supplier;
use App\User;
use App\Tax;
use App\TaxItems;
use App\CustomerDueReceive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{

    public function addSupplierByAjax(Request $request)
    {
        $obj_supl = Supplier::count();
        $supplier_id = "SUP-" . str_pad($obj_supl + 1, 6, '0', STR_PAD_LEFT);
        $obj = new \App\Supplier;
        $obj->supplier_id = $supplier_id;
        $obj->name = escape_output($request->get('name'));
        // $obj->contact_person = escape_output($request->get('contact_person'));
        $obj->phone = escape_output($request->get('phone'));
        $obj->email = escape_output($request->get('emailAddress'));
        $obj->address = escape_output($request->get('supAddress'));
        $obj->gst_no = escape_output($request->get('gst_no'));
        // $obj->credit_limit = escape_output($request->get('credit_limit'));
        // $obj->opening_balance = escape_output($request->get('opening_balance'));
        // $obj->opening_balance_type = escape_output($request->get('opening_balance_type'));
        $obj->note = escape_output($request->get('note'));
        $obj->added_by = auth()->user()->id;
        $obj->save();
        $last_id = $obj->id;
        $html = '';

        $obj = Supplier::orderBy('id', 'DESC')->where('del_status', "Live")->get();
        foreach ($obj as $value) {
            $current_due = currentSupplierDue($value->id);
            $html .= "<option  data-credit_limit='$value->credit_limit'   data-current_due='$current_due'  value='$value->id'>" . $value->name . "(" . $value->phone . ")</option>";
        }
        $return = array();
        $return['supplier_id'] = $last_id;
        $return['html'] = $html;
        echo json_encode($return);
    }
    public function addCustomerByAjax(Request $request)
    {
        $obj_cust = Customer::count();
        $customer_id = "CUS-" . str_pad($obj_cust + 1, 6, '0', STR_PAD_LEFT);
        $vendor_code = rand(100000, 999999);
        $obj = new \App\Customer;
        $obj->customer_id = $customer_id;
        $obj->vendor_code = $vendor_code;
        $obj->name = escape_output($request->get('name'));
        $obj->name = escape_output($request->get('name'));
        $obj->phone = escape_output($request->get('phone'));
        $obj->email = escape_output($request->get('emailAddress'));
        $obj->address = escape_output($request->get('supAddress'));
        $obj->gst_no = escape_output($request->get('gst_no'));
        $obj->note = escape_output($request->get('note'));
        $obj->added_by = auth()->user()->id;
        $obj->save();
        $last_id = $obj->id;
        $html = '';

        $obj = Customer::orderBy('id', 'DESC')->where('del_status', "Live")->get();
        foreach ($obj as $value) {
            $current_due = currentSupplierDue($value->id);
            $html .= "<option  data-credit_limit='$value->credit_limit'   data-current_due='$current_due'  value='$value->id'>" . $value->name . "(" . $value->phone . ")</option>";
        }
        $return = array();
        $return['customer_id'] = $last_id;
        $return['html'] = $html;
        echo json_encode($return);
    }

    public function getRMByFinishProduct(Request $request)
    {
        $id = escape_output($request->get('id'));
        $fp_rmaterials = FPrmitem::orderBy('id', 'ASC')->where('finish_product_id', $id)->where('del_status', "Live")->get();
        $fp_nonitems = FPnonitem::orderBy('id', 'ASC')->where('finish_product_id', $id)->where('del_status', "Live")->get();
        foreach ($fp_rmaterials as $key => $value) {
            $fp_rmaterials[$key]->rm_name = getRMName($value->rmaterials_id);
            $fp_rmaterials[$key]->rm_consumption_unit = getPurchaseSaleUnitById($value->rmaterials_id);
            $fp_rmaterials[$key]->currency = getCurrencyOnly();
        }
        foreach ($fp_nonitems as $key => $value) {
            $fp_nonitems[$key]->noninrm_name = getNonInventroyItem($value->noninvemtory_id);
            $fp_nonitems[$key]->currency = getCurrencyOnly();
        }
        $return['rmaterials'] = $fp_rmaterials;
        $return['noninmaterials'] = $fp_nonitems;
        echo json_encode($return);

    }

    public function sortingPage(Request $request)
    {
        $stages = $request->get('stages');
        $i = 1;
        foreach ($stages as $key => $value) {
            $obj = Stage::find($stages[$key]);
            $obj->arranged_by = $i;
            $obj->save();
            $i++;
        }
        echo json_encode('success');
    }

    public function checkCreditLimit(Request $request)
    {
        $supplier = $request->get('supplier');
        $due = $request->get('due');
        $return['status'] = false;
        if (checkCreditLimit($supplier, $due)) {
            $return['status'] = true;
        }
        echo json_encode($return);
    }

    public function getSupplierDue()
    {
        $supplier_id = escape_output($_GET['supplier_id']);
        $getSupplierDue = getSupplierDue($supplier_id);
        $creditLimit = getSupplierCreditLimit($supplier_id);

        $return_array['supplier_total_due'] = $getSupplierDue;
        $return_array['credit_limit'] = $creditLimit;

        echo json_encode($return_array);
    }

    /* Now its working for customer based order products */
    public function getCustomerDue()
    {
        $customer_id = escape_output($_GET['customer_id']);
        $getCustomerDue = getCustomerDue($customer_id);
        $creditLimit = getCustomerCreditLimit($customer_id);

        $return_array['supplier_total_due'] = $getCustomerDue;
        $return_array['credit_limit'] = $creditLimit;

        echo json_encode($return_array);
    }

    public function getSupplierBalance()
    {
        $supplier_id = escape_output($_GET['supplier_id']);
        $getSupplierBalance = companySupplierBalance($supplier_id);
        $creditLimit = getSupplierCreditLimit($supplier_id);
        $getSupplierDue = getSupplierDue($supplier_id);

        $return_array['supplier_balance'] = $getSupplierBalance;
        $return_array['credit_limit'] = $creditLimit;
        $return_array['supplier_due'] = $getSupplierDue;

        echo json_encode($return_array);

    }

    public function getLowRMStock()
    {
        $obj1 = new Stock();
        $inventory = $obj1->getLowRMStock();
        $i = 1;
        $table_row = '';
        $setting = getSettingsInfo();
        if (!empty($inventory) && isset($inventory)) {
            foreach ($inventory as $key => $value) {
                // $totalStock = @($value->total_purchase * $value->conversion_rate) - $value->total_rm_waste + $value->opening_stock;
                $last_p_price = getLastPurchasePrice($value->id);
                $table_row .= '<tr class="rowCount" data-id="' . $value->id . '">
                                <td class="width_1_p ir_txt_center"><p class="set_sn"></p></td>
                                <td><input type="hidden" value="' . $value->id . '" name="rm_id[]"> <span>' . $value->name . '(' . $value->code . ')' . '</span></td>

                                <td><div class="input-group"><input type="text" name="unit_price[]" onfocus="this.select();" class="check_required form-control integerchk unit_price_c cal_row" placeholder="Unit Price" value="' . $last_p_price . '" id="unit_price_1"><span class="input-group-text">  ' . $setting->currency . '</span></div></td>

                                <td><div class="input-group"><input type="text" data-countid="1" tabindex="51" id="qty_1" name="quantity_amount[]" onfocus="this.select();" class="check_required form-control integerchk qty_c cal_row" value="1" placeholder="0"><span class="input-group-text">' . getRMUnitById($value->unit) . '</span></div></td>

                                <td><div class="input-group"><input type="text" id="total_1" name="total[]" class="form-control total_c" value="" placeholder="Total" readonly=""><span class="input-group-text">  ' . $setting->currency . '</span></div></td>
                                <td class="ir_txt_center"><a class="btn btn-xs del_row dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>
                            </tr>';
                $i++;
            }
        }
        //we skip escape due to html content
        echo ($table_row);
    }

    public function getFinishProductRM(Request $request)
    {
        $fproduct_id = escape_output($request->post('id'));
        $product_quantity = escape_output($request->post('value'));
        $setting = getSettingsInfo();
        $obj2 = new FPrmitem();
        $finishProductRM = $obj2->getFinishProductRM($fproduct_id);
        $html = '';
        foreach ($finishProductRM as $value) {
            $consumption = $value->consumption * $product_quantity;
            $html .= '<tr class="rowCount" data-id="' . $value->finish_product_id . '">
                        <td class="width_1_p text-start"><p class="set_sn"></p></td>
                        <td><input type="hidden" value="' . $value->rmaterials_id . '" name="rm_id[]" class="rm_id"> <span>' . getRMName($value->rmaterials_id) . '</span></td>

                        <td><div class="input-group"><input type="text" tabindex="5" name="unit_price[]" onfocus="this.select();" class="check_required form-control integerchk input_aligning unit_price_c cal_row" placeholder="Unit Price" value="' . $value->unit_price . '" id="unit_price_1"><span class="input-group-text">' . $setting->currency . '</span></div><div class="text-danger unitPriceErr d-none"></div></td>

                        <td><div class="input-group"><input type="text" data-countid="1" tabindex="51" id="qty_1" name="quantity_amount[]" onfocus="this.select();" class="check_required form-control integerchk input_aligning qty_c cal_row" value="' . $consumption . '" placeholder="Consumption"><span class="input-group-text">KG</span></div><div class="text-danger quantityErr d-none"></div></td>

                        <td><div class="input-group"><input type="text" id="total_1" name="total[]" class="form-control input_aligning total_c" value="' . $value->total_cost . '" placeholder="Total" readonly=""><span class="input-group-text">  ' . $setting->currency . '</span></div></td>
                        <td class="text-end"><a class="btn btn-xs del_row dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>
                    </tr>';
        }
        echo json_encode($html);
    }

    public function getFinishProductGST(Request $request)
    {
        $fproduct_id = escape_output($request->post('id'));
        $finished_product_tax = FinishedProduct::where('id', $fproduct_id)
            ->where('del_status', 'Live')
            ->first();
        $html = '';
        if ($finished_product_tax) {
            $tax_information = json_decode(isset($finished_product_tax->tax_information) && $finished_product_tax->tax_information ? $finished_product_tax->tax_information : '');
            $html .= '<div class="col-md-3">
                <div class="form-group">
                    <label>Tax Type</label>
                    <input type="text" 
                           class="form-control" 
                           value="' . $finished_product_tax->tax_type . '" 
                           readonly>
                    <input type="hidden" 
                           name="tax_type"
                           id="ftax_type"
                           value="' . $finished_product_tax->tax_type . '">
                    <div class="text-danger d-none"></div>
                </div>
              </div>';
            foreach ($tax_information as $single_tax) {
                if($finished_product_tax->inter_state=='N') {
                    $tax_field = Tax::where('id', $single_tax->tax_field_id)->whereIN('tax',['CGST','SGST'])->where('del_status', 'Live')->first();
                } else {
                    $tax_field = Tax::where('id', $single_tax->tax_field_id)->where('tax','IGST')->where('del_status', 'Live')->first();
                }
                if ($tax_field) {
                    $html .= '<div class="col-md-4">
                        <label>' . $tax_field->tax . '</label>
                        <input type="hidden" name="tax_field_id[]" value="' . $single_tax->tax_field_id . '">
                        <input type="hidden" name="tax_field_name[]" value="' . $single_tax->tax_field_name . '">
                        <div class="input-group">
                            <input type="text" name="tax_field_percentage[]" class="form-control get_percentage integerchk cal_row" value="' . $single_tax->tax_field_percentage . '" readonly>
                            <span class="input-group-text">%</span>
                        </div>
                    </div>';
                }
            }
        }
        echo json_encode($html);
    }

    public function getFinishProductRMForManufacture(Request $request)
    {
        $fproduct_id = escape_output($request->post('id'));
        $stk_mat_type = escape_output($request->post('stk_mat_type'));
        $selected_customer_id = escape_output($request->post('selected_customer_id'));
        $customer_order_id = escape_output($request->post('customer_order_id'));
        $product_quantity = escape_output($request->post('value'));
        $setting = getSettingsInfo();
        $material_qty = CustomerOrderDetails::where('customer_order_id',$customer_order_id)->where('product_id',$fproduct_id)->where('del_status','Live')->first()->raw_qty;
        $obj2 = new FPrmitem();
        $finishProductRM = $obj2->getOrderProductRM($fproduct_id,$stk_mat_type,$selected_customer_id,$customer_order_id);
        $html = '';
        if (!empty($finishProductRM) && count($finishProductRM) > 0) {
            foreach ($finishProductRM as $value) {
                $consumption = $value->current_stock;
                if(isset($value->customer_name)) {
                    $customer_name = $value->customer_name.'('.$value->customer_code.')';
                } else {
                    $customer_name = "Danish";
                }
                // dd($customer_name);
                $html .= '<tr class="rowCount" data-id="' . $value->id . '">
                            <td class="width_1_p text-start"><p class="set_sn"></p></td>
                            <td><input type="hidden" value="' . $value->id . '" name="stock_id[]" class="stock_id"><input type="hidden" value="' . $value->mat_id . '" name="rm_id[]" class="rm_id"> <span>' . getRMName($value->mat_id) . '<br><small>'.$customer_name.'</small></span></td>
                            <td><input type="hidden" value="' . $consumption . '" name="stock[]" class="stock"><p id="show_stock">'.$consumption.' <span>'.getStockUnitById($value->id).'</span></p></td>
                            <td><div class="input-group"><input type="text" data-countid="1" tabindex="51" id="qty_1" name="quantity_amount[]" onfocus="this.select();" class="check_required form-control integerchk input_aligning qty_c cal_row" value="' . $material_qty . '" placeholder="Consumption" onkeypress="return event.charCode >= 48 && event.charCode <= 57" ><span class="input-group-text">'.getStockUnitById($value->id).'</span></div><div class="text-danger quantityErr d-none"></div></td>
                            <td class="text-end"><a class="btn btn-xs del_row dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>
                        </tr>';
            }
            return response()->json(['result'=>'true','html' => $html]);
        } else {
            if($stk_mat_type=="1"){
                $html .= '<tr><td colspan="4" class="text-danger text-center">No Stock Material Available for this customer</td></tr>';
            } else {
                $html .= '<tr><td colspan="4" class="text-danger text-center">No Stock Material Available</td></tr>';
            }
            return response()->json(['result'=>'false','html' => $html]);
        }
    }

    public function getFinishProductNONI(Request $request)
    {
        $fproduct_id = escape_output($request->post('id'));
        $product_quantity = escape_output($request->post('value'));
        $setting = getSettingsInfo();
        $obj2 = new FPnonitem();
        $finishProductNoni = $obj2->getFinishProductNONI($fproduct_id);
        $accounts = Account::orderBy('name', 'ASC')->where('del_status', "Live")->get();
        $account_dropdown = '<option value="">Select</option>';
        $htmlnoni = '';

        foreach ($finishProductNoni as $value) {
            $nin_cost = $value->nin_cost * $product_quantity;
            $htmlnoni .= '<tr class="rowCount1 noninventory" data-id="' . $value->finish_product_id . '">
                        <td class="width_1_p text-start"><p class="set_sn1"></p></td>
                        <td><input type="hidden" value="' . $value->noninvemtory_id . '" name="noniitem_id[]"> <span>' . getNonInventroyItem($value->noninvemtory_id) . '</span></td><td></td>

                        <td><div class="input-group"><input type="text" id="total_1" name="total_1[]" class="cal_row noi_cost form-control aligning total_c1" onfocus="select();" value="' . $nin_cost . '" placeholder="Non Inventory Cost"><span class="input-group-text">' . $setting->currency . '</span></div><div class="text-danger nonInventoryCostErr d-none"></div></td>

                        <td width="20%"><select class="form-control account_id_c1" name="account_id[]">';
            $htmlnoni .= $account_dropdown;
            foreach ($accounts as $account) {
                $htmlnoni .= '<option id="account_id" class="account_id" value="' . $account->id . '">' . $account->name . '</option>';
            }
            $htmlnoni .= '</select><div class="text-danger accountErr d-none"></div></td>
                        <td class="text-end"><a class="btn btn-xs del_row dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td></tr>';
        }
        echo json_encode($htmlnoni);
    }

    public function getFinishProductStages(Request $request)
    {
        $fproduct_id = escape_output($request->post('id'));
        $product_quantity = escape_output($request->post('value'));
        $setting = getSettingsInfo();
        $obj2 = new FPproductionstage();
        $finishProductStage = $obj2->getFinishProductStages($fproduct_id);
        
        $htmlstages = '';
        $total_month = 0;
        $total_day = 0;
        $total_hour = 0;
        $total_mimute = 0;
        
        $total_months = 0;
        $total_days = 0;
        $total_hours = 0;
        $total_minutes = 0;

        $i = 1;
        foreach ($finishProductStage as $key => $value) {
            $total_value = (($value->stage_month * 2592000) + ($value->stage_day * 86400) + ($value->stage_hours * 3600) + ($value->stage_minute * 60)) * $product_quantity;
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

            $htmlstages .= '<tr class="rowCount2 align-baseline" data-id="' . $value->finish_product_id . '">
                            <td class="width_1_p"><p class="set_sn2"></p></td>
                            <td class="width_1_p">
                                <input type="hidden" value="' . $value->productionstage_id . '" name="producstage_id[]">
                                <input class="form-check-input set_class custom_checkbox" data-stage_name="' . getProductionStage($value->productionstage_id) . '" type="radio" id="checkboxNoLabel" name="stage_check" value="' . $i . '">
                            </td>
                            <td class="stage_name" style="text-align: left;"> <span>' . getProductionStage($value->productionstage_id) . '</span></td>
                            <td>
                                <div class="row">
                                    <div class="col-xl-6 col-md-6">
                                        <div class="input-group"><input class="form-control stage_aligning" type="text" id="hours_limit" name="stage_hours[]" min="1" max="24" value="' . $hours . '" placeholder="Hours"><span class="input-group-text">Hours</span></div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 getLowRMStock">
                                        <div class="input-group"><input class="form-control stage_aligning" type="text" id="minute_limit" name="stage_minute[]" min="1" max="60" value="' . $minuts . '" placeholder="Minutes"><span class="input-group-text">Minutes</span></div>
                                    </div>
                                </div>
                            </td>
                        </tr>';
            $i++;
        }

        $data_arr['html'] = $htmlstages;
        $data_arr['total_month'] = $total_months;
        $data_arr['total_day'] = $total_days;
        $data_arr['total_hour'] = $total_hours;
        $data_arr['total_minute'] = $total_minutes;
        echo json_encode($data_arr);
    }

    public function getFifoFProduct(Request $request)
    {
        $product_id = escape_output($request->post('id'));
        $unit_price = escape_output($request->post('unit_price'));
        $quantity = escape_output($request->post('quantity'));
        $item_id_modal = escape_output($request->post('item_id_modal'));
        $item_currency_modal = escape_output($request->post('item_currency_modal'));
        $item_unit_modal = escape_output($request->post('item_unit_modal'));

        $obj2 = new Manufacture();

        $finishProductFifo = $obj2->getFinishProductFifo($product_id);

        $html = '';

        $xquantity = 0;

        foreach ($finishProductFifo as $value) {
            $productInfo = FinishedProduct::where('del_status', 'Live')
                ->where('id', $product_id)
                ->first();

            $item_quantity = 0;

            $avaiable_quantity = $value->product_quantity;

            if ($quantity > 0) {
                if ($quantity < $avaiable_quantity) {
                    $item_quantity = $quantity;

                } else {
                    $item_quantity = $avaiable_quantity;

                }

                $html .= '<tr class="rowCount" data-id="' . $item_id_modal . '">
                    <td class="width_1_p text-start"><p class="set_sn">1</p></td>
                    <td><input type="hidden" value="' . $product_id . '" name="selected_product_id[]">
                    <input type="hidden" value="' . $productInfo->current_total_stock . '" class="current_stock" name="current_stock[]">
                    <input type="hidden" value="' . $value->id . '" name="rm_id[]"><span>' . $productInfo->name . '(' . $productInfo->code . ')</span></td>
                    <td><div class="input-group"><input type="text" tabindex="5" name="unit_price[]" onfocus="this.select();" class="check_required form-control integerchk input_aligning unit_price_c cal_row" placeholder="Unit Price" value="' . $unit_price . '"><span class="input-group-text">' . $item_currency_modal . '</span></div><span class="text-danger"></span></td>
                    <td><div class="input-group"><input type="text" data-countid="1" tabindex="51" id="quantity_amount_1" name="quantity_amount[]" onfocus="this.select();" class="check_required form-control integerchk input_aligning qty_c cal_row" value="' . $item_quantity . '" placeholder="Qty/Amount" ><span class="input-group-text">' . $item_unit_modal . '</span></div><span class="text-danger"></span></td>
                    <td><div class="input-group"><input type="text" id="total_1" name="total[]" class="form-control input_aligning total_c" placeholder="Total" readonly=""><span class="input-group-text">' . $item_currency_modal . '</span></div></td>
                    <td class="ir_txt_center"><a class="btn btn-xs del_row dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>
                </tr>';
            }

            $quantity = $quantity - $item_quantity;

            $item_id_modal = $item_id_modal + 1;
        }
        //we skip escape due to html content
        echo ($html);
    }

    public function getFefoFProduct(Request $request)
    {
        $product_id = escape_output($request->post('id'));
        $unit_price = escape_output($request->post('unit_price'));
        $quantity = escape_output($request->post('quantity'));
        $item_id_modal = escape_output($request->post('item_id_modal'));
        $item_currency_modal = escape_output($request->post('item_currency_modal'));
        $item_unit_modal = escape_output($request->post('item_unit_modal'));

        $setting = getSettingsInfo();

        $obj2 = new Manufacture();
        $finishProductFefo = $obj2->getFinishProductFefo($product_id);

        $html = '';

        foreach ($finishProductFefo as $value) {
            $productInfo = FinishedProduct::where('del_status', 'Live')
                ->where('id', $product_id)
                ->first();

            $item_quantity = 0;

            $avaiable_quantity = $value->product_quantity;

            if ($quantity > 0) {
                if ($quantity < $avaiable_quantity) {
                    $item_quantity = $quantity;

                } else {
                    $item_quantity = $avaiable_quantity;

                }

                $html .= '<tr class="rowCount" data-id="' . $item_id_modal . '">
                    <td class="width_1_p text-start"><p class="set_sn">1</p></td>
                    <td><input type="hidden" value="' . $product_id . '" name="selected_product_id[]">
                    <input type="hidden" value="' . $value->id . '" name="manufacture_id[]">
                    <input type="hidden" value="' . $productInfo->current_total_stock . '" class="current_stock" name="current_stock[]">
                    <input type="hidden" value="' . $value->id . '" name="rm_id[]"><span>' . $productInfo->name . '(' . $productInfo->code . ')</span><br>';
                if ($value->expiry_days !== null) {
                    $html .= 'Expiry Date: ' . getDateFormat(expireDate($value->complete_date, $value->expiry_days));
                }
                $html .= '</td>
                    <td><div class="input-group"><input type="text" tabindex="5" name="unit_price[]" onfocus="this.select();" class="check_required form-control integerchk input_aligning unit_price_c cal_row" placeholder="Unit Price" value="' . $unit_price . '"><span class="input-group-text">' . $item_currency_modal . '</span></div><span class="text-danger"></span></td>
                    <td><div class="input-group"><input type="text" data-countid="1" tabindex="51" id="quantity_amount_1" name="quantity_amount[]" onfocus="this.select();" class="check_required form-control integerchk input_aligning qty_c cal_row" value="' . $item_quantity . '" placeholder="Qty/Amount" ><span class="input-group-text">' . $item_unit_modal . '</span></div><span class="text-danger"></span></td>
                    <td><div class="input-group"><input type="text" id="total_1" name="total[]" class="form-control input_aligning total_c" placeholder="Total" readonly=""><span class="input-group-text">' . $item_currency_modal . '</span></div></td>
                    <td class="ir_txt_center"><a class="btn btn-xs del_row dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>
                </tr>';
            }

            $quantity = $quantity - $item_quantity;

            $item_id_modal = $item_id_modal + 1;
        }

        //we skip escape due to html content
        echo ($html);
    }

    public function getBatchControlProduct(Request $request)
    {
        $product_id = escape_output($request->get('product_id'));
        $productList = Manufacture::where('product_id', $product_id)->where('del_status', "Live")->get()->map(function ($item) {
            $item->expiry_date = expireDate($item->complete_date, $item->expiry_days);
            return $item;
        });
        echo json_encode($productList);
    }

    public function getFinishProductDetails(Request $request)
    {
        $fproduct_id = escape_output($request->post('id'));

        $productList = FinishedProduct::with(['rmaterials', 'rmaterials.rawMaterials.unit', 'nonInventory', 'rmaterials.rawMaterials', 'nonInventory.nonInventoryItem', 'stage','materialstock'])->where('id', $fproduct_id)->first();

        echo json_encode($productList);
    }

    public function getStockMaterialsByCustomer(Request $request)
    {
        // dd($request->all());
        // $mat_type = escape_output($request->post('mat_type'));
        $rm_ids = $request->post('rm_ids');
        $customer_id = escape_output($request->post('customer_id'));
        $materialList = MaterialStock::with('rawMaterials', 'customer')
            ->whereIn('mat_id', $rm_ids)
            ->where('del_status','Live')
            ->where(function ($query) use ($customer_id) {
                $query->where('customer_id', $customer_id)
                    ->orWhereNull('customer_id');
            })
            ->orderByRaw("CASE
                            WHEN customer_id = ? THEN 0
                            WHEN customer_id IS NULL THEN 1
                            ELSE 2
                        END", [$customer_id])
            ->get();
        foreach ($materialList as $material) {
            $material->unit = getRMUnitById($material->unit_id);
        }
        // dd($materialList);
        echo json_encode($materialList);
    }

    public function getProductQty(Request $request)
    {
        $product_id = escape_output($request->post('product_id'));
        $customer_order_id = escape_output($request->post('customer_order_id'));
        $orderDetail = CustomerOrderDetails::where('customer_order_id', $customer_order_id)->where('product_id',$product_id)->where('del_status', "Live")->first();
        $data_arr['quantity'] = $orderDetail->quantity;
        $data_arr['profit'] = $orderDetail->profit;
        $data_arr['tax_type'] = TaxItems::where('id',$orderDetail->tax_type)->where('collect_tax','Yes')->first()->tax_type;
        if($orderDetail->inter_state=='Y') {
            $tax_percent = (float)$orderDetail->igst;
        } else {
            $tax_percent = (float)$orderDetail->cgst + (float)$orderDetail->sgst;
        }
        $sub_total = $orderDetail->unit_price * $orderDetail->quantity;
        $data_arr['tax_value'] = $sub_total * ($tax_percent/100);
        // echo json_encode($data_arr);
        return response()->json($data_arr);
    }

    public function getCustomerOrderList(Request $request)
    {
        $customer_id = escape_output($request->post('id'));
        $orders = CustomerOrder::where('customer_id', $customer_id)
            ->where('del_status', 'Live')
            ->where('order_status', '1')
            ->orderBy('id', 'DESC')
            ->get();

        $html = '<option value="">Select</option>';

        foreach ($orders as $order) {
            $totalProduct = $order->total_product;

            // Count how many times this order ID is already used in production
            $manufacturedCount = Manufacture::where('customer_order_id', $order->id)
                ->where('del_status', 'Live')
                ->count();

            if ($totalProduct > $manufacturedCount) {
                $html .= '<option value="' . $order->id . '">' . $order->reference_no . '</option>';
            }
        }

        echo $html;

        // dd($mf_cnt);
        /* $used_order_ids = DB::table('tbl_manufactures')
            ->where('customer_id', $customer_id)
            ->pluck('customer_order_id')
            ->toArray();

        $customerOrderList = CustomerOrder::where('customer_id', $customer_id)
            ->where('del_status', 'Live')
            ->where('order_status', '1')
            ->whereNotIn('id', $used_order_ids)
            ->orderBy('id', 'DESC')
            ->get(); */

    }

    public function getCustomerOrderProducts(Request $request)
    {
        $customer_order_id = escape_output($request->post('id'));
        $from = escape_output($request->post('from'));
        $manufacture_prods = Manufacture::where('customer_order_id',$customer_order_id)->where('del_status', "Live")->pluck('product_id')->toArray();
        if(empty($manufacture_prods)) {
            $orderDetails = CustomerOrderDetails::where('customer_order_id', $customer_order_id)->where('del_status', "Live")->get();
        } else {
            $orderDetails = CustomerOrderDetails::where('customer_order_id', $customer_order_id)->whereNotIn('product_id',$manufacture_prods)->where('del_status', "Live")->get();
        }
        $productId = [];
        $html = '<option value="">Select</option>';
        foreach ($orderDetails as $key => $value) {
            $productList = FinishedProduct::where('id', $value->product_id)->where('del_status', "Live")->first();
            if ($request->has('from') && $from == 'purchase') {
                $productId[$key] = $productList->id;
            }
            
            $html .= '<option value="' . $productList->id . "|" . $productList->stock_method . '">' . $productList->name .'('.$productList->code.')'. '</option>';
        }
        if ($request->has('from') && $from == 'purchase') {
            return $productId;
        } else {
            echo ($html);
        }
    }
    //new
    public function getCustomerProductionProducts(Request $request)
    {
        $customer_id = escape_output($request->post('id'));
        $html = '<option value="">Select</option>';
        $quoted_pairs = QuotationDetail::where('del_status', 'Live')
            ->get(['customer_order_id', 'product_id'])
            ->map(function ($item) {
                return $item->customer_order_id . '|' . $item->product_id;
            })->toArray();
        $manufactures = Manufacture::where('customer_id', $customer_id)
            ->where('manufacture_status', 'done')
            ->whereHas('inspect_approval', function ($q) {
                $q->where('status', 2);
            })
            ->where('del_status', 'Live')
            ->get();

        foreach ($manufactures as $manufacture) {
            $pair_key = $manufacture->customer_order_id . '|' . $manufacture->product_id;
            if (!in_array($pair_key, $quoted_pairs)) {
                $product = FinishedProduct::where('id', $manufacture->product_id)
                    ->where('del_status', 'Live')
                    ->first();

                if ($product) {
                    $html .= '<option value="' . $product->id . "|" . $manufacture->customer_order_id . '">' . $manufacture->reference_no . ' (' . $product->name . ')</option>';
                }
            }
        }
        echo $html;
    }
    //new
    public function getProductDetails(Request $request)
    {
        $product_id = escape_output($request->get('product_id'));
        $customer_order_id = escape_output($request->get('customer_order_id'));
        $manufactureDetail = Manufacture::with('product')->where('customer_order_id', $customer_order_id)->where('product_id',$product_id)->where('del_status', "Live")->first();
        $manufactureDetail->subtotal_price = $manufactureDetail->msale_price;
        $manufactureDetail->profit = $manufactureDetail->mrmcost_total * ($manufactureDetail->mprofit_margin/100);
        $productionStockId = Mrmitem::where('manufacture_id',$manufactureDetail->id)->where('del_status','Live')->first();
        $stockUnitId = MaterialStock::where('id',$productionStockId->stock_id)->where('del_status','Live')->first();
        /* if($stockUnitId->stock_type=='customer') {
            $po_date = CustomerOrder::where('reference_no',$stockUnitId->reference_no)->where('del_status','Live')->pluck('created_at')->first();
            $manufactureDetail->po_date = date('d-m-Y',strtotime($po_date));
        } else {
            $po_date = RawMaterialPurchase::where('reference_no',$stockUnitId->reference_no)->where('del_status','Live')->pluck('date')->first();
            $manufactureDetail->po_date = date('d-m-Y',strtotime($po_date));
        } */
        $order = CustomerOrder::where('id',$customer_order_id)->where('del_status','Live')->first();
        $manufactureDetail->unit_name = getRMUnitById($stockUnitId->unit_id);
        $manufactureDetail->unit_id = $stockUnitId->unit_id;
        $manufactureDetail->reference_no = $order->reference_no;
        $manufactureDetail->po_date = date('d-m-Y',strtotime($order->created_at));
        $order_detail = CustomerOrderDetails::where('customer_order_id',$customer_order_id)->where('product_id',$product_id)->where('del_status','Live')->first();
        $sale_price = $order_detail->sale_price;
        $discount_percent = $order_detail->discount_percent;
        if($order_detail->discount_percent==0) {
            $disc_val = 0;
            $after_dis = $sale_price;
        } else {
            $disc_val = $sale_price * ($discount_percent / 100);
            $after_dis = $sale_price - $disc_val;
        }
        // dd($disc_val);
        $tax = TaxItems::where('id',$order_detail->tax_type)->where('del_status','Live')->first();
        $tax_value = $after_dis * ($tax->tax_value / 100);
        $manufactureDetail->tax_value = $tax_value;
        $manufactureDetail->msale_price = $after_dis + $tax_value;
        $manufactureDetail->sale_price = $sale_price;
        $manufactureDetail->tax_rate = $tax->tax_value;
        $manufactureDetail->tax_type = $tax->tax_type;
        $manufactureDetail->raw_qty = $order_detail->raw_qty;
        $manufactureDetail->disc_val = $disc_val;
        $manufactureDetail->nob = $order_detail->tax_type; //nature of business
        echo $manufactureDetail;
    }

    public function getProductionData(Request $request)
    {
        $manufactureId = $request->manufacture_id;
        $rmMaterials = Mrmitem::where('manufacture_id', $manufactureId)->where('del_status', "Live")->get();

        $i = 1;
        $table_row = '';
        $setting = getSettingsInfo();
        if (!empty($rmMaterials) && isset($rmMaterials)) {
            foreach ($rmMaterials as $key => $value) {
                $rawMaterials = RawMaterial::find($value->rmaterials_id);
                $last_p_price = getLastPurchasePrice($rawMaterials->id);
                $table_row .= '<tr class="rowCount" data-id="' . $rawMaterials->id . '">
                                    <td class="width_1_p ir_txt_center"><p class="set_sn"></p></td>
                                    <td><input type="hidden" value="' . $rawMaterials->id . '" name="rm_id[]"> <span>' . $rawMaterials->name . '(' . $rawMaterials->code . ')' . '</span></td>

                                    <td><div class="input-group"><input type="text" name="unit_price[]" onfocus="this.select();" class="check_required form-control integerchk unit_price_c cal_row" placeholder="Unit Price" value="' . $last_p_price . '" id="unit_price_1"><span class="input-group-text">  ' . $setting->currency . '</span></div></td>

                                    <td><div class="input-group"><input type="text" data-countid="1" tabindex="51" id="qty_1" name="quantity_amount[]" onfocus="this.select();" class="check_required form-control integerchk qty_c cal_row" value="1" placeholder="0"><span class="input-group-text">' . getRMUnitById($rawMaterials->unit) . '</span></div></td>

                                    <td><div class="input-group"><input type="text" id="total_1" name="total[]" class="form-control total_c" value="" placeholder="Total" readonly=""><span class="input-group-text">  ' . $setting->currency . '</span></div></td>
                                    <td class="ir_txt_center"><a class="btn btn-xs del_row dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>
                                </tr>';
                $i++;
            }
        }
        //we skip escape due to html content
        echo ($table_row);
    }

    public function getProduct()
    {
        $product = FinishedProduct::orderBy('id', 'DESC')->where('del_status', "Live")->get(['id', 'name', 'code']);
        echo json_encode($product);
    }
    public function getProductById(Request $request)
    {
        $product = FinishedProduct::where('del_status', "Live")->where('id',$request->id)->first();
        echo json_encode($product);
    }
    public function editTax(Request $request)
    {
        $tax_id = $request->id;
        $tax = Tax::leftJoin('tbl_tax_items', 'tbl_tax_items.id', '=', 'tbl_taxes.tax_id')
        ->select('tbl_tax_items.*', 'tbl_taxes.*')
        ->where('tbl_taxes.tax_id',$tax_id)
        ->get();
        // dd($tax);
        echo json_encode($tax);
    }
    public function updateOrderStatus(Request $request) {
        // dd($request->all());
        $order_status = $request->order_status;
        $order_id = $request->order_id;
        $order = CustomerOrder::find($order_id);
        // dd($order);
        if ($order) {
            $order->order_status = $order_status;
            $order->save();
            if ($order_status == '1') {
                $order_invoice = new CustomerOrderInvoice();
                $order_invoice->customer_order_id = $order_id;
                $order_invoice->invoice_type = 'Quotation';
                $order_invoice->amount = $order->total_amount;
                $order_invoice->paid_amount = 0.00;
                $order_invoice->due_amount = $order->total_amount;
                $order_invoice->invoice_date = date('Y-m-d');
                $order_invoice->updated_at = date('Y-m-d h:i:s');
                $order_invoice->save();
                return response()->json(['status' => true, 'message' => 'Order quotation confirmed successfully.']);
            }
            return response()->json(['status' => true, 'message' => 'Order quotation cancelled successfully.']);
        } else {
            return response()->json(['status' => false, 'message' => 'Order not found.']);
        }
    }
    public function getCustomerDetail(Request $request)
    {
        $customer = Customer::where('del_status', "Live")->where('id',$request->id)->orderBy('id', 'DESC')->first();
        echo json_encode($customer);
    }
    public function getMaterialById(Request $request)
    {
        $cat_id = escape_output($request->post('id'));
        $raw_materials = RawMaterial::where('del_status', "Live")->where('category',$cat_id)->orderBy('id', 'DESC')->get();
        echo json_encode($raw_materials);
    }
    public function getInsertType(Request $request)
    {
        $mat_cat_id = escape_output($request->post('mat_cat_id'));
        $mat_id = escape_output($request->post('mat_id'));
        $raw_material = RawMaterial::where('del_status', "Live")->where('category',$mat_cat_id)->where('id',$mat_id)->orderBy('id', 'DESC')->first();
        echo json_encode($raw_material);
    }

    public function getMaterialByMatType(Request $request)
    {
        $mat_type = escape_output($request->post('mat_type'));
        $material_ids = MaterialStock::where('del_status', "Live")
            ->where('mat_type', $mat_type)
            ->pluck('mat_id')
            ->unique();

        $raw_materials = RawMaterial::whereIn('id', $material_ids)->get();
        echo json_encode($raw_materials);
    }

    public function getTaskPerson(Request $request)
    {
        $production_stage = escape_output($request->post('production_stage'));
        $manufacture_id = escape_output($request->post('manufacture_id'));
        $task_users = ProductionScheduling::where('manufacture_id',$manufacture_id)->where('production_stage_id', $production_stage)->where('del_status','Live')->pluck('user_id')->unique();
        $users = User::whereIn('id', $task_users)->get();
        echo json_encode($users);
    }

    public function getMaterialByMatInsType(Request $request)
    {
        $mat_type = escape_output($request->post('mat_type'));
        $ins_type = escape_output($request->post('ins_type'));
        $material_ids = MaterialStock::where('del_status', "Live")
            ->where('mat_type', $mat_type)
            ->where('ins_type',$ins_type)
            ->pluck('mat_id')
            ->unique();
        $raw_materials = RawMaterial::whereIn('id', $material_ids)->get();
        echo json_encode($raw_materials);
    }

    public function getMaterialStockByType(Request $request)
    {
        $mat_type = $request->post('mat_type');
        // dd($mat_type);
        $html = "<option value=''>Select</option>";
        if(!empty($mat_type)) {
            /* if (is_array($mat_type) && in_array("2", $mat_type) && in_array("3", $mat_type)) {
                $materials = RawMaterial::where('del_status', 'Live')
                ->orderBy('id','DESC')
                ->get();
            } else if (in_array("3", $mat_type)) {
                $materials = RawMaterial::where('category', 1)
                ->where('del_status', 'Live')
                ->orderBy('id','DESC')
                ->get();
            } else if(in_array("2", $mat_type)) {
                $materials = RawMaterial::where('category', '!=', 1)
                ->where('del_status', 'Live')
                ->orderBy('id','DESC')
                ->get();
            } else {
                $materials = RawMaterial::where('del_status', 'Live')
                ->orderBy('id','DESC')
                ->get();
            } */
           if($mat_type=="2") {
                $materials = RawMaterial::where('category', '!=', 1)
                ->where('del_status', 'Live')
                ->orderBy('id','DESC')
                ->get();
            } else {
                $materials = RawMaterial::where('del_status', 'Live')
                ->orderBy('id','DESC')
                ->get();
            }
            foreach($materials as $raw) {
                $html .= "<option value='{$raw->id}|{$raw->name} ({$raw->code})|{$raw->name}|{$raw->insert_type}'>{$raw->name} ({$raw->code})</option>";
            }
        }
        return response($html);
    }
    public function getStockReference(Request $request)
    {
        $stock_type = $request->post('stock_type');
        $req_mat_id = explode('|',$request->post('mat_id'));
        $mat_id = $req_mat_id[0];
        $customer_id = $request->post('customer_id');
        if(!empty($stock_type)) {
            if ($stock_type == "purchase") {
                $html = "<option value=''>Select</option>";
                $purchases = RMPurchase_model::where('rmaterials_id', $mat_id)
                ->where('del_status', 'Live')
                ->orderBy('id', 'DESC')
                ->get();
                // dd($purchases);
                foreach ($purchases as $po) {
                    $purchase_order = RawMaterialPurchase::where('id', $po->purchase_id)
                        ->where('status', 'Completed')
                        ->where('del_status', 'Live')
                        ->first();
                    if (!$purchase_order) {
                        continue;
                    }
                    $purchase_qty = $po->quantity_amount;
                    $reference_no = $purchase_order->reference_no;
                    
                    $in_material_stock = MaterialStock::where('stock_type', 'purchase')
                        ->where('mat_id', $mat_id)
                        ->where('reference_no', $reference_no)
                        ->where('del_status', 'Live')
                        ->exists();
                    $in_adjust_logs = DB::table('tbl_stock_adjust_logs as logs')
                        ->join('tbl_material_stocks as ms', 'logs.mat_stock_id', '=', 'ms.id')
                        ->where('logs.stock_type', 'purchase')
                        ->where('logs.reference_no', $reference_no)
                        ->where('logs.type', 'addition')
                        ->where('logs.del_status', 'Live')
                        ->where('ms.mat_id', $mat_id)
                        ->where('ms.del_status', 'Live')
                        ->exists();
                        // dd($reference_no,$purchase_qty);
                    if (!$in_material_stock && !$in_adjust_logs) {
                        $html .= "<option value='{$reference_no}|{$purchase_qty}'>{$reference_no}</option>";
                    }
                }
                return response()->json(['type' => 'purchase', 'html' => $html]);
            } else {
                $html = "";
                $qty = "";$order_qty="";
                $order_ids = CustomerOrderDetails::where('raw_material_id', $mat_id)
                    ->where('del_status', 'Live')
                    ->pluck('customer_order_id');
                $manufact_order_ids = Manufacture::where('del_status','Live')->pluck('customer_order_id')->unique();
                $order = CustomerOrder::whereIn('id',$order_ids)->whereNotIn('id', $manufact_order_ids)
                ->where('customer_id', $customer_id)
                ->where('order_status', 1)
                ->where('del_status', 'Live')
                ->orderBy('id', 'ASC')
                ->first();
                // dd($order);
                if($order) {
                    // foreach ($orders as $order) {
                    $reference_no = $order->reference_no; 
                    $qty = CustomerOrderDetails::where('customer_order_id',$order->id)->where('raw_material_id',$mat_id)->where('del_status','Live')->pluck('raw_qty');
                    $in_material_stock = MaterialStock::where('stock_type', 'customer')
                        ->where('mat_id', $mat_id)
                        ->where('customer_id', $customer_id)
                        ->where('reference_no', $reference_no)
                        ->where('del_status', 'Live')
                        ->exists();
                    // dd($in_material_stock);
                    $in_adjust_logs = DB::table('tbl_stock_adjust_logs as logs')
                        ->join('tbl_material_stocks as ms', 'logs.mat_stock_id', '=', 'ms.id')
                        ->where('logs.stock_type', 'customer')
                        ->where('logs.reference_no', $reference_no)
                        ->where('logs.type', 'addition')
                        ->where('logs.del_status', 'Live')
                        ->where('ms.mat_id', $mat_id)
                        ->where('ms.customer_id', $customer_id)
                        ->where('ms.del_status', 'Live')
                        ->exists();
                    if (!$in_material_stock && !$in_adjust_logs) {
                        $html .= $reference_no;
                        $order_qty = $qty;
                    }
                // }
                }
                return response()->json(['type' => 'customer', 'html' => $html, 'qty'=> $order_qty]);
            }
        }
    }
    public function getProductionStages(Request $request)
    {
        $fproduct_id = escape_output($request->post('id'));
        $obj2 = new FPproductionstage();
        $finishProductStage = $obj2->getFinishProductStages($fproduct_id);
        $html = '<option value="">Select</option>';
        foreach ($finishProductStage as $key => $value) {
            $html .= '<option value="' . $value->productionstage_id . '|'.getProductionStage($value->productionstage_id).'">' . getProductionStage($value->productionstage_id) . '</option>';
        }
        $data_arr['html'] = $html;
        echo json_encode($data_arr);
    }
    public function getQCEndDate(Request $request)
    {
        $manufacture_id = $request->manufacture_id;
        // $scheduling_id = $request->scheduling_id;
        $complete_date = ProductionQCScheduling::where('manufacture_id',$manufacture_id)->where('del_status','Live')->max('complete_date');
        if($complete_date) {
            $last_complete_date = date('d-m-Y',strtotime($complete_date));
        } else {
            $last_complete_date = date('d-m-Y');
        }
        echo json_encode($last_complete_date);
    }
    public function getChallanDetails(Request $request) {
        $challan_id = $request->id;
        $final_data = [];
        $quotation_customer_id = Quotation::where('id',$challan_id)->where('del_status','Live')->pluck('customer_id');
        $customer = Customer::where('id',$quotation_customer_id)->where('del_status','Live')->first();
        $quotation_details = Quotationdetail::where('quotation_id',$challan_id)->where('del_status','Live')->get();
        $products = [];
        foreach ($quotation_details as $detail) {
            $product = FinishedProduct::where('id', $detail->product_id)
                ->where('del_status', 'Live')
                ->first();
            $order = DB::table('tbl_customer_orders')
                ->where('id', $detail->customer_order_id)
                ->where('del_status', 'Live')
                ->first();
            $orderDetail = DB::table('tbl_customer_order_details')
                ->where('customer_order_id', $detail->customer_order_id)
                ->where('product_id', $product->id)
                ->where('del_status', 'Live')
                ->first();
            $manufacture = DB::table('tbl_manufactures')
                ->where('customer_order_id', $detail->customer_order_id)
                ->where('product_id', $product->id)
                ->where('del_status', 'Live')
                ->first();
            if ($product && $order && $orderDetail) {
                $products[] = [
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'product_code' => $product->code,
                    'order_id'     => $order->id,
                    'order_no'     => $order->reference_no,
                    'quantity'     => $orderDetail->quantity,
                    'sale_price'     => $orderDetail->sub_total,
                    'unit' => getRMUnitById($detail->unit_id),
                    'manufacture_id' => $manufacture->id,
                ];
            }
        }
        $final_data[] = [
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_code' => $customer->customer_id,
            'products' => $products
        ];
        return response()->json($final_data);
    }
    public function getPaidAmount(Request $request) {
        $order_id = $request->order_id;
        $customerReceives = CustomerDueReceive::where('order_id',$order_id)->where('del_status','Live')->first();
        if($customerReceives) {
            $customer_paid[] = [
                'pay_amount' => $customerReceives->pay_amount,
                'balance_amount' => $customerReceives->balance_amount,
            ];
        } else {
            $customer_paid[] = '';
        }
        return response()->json($customer_paid);
    }
    public function getTaxRate(Request $request) {
        $tax_type = $request->tax_type;
        $taxItems = TaxItems::where('id',$tax_type)->where('del_status','Live')->first();
        if($taxItems) {
            $tax_rate = $taxItems->tax_value;
        } else {
            $tax_rate = '';
        }
        return response()->json($tax_rate);
    }
}
