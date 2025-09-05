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
        Schema::create('tbl_customer_contact_info', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('cp_name',50);
            $table->string('cp_department',30);
            $table->string('cp_designation',30);
            $table->text('cp_phone');
            $table->string('cp_email',128);
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
        Schema::dropIfExists('tbl_customer_contact_info');
    }
};
