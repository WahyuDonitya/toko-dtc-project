<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hpenerimaan_barang_toko', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('diterima_oleh')->unsigned();
            $table->foreign('diterima_oleh')->references('id')->on('users');
            $table->bigInteger('barangkeluar_id')->unsigned();
            $table->foreign('barangkeluar_id')->references('id')->on('hbarang_keluar');
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hpenerimaan_barang_toko');
    }
};
