<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionApprove extends Model
{
    use HasFactory;
    protected $table = 'tbl_inspection_approves';
    protected $guarded = [];
}
