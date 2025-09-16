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
        Schema::create('tbl_customer_io_details', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_io_id');
            $table->integer('type');
            $table->integer('ins_category');
            $table->string('ins_name',50);
            $table->integer('qty')->nullable();
            $table->string('remarks',255)->nullable();
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
        Schema::dropIfExists('customer_io_details');
    }
};
