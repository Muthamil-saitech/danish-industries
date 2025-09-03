<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionParam extends Model
{
    use HasFactory;
    protected $table = "tbl_inpection_params";
    protected $guarded = [];
    public function inspectionDimensions() {
        return $this->hasMany(InspectionObservedDimension::class, 'inspect_param_id');
    }
}
