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
        Schema::create('d_purchaseorder', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('hpo_id')->unsigned();
            $table->foreign('hpo_id')->references('id')->on('h_purchaseorder');
            $table->bigInteger('barang_id')->unsigned();
            $table->foreign('barang_id')->references('id')->on('barang');
            $table->bigInteger('dpo_jumlahbarang');
            $table->bigInteger('dpo_totalharga');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_purhaseorder');
    }
};
