<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierContactInfo extends Model
{
    use HasFactory;
    protected $table = 'tbl_supplier_contact_info';
    protected $guarded = [];
}
