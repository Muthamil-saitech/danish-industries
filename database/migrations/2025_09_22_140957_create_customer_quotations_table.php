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
        Schema::create('tbl_customer_quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_no',50);
            $table->integer('customer_id');
            $table->date('quote_date');
            $table->float('subtotal',10,2);
            $table->float('other',10,2);
            $table->float('discount',10,2);
            $table->float('grand_total',10,2);
            $table->string('note',255);
            $table->integer('user_id');
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
        Schema::dropIfExists('tbl_customer_quotations');
    }
};
