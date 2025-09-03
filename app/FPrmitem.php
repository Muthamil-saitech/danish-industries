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

    public function getOrderProductRM($fproduct_id,$stk_mat_type,$selected_customer_id,$customer_order_id){
        $order_material = CustomerOrderDetails::where('customer_order_id',$customer_order_id)->where('product_id',$fproduct_id)->where('del_status','Live')->first();
        // dd($order_material->raw_material_id);
        if($stk_mat_type=="1" && $selected_customer_id) {
            $result = DB::select("
                SELECT 
                    tbl_material_stocks.*,
                    tbl_customers.name AS customer_name, 
                    tbl_customers.customer_id AS customer_code
                FROM tbl_material_stocks
                LEFT JOIN tbl_customers 
                    ON tbl_material_stocks.customer_id = tbl_customers.id
                WHERE tbl_material_stocks.del_status = 'Live'
                    AND tbl_material_stocks.mat_type = ?
                    AND tbl_material_stocks.customer_id = ?
                    AND tbl_material_stocks.mat_id = ?
                ORDER BY tbl_material_stocks.id DESC
            ", [$stk_mat_type, $selected_customer_id, $order_material->raw_material_id]);
            // $result = DB::select("SELECT * FROM tbl_material_stocks WHERE del_status='Live' AND mat_type='$stk_mat_type' AND customer_id='$selected_customer_id' AND mat_id='$order_material->raw_material_id' ORDER BY id DESC");
        } else {
            $result = DB::select("SELECT * FROM tbl_material_stocks WHERE del_status='Live' AND mat_type='$stk_mat_type' AND mat_id='$order_material->raw_material_id' ORDER BY id DESC");
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
