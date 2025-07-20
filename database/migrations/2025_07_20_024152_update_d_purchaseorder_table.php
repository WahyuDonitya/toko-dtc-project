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
        Schema::table('d_purchaseorder', function (Blueprint $table) {
            $table->bigInteger('dpo_jumlahbarang_terima')->after('dpo_jumlahbarang');
            $table->integer('status')->after('dpo_totalharga')->comment('0 : belum tuntas, 1: sudah tuntas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
