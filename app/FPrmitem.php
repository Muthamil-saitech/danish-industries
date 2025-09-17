<?php
/*
  ##############################################################################
  # iProduction - Production and Manufacture Management
  ##############################################################################
  # AUTHOR:		Door Soft
  ##############################################################################
  # EMAIL:		info@doorsoft.co
  ##############################################################################
  # COPYRIGHT:		RESERVED BY Door Soft
  ##############################################################################
  # WEBSITE:		https://www.doorsoft.co
  ##############################################################################
  # This is FPrmitem Model
  ##############################################################################
 */
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FPrmitem extends Model
{
    protected $table = "tbl_finished_products_rmaterials";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get Finish Product Raw Material
     */

    public function getFinishProductRM($fproduct_id){
        $result = DB::select("SELECT * FROM tbl_finished_products_rmaterials WHERE del_status='Live' AND finish_product_id='$fproduct_id' ORDER BY id DESC");
        return $result;
    }

    public function getOrderProductRM($fproduct_id,$selected_customer_id,$customer_order_id,$owner_type){
        $order_material = CustomerOrderDetails::where('id',$customer_order_id)->where('product_id',$fproduct_id)->where('del_status','Live')->first();
        $order = CustomerOrder::where('id',$order_material->customer_order_id)->where('del_status','Live')->first();
        // dd($order_material->raw_material_id);
        if($owner_type=="2" && $selected_customer_id) {
            $result = DB::select("
                SELECT 
                    tbl_material_stocks.*,
                    tbl_customers.name AS customer_name, 
                    tbl_customers.customer_id AS customer_code
                FROM tbl_material_stocks
                LEFT JOIN tbl_customers 
                    ON tbl_material_stocks.customer_id = tbl_customers.id
                WHERE tbl_material_stocks.del_status = 'Live'
                    AND tbl_material_stocks.customer_id = ?
                    AND tbl_material_stocks.mat_id = ?
                    AND tbl_material_stocks.reference_no = ?
                    AND tbl_material_stocks.line_item_no = ?
                    AND tbl_material_stocks.owner_type = ?
                ORDER BY tbl_material_stocks.id DESC
            ", [$selected_customer_id, $order_material->raw_material_id, $order->reference_no, $order_material->line_item_no, $owner_type]);
            // dd($result);
            // $result = DB::select("SELECT * FROM tbl_material_stocks WHERE del_status='Live' AND mat_type='$stk_mat_type' AND customer_id='$selected_customer_id' AND mat_id='$order_material->raw_material_id' ORDER BY id DESC");
        } elseif($owner_type=="1") {
            $result = DB::select("
                SELECT 
                    tbl_material_stocks.mat_id,
                    tbl_material_stocks.owner_type,
                    GROUP_CONCAT(DISTINCT tbl_suppliers.name ORDER BY tbl_suppliers.name SEPARATOR ', ') AS supplier_names,
                    GROUP_CONCAT(DISTINCT tbl_suppliers.supplier_id ORDER BY tbl_suppliers.supplier_id SEPARATOR ', ') AS supplier_codes,
                    GROUP_CONCAT(tbl_suppliers.id ORDER BY tbl_suppliers.id SEPARATOR ', ') AS supplier_ids,
                    GROUP_CONCAT(tbl_material_stocks.id ORDER BY tbl_material_stocks.id DESC SEPARATOR ', ') AS stock_ids,
                    GROUP_CONCAT(tbl_material_stocks.current_stock ORDER BY tbl_material_stocks.id DESC SEPARATOR ', ') AS supplier_stocks,
                    MAX(tbl_material_stocks.created_at) AS last_created_at
                FROM tbl_material_stocks
                LEFT JOIN tbl_suppliers 
                    ON tbl_material_stocks.supplier_id = tbl_suppliers.id
                WHERE tbl_material_stocks.del_status = 'Live'
                    AND tbl_material_stocks.mat_id = ?
                    AND tbl_material_stocks.owner_type = ?
                GROUP BY tbl_material_stocks.mat_id, tbl_material_stocks.owner_type
                ORDER BY MAX(tbl_material_stocks.id) DESC
            ", [$order_material->raw_material_id, $owner_type]);
            // dd($result);
        } else {
            $result = [];
        }
        return $result;
    }

    /**
     * Relationship with Raw Material
     */
    public function rawMaterials()
    {
        return $this->belongsTo(RawMaterial::class, 'rmaterials_id');
    }
}
