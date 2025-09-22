<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerQuotation extends Model
{
    use HasFactory;
    protected $table = 'tbl_customer_quotations';
    protected $guarded = [];
    public function quotationDetails()
    {
        return $this->hasMany(CustomerQuotationDetail::class, 'customer_quotation_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
