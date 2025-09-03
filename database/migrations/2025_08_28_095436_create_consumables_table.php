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
        Schema::create('tbl_consumables', function (Blueprint $table) {
            $table->id();
            $table->integer('manufacture_id');
            $table->integer('mat_id');
            $table->integer('user_id');
            $table->string('ppcrc_no',50);
            $table->integer('production_stage');
            $table->float('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_consumables');
    }
};
