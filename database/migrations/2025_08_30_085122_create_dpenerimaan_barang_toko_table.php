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
        Schema::create('dpenerimaan_barang_toko', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('hpenerimaan_id')->unsigned();
            $table->foreign('hpenerimaan_id')->references('id')->on('hpenerimaan_barang_toko');
            $table->bigInteger('barang_id')->unsigned();
            $table->foreign('barang_id')->references('id')->on('barang');
            $table->bigInteger('jumlah');
            $table->date('exp_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpenerimaan_barang_toko');
    }
};
