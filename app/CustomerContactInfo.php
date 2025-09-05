<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerContactInfo extends Model
{
    use HasFactory;
    protected $table = 'tbl_customer_contact_info';
    protected $guarded = [];
}
