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
        Schema::create('aset_kendaraans', function (Blueprint $table) {
            $table->id();
            $table->integer('kendaraan_id');
            $table->string('no_aset');
            $table->string('no_polis');
            $table->string('no_rangka');
            $table->string('no_mesin');
            $table->date('masa_pajak');
            $table->date('masa_stnk');
            $table->date('masa_asuransi');
            $table->date('tgl_service_rutin');
            $table->year('tahun_pembuatan');
            $table->year('tahun_pengadaan');
            $table->timestamps();
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aset_kendaraans');
    }
};
