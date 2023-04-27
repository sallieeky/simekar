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
        Schema::create('reimbursements', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->integer("kendaraan_id");
            $table->integer("nomor_reimburse");
            $table->string("kategori");
            $table->string("km_tempuh")->nullable();
            $table->string("status")->default('Dalam proses pengajuan');
            $table->text("keterangan")->nullable();
            $table->string("nominal");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reimbursements');
    }
};
