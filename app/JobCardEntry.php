<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCardEntry extends Model
{
    use HasFactory;
    protected $table = 'tbl_job_card_entries';
    protected $guarded = [];
}
