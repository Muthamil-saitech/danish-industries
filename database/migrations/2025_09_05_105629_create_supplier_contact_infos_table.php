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
        Schema::create('tbl_supplier_contact_info', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id');
            $table->string('scp_name',50);
            $table->string('scp_department',30);
            $table->string('scp_designation',30);
            $table->text('scp_phone');
            $table->string('scp_email',128);
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
        Schema::dropIfExists('tbl_supplier_contact_info');
    }
};
