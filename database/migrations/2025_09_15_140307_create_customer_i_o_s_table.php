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
        Schema::create('tbl_customer_ios', function (Blueprint $table) {
            $table->id();
            $table->string('po_no',50);
            $table->integer('line_item_no');
            $table->integer('customer_id');
            $table->date('date');
            $table->string('d_address',255);
            $table->string('file',150)->nullable();
            $table->enum('status', ['Inward', 'Outward'])->default('Inward');
            $table->date('inward_date')->nullable();
            $table->string('notes',255)->nullable();
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
        Schema::dropIfExists('customer_i_o_s');
    }
};
