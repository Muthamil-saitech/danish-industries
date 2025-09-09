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
        Schema::create('tbl_instruments', function (Blueprint $table) {
            $table->id();
            $table->string('code',50);
            $table->string('name',50);
            $table->integer('type');
            $table->integer('category');
            $table->integer('unit');
            $table->integer('owner_type');
            $table->integer('customer_id')->nullable();
            $table->string('range',50);
            $table->string('accuracy',25);
            $table->string('make',25);
            $table->date('calibration');
            $table->string('remarks',255);
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
        Schema::dropIfExists('instruments');
    }
};
