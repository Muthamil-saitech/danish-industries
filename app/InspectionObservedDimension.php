<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionObservedDimension extends Model
{
    use HasFactory;
    protected $table = 'tbl_inspection_observed_dimensions';
    protected $guarded = [];
}
