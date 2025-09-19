<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Drawer extends Model
{
    use HasFactory;
    protected $table = "tbl_drawers";
    protected $guarded = [];

    public function getDrawerStages($drawer_id){
        $stageIdsString = DB::table('tbl_drawers')
        ->where('id', $drawer_id)
        ->where('del_status', 'Live')
        ->value('stage_id');
        $stageIds = explode(',', $stageIdsString);
        $result = DB::table('tbl_production_stages')
            ->whereIn('id', $stageIds)
            ->where('del_status', 'Live')
            ->orderBy('id', 'ASC')
            ->get();
        return $result;
    }
}
