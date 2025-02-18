<?php

namespace App\Imports;

use App\Models\BarangModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new BarangModel([
            'barang_barcode' => $row['barcode'],
            'barang_nama' => $row['nama'],
            'barang_stok' => 0,
            'het' => $row['het'],
            'barang_harga' => 0
        ]);
    }
}
