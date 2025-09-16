<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerIO extends Model
{
    use HasFactory;
    protected $table = "tbl_customer_ios";
    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function details()
    {
        return $this->hasMany(CustomerIoDetail::class, 'customer_io_id')->where('del_status', 'Live');
    }
}
