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
        Schema::table('history_pembayaran_po', function (Blueprint $table) {
            $table->string('metode_pembayaran')->nullable()->after('jumlah_bayar');
            $table->string('keterangan')->nullable()->after('metode_pembayaran');
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
