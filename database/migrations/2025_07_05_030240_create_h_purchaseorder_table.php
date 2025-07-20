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
        Schema::create('h_purchaseorder', function (Blueprint $table) {
            $table->id();
            $table->string('hpo_nota');
            $table->bigInteger('supplier_id')->unsigned();
            $table->foreign('supplier_id')->references('id')->on('supplier');
            $table->string('hpo_sales');
            $table->string('hpo_sales_phone')->nullable();
            $table->bigInteger('hpo_jumlahpembelian');
            $table->bigInteger('hpo_jumlahdibayar')->nullable();
            $table->bigInteger('hpo_jumlahbelumdibayar')->nullable();
            $table->integer('isLunas')->comment('0: masih belum lunas, 1: sudah lunas');
            $table->date('hpo_jatuhtempo')->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('h_purchaseorder');
    }
};
