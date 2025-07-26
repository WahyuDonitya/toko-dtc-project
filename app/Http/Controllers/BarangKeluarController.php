<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BarangKeluarController extends Controller
{
    public function create()
    {
        $barangList = BarangModel::all();
        return view('barang_keluar.create', compact([
            'barangList'
        ]));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penanggung_jawab' => 'required',
            'barang_id' => 'required|array',
            'jumlah_barang' => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with([
                    'barang' => [
                        'barang_id' => $request->barang_id ?? [],
                        'jumlah_barang' => $request->jumlah_barang ?? [],
                        'stok_barang' => $request->stok_barang ?? [],
                    ],
                ]);
        }

        DB::beginTransaction();

        try {
            foreach ($request->barang_id as $index => $barangId) {
                $jumlah = $request->jumlah_barang[$index];

                $barang = BarangModel::find($barangId);

                if (!$barang) {
                    throw new Exception("Barang dengan ID $barangId tidak ditemukan.");
                }

                if ($jumlah > $barang->barang_stok) {
                    throw new Exception("Jumlah barang keluar untuk {$barang->barang_nama} melebihi stok yang tersedia ({$barang->barang_stok}).");
                }
            }
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil membuat transaksi!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with([
                    'barang' => [
                        'barang_id' => $request->barang_id ?? [],
                        'jumlah_barang' => $request->jumlah_barang ?? [],
                        'stok_barang' => $request->stok_barang ?? [],
                    ],
                ])
                ->with('danger',  $e->getMessage());
        }
    }
}
