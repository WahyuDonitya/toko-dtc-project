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
        Schema::table('h_purchaseorder', function (Blueprint $table) {
            $table->integer('status_penerimaan')->comment('0: Belum di terima, 1: diterima sebagian, 2: sudah tuntas')->after('isLunas');
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
