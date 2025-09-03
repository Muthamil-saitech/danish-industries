<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;
    protected $table = "tbl_inspections";
    protected $guarded = [];
    public function details()
    {
        return $this->hasMany(InspectionParam::class, 'inspect_id')->where('del_status', 'Live');
    }
}
