<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerIo extends Model
{
    protected $table = "tbl_partner_ios";
    use HasFactory;
    public function partner() {
        return $this->belongsTo(Partner::class, 'partner_id');
    }
    public function details()
    {
        return $this->hasMany(PartnerIoDetail::class, 'partner_io_id')->where('del_status', 'Live');
    }
}
