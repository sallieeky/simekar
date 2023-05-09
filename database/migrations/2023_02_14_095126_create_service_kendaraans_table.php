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
        Schema::create('service_kendaraans', function (Blueprint $table) {
            $table->id();
            $table->integer('kendaraan_id');
            $table->string('kode');
            $table->text('uraian');
            $table->date('tgl_service');
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
        Schema::dropIfExists('service_kendaraans');
    }
};
