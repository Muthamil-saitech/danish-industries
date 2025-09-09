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
        Schema::create('tbl_drawing_parameters', function (Blueprint $table) {
            $table->id();
            $table->integer('drawing_id');
            $table->string('di_param',50);
            $table->string('di_spec',100);
            $table->string('di_method',100);
            $table->string('ap_param',50);
            $table->string('ap_spec',100);
            $table->string('ap_method',100);
            $table->enum('del_status', ['Live', 'Deleted'])->default('Live');
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
        Schema::dropIfExists('tbl_drawing_parameters');
    }
};
