<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumentCategory extends Model
{
    protected $table = 'tbl_instrument_categories';
    protected $guarded = [];
    use HasFactory;
}
