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
        Schema::create('dbarang_keluar', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('barangkeluar_id')->unsigned();
            $table->foreign('barangkeluar_id')->references('id')->on('hbarang_keluar');
            $table->bigInteger('barang_id')->unsigned();
            $table->foreign('barang_id')->references('id')->on('barang');
            $table->bigInteger('jumlah');
            $table->bigInteger('jumlah_terima');
            $table->date('exp_date');
            $table->integer('status_terima');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbarang_keluar');
    }
};
