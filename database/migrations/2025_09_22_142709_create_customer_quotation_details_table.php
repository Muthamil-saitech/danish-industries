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
        Schema::create('tbl_customer_quotation_details', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_quotation_id');
            $table->integer('product_id');
            $table->float('unit_price',10,2);
            $table->float('quantity',10,2);
            $table->float('total',10,2);
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
        Schema::dropIfExists('customer_quotation_details');
    }
};
