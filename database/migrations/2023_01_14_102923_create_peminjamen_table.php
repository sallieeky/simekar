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
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('kendaraan_id')->nullable();
            $table->integer('driver_id')->nullable();
            $table->integer('tujuan_peminjaman_id');
            $table->integer('nomor_peminjaman');
            $table->text('keperluan');
            $table->string('status');
            $table->dateTime('waktu_peminjaman');
            $table->dateTime('waktu_selesai');
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
        Schema::dropIfExists('peminjamen');
    }
};
