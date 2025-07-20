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
        Schema::table('detail_barang', function (Blueprint $table) {
            // 1. Hapus foreign key terlebih dahulu
            $table->dropForeign(['supplier_id']);

            // 2. Baru hapus index
            $table->dropIndex('detail_barang_supplier_id_foreign');

            // 3. Hapus kolom (jika perlu)
            $table->dropColumn('supplier_id');

            $table->integer('status')->comment('0: masih ada, 1: habis, 2: exp');
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
