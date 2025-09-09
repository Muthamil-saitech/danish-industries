<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `tbl_instruments` CHANGE `calibration` `calibration_due` DATE");
    }

    public function down()
    {
        DB::statement("ALTER TABLE `tbl_instruments` CHANGE `calibration_due` `calibration` DATE");
    }
};
