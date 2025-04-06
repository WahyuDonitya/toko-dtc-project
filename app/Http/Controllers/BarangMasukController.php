<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\HbarangMasukModel;
use App\Models\SupplierModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barang = BarangModel::all();
        $supplier = SupplierModel::all();
        return view('barang_masuk.index', compact([
            'barang',
            'supplier'
        ]));
    }

    public function store(Request $request)
    {
        $nota = $this->createNoNota();
        $request->validate([
            'supplier' => 'required',
            'detail_supplier' => 'nullable|string',
            'barang_ids' => 'required|array',
            'jumlahs' => 'required|array',
            'jumlahs.*' => 'integer|min:1',
            'hargas' => 'required|array',
            'hargas.*' => 'numeric|min:0',
        ]);


        DB::beginTransaction();

        try {
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil menambahkan transaksi!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with([
                    'barang_masuk' => [
                        'barang_ids' => $request->barang_ids,
                        'jumlahs' => $request->jumlahs,
                        'hargas' => $request->hargas
                    ],
                    'old_supplier' => $request->supplier
                ])
                ->with('danger', 'Error! Hubungi tim IT!');
        }
    }

    public function getHargaBarang(Request $request)
    {
        $barang = BarangModel::find($request->id);

        if ($barang) {
            return response()->json(['success' => true, 'harga' => $barang->barang_harga]);
        }

        return response()->json(['success' => false]);
    }

    function createNoNota()
    {
        $tanggal = Carbon::now()->format('dmy');

        $lastNota = HbarangMasukModel::whereDate('created_at', Carbon::today())
            ->orderBy('barangmasuk_nota', 'desc')
            ->first();

        if ($lastNota) {
            $lastNumber = (int)substr($lastNota->no_nota, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        $noNota = 'BM' . $tanggal . $newNumber;

        return $noNota;
    }
}
