<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionQCScheduling extends Model
{
    use HasFactory;
    protected $table = "tbl_production_qc_scheduling";
    protected $guarded = [];
}
