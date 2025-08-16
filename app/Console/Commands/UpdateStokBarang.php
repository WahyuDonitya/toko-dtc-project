<?php

namespace App\Console\Commands;

use App\Helpers\ConstantHelper;
use App\Models\BarangModel;
use App\Models\DetailBarangModel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateStokBarang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-stok-barang';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update stok barang berdasarkan exp_date di detail_barang';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mulai update stok...');

        $now = Carbon::now()->startOfDay();

        $barangs = BarangModel::all();

        foreach ($barangs as $barang) {
            $stokAktif = DetailBarangModel::where('barang_id', $barang->id)
                ->whereDate('exp_date', '>', $now)
                ->sum('stok');

            $barang->barang_stok = $stokAktif;
            $barang->save();

            DetailBarangModel::whereDate('exp_date', '<=', $now)
                ->where('barang_id', $barang->id)
                ->where('status', '!=', ConstantHelper::STATUS_DETAIL_BARANG_EXP)
                ->update(['status' => ConstantHelper::STATUS_DETAIL_BARANG_EXP]);
        }

        $this->info('Stok barang berhasil diperbarui berdasarkan exp_date.');
    }
}
