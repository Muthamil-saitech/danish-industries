<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteCardEntry extends Model
{
    use HasFactory;
    protected $table = 'tbl_route_card_entries';
    protected $guarded = [];
}
