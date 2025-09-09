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
        DB::statement("ALTER TABLE `tbl_instruments` CHANGE `name` `instrument_name` VARCHAR(50)");
    }

    public function down()
    {
        DB::statement("ALTER TABLE `tbl_instruments` CHANGE `instrument_name` `name` VARCHAR(50)");
    }

};
