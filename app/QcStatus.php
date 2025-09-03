<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QcStatus extends Model
{
    use HasFactory;
    protected $table = "tbl_qc_statuses";
    protected $guarded = [];
}
