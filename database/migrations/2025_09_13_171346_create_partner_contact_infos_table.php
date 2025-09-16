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
        Schema::create('tbl_partner_contact_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('partner_id');
            $table->string('pcp_name',50);
            $table->string('pcp_department',30);
            $table->string('pcp_designation',30);
            $table->text('pcp_phone');
            $table->string('pcp_email',128);
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
        Schema::dropIfExists('partner_contact_infos');
    }
};
