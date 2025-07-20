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
        Schema::table('hbarang_masuk', function (Blueprint $table) {
            // 1. Hapus foreign key terlebih dahulu
            $table->dropForeign(['supplier_id']);
            
            // 2. Baru hapus index
            $table->dropIndex('hbarang_masuk_supplier_id_foreign');
            
            // 3. Hapus kolom (jika perlu)
            $table->dropColumn('supplier_id');

            $table->bigInteger('po_id')->unsigned();
            $table->foreign('po_id')->references('id')->on('h_purchaseorder')->after('id');
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
