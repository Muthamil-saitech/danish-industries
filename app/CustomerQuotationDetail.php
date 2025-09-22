<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerQuotationDetail extends Model
{
    use HasFactory;
    protected $table = 'tbl_customer_quotation_details';
    protected $guarded = [];
}
