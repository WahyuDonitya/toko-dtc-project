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
        Schema::create('dbarang_masuk', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('hbarang_masuk')->unsigned();
            $table->foreign('hbarang_masuk')->references('id')->on('hbarang_masuk');
            $table->bigInteger('barang_id')->unsigned();
            $table->foreign('barang_id')->references('id')->on('barang');
            $table->bigInteger('barangmasuk_jumlah');
            $table->bigInteger('barangmasuk_harga');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbarang_masuk');
    }
};
