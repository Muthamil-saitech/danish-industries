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
        Schema::create('tbl_partners', function (Blueprint $table) {
            $table->id();
            $table->string('partner_id',30);
            $table->string('name',50);
            $table->string('phone',50);
            $table->string('email',100);
            $table->string('gst_no',16);
            $table->string('ecc_no',20);
            $table->string('area',50);
            $table->string('address',250);
            $table->string('note',250);
            $table->integer('added_by');
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
        Schema::dropIfExists('partners');
    }
};
