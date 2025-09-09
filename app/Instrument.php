<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    protected $table = 'tbl_instruments';
    protected $guarded = [];
    use HasFactory;
}
