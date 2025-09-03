<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationQcLog extends Model
{
    use HasFactory;
    protected $table = "tbl_quotation_qc_logs";
    protected $guarded = [];
}
