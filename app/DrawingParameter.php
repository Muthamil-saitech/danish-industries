<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrawingParameter extends Model
{
    use HasFactory;
    protected $table = "tbl_drawing_parameters";
    protected $guarded = [];
}
