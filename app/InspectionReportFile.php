<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionReportFile extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "tbl_inspection_report_files";
}
