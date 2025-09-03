<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialStock extends Model
{
    use HasFactory;
    protected $table = "tbl_material_stocks";
    protected $guarded = [];
    public function rawMaterials()
    {
        return $this->belongsTo(RawMaterial::class, 'mat_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
