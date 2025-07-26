<?php

namespace App\Http\Controllers;

use App\Helpers\ConstantHelper;
use App\Models\BarangModel;
use App\Models\DbarangMasukModel;
use App\Models\DetailBarangModel;
use App\Models\DPurchaseOrderModel;
use App\Models\HbarangMasukModel;
use App\Models\HPurchaseOrderModel;
use App\Models\SupplierModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barang = BarangModel::all();
        $supplier = SupplierModel::all();

        $purchaseOrders = HPurchaseOrderModel::where('status_penerimaan', '!=', ConstantHelper::STATUS_PENERIMAAN_SUDAHTUNTAS)->get();
        return view('barang_masuk.index', compact([
            'barang',
            'supplier',
            'purchaseOrders'
        ]));
    }

    // public function store(Request $request)
    // {
    //     $nota = $this->createNoNota();
    //     $request->validate([
    //         'po_id' => 'required',
    //         'barang_ids' => 'required|array',
    //         'jumlah_datang' => 'required|array',
    //         'exps' => 'required|array',
    //         'hargas' => 'required|array',
    //         'hargas.*' => 'numeric|min:0',
    //     ]);


    //     DB::beginTransaction();

    //     try {
    //         // create hbarang_masuk
    //         $hmasuk = HbarangMasukModel::create([
    //             'barangmasuk_nota' => $nota,
    //             'mengetahui' => $request->mengetahui,
    //             'po_id' => $request->po_id,
    //             'created_by' => Auth::user()->id
    //         ]);

    //         $stokBaru = [];

    //         // create dbarang_masuk
    //         foreach ($request->barang_ids as $key => $value) {
    //             $dbarang = DbarangMasukModel::create([
    //                 'hbarang_masuk' => $hmasuk->id,
    //                 'barang_id' => $value,
    //                 'barangmasuk_jumlah' => $request->jumlah_datang[$key],
    //                 'barangmasuk_harga' => $request->hargas[$key],
    //                 'exp' => $request->exps[$key]
    //             ]);
    //         }

    //         //create detail_barang
    //         foreach ($request->barang_ids as $key => $value) {
    //             $barang = BarangModel::find($value);
    //             $noBatch = Carbon::parse($request->exps[$key])->format('Ymd') . '-' . Str::random(4);
    //             $detail_barang = DetailBarangModel::create([
    //                 'barang_id' => $value,
    //                 'harga_beli' => $request->hargas[$key],
    //                 'harga_jual' => $barang->barang_harga,
    //                 'batch' => $noBatch,
    //                 'exp_date' => $request->exps[$key],
    //                 'stok' => $request->jumlah_datang[$key],
    //                 'status' => ConstantHelper::STATUS_DETAIL_BARANG_ADA
    //             ]);
    //             $stokBaru[$value] = ($stokBaru[$value] ?? 0) + $request->jumlah_datang[$key];
    //         }

    //         foreach ($stokBaru as $idBarang => $jumlah) {
    //             BarangModel::where('id', $idBarang)->increment('stok', $jumlah);
    //         }

    //         DB::commit();
    //         return redirect()->back()->with('success', 'Berhasil menambahkan transaksi!');
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()
    //             ->with('danger', 'Error! Hubungi tim IT!' . $e->getMessage());
    //     }
    // }

    public function store(Request $request)
    {
        $nota = $this->createNoNota();
        $request->validate([
            'po_id' => 'required',
            'barang_ids' => 'required|array',
            'jumlah_datang' => 'required|array',
            'exps' => 'required|array',
            'hargas' => 'required|array',
            'hargas.*' => 'numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Buat header transaksi
            $hmasuk = HbarangMasukModel::create([
                'barangmasuk_nota' => $nota,
                'mengetahui' => $request->mengetahui,
                'po_id' => $request->po_id,
                'created_by' => Auth::user()->id
            ]);

            $stokBaru = [];

            foreach ($request->barang_ids as $key => $barangId) {
                $jumlah = $request->jumlah_datang[$key];
                $harga = $request->hargas[$key];
                $exp = $request->exps[$key];

                // Simpan detail barang masuk
                DbarangMasukModel::create([
                    'hbarang_masuk' => $hmasuk->id,
                    'barang_id' => $barangId,
                    'barangmasuk_jumlah' => $jumlah,
                    'barangmasuk_harga' => $harga,
                    'exp' => $exp
                ]);

                // Ambil data barang
                $barang = BarangModel::find($barangId);
                $noBatch = Carbon::parse($exp)->format('Ymd') . '-' . Str::random(4);

                // Simpan ke detail stok/batch
                DetailBarangModel::create([
                    'barang_id' => $barangId,
                    'harga_beli' => $harga,
                    'harga_jual' => $barang->barang_harga,
                    'batch' => $noBatch,
                    'exp_date' => $exp,
                    'stok' => $jumlah,
                    'status' => ConstantHelper::STATUS_DETAIL_BARANG_ADA
                ]);

                $stokBaru[$barangId] = ($stokBaru[$barangId] ?? 0) + $jumlah;

                $detailPO = DPurchaseOrderModel::where('hpo_id', $request->po_id)
                    ->where('barang_id', $barangId)
                    ->first();

                if ($detailPO) {
                    $detailPO->increment('dpo_jumlahbarang_terima', $jumlah);

                    $detailPO->refresh();

                    if ($detailPO->dpo_jumlahbarang > $detailPO->dpo_jumlahbarang_terima) {
                        $detailPO->update(['status' => ConstantHelper::STATUS_DETAIL_PO_BELUM_TUNTAS]);
                    } else {
                        $detailPO->update(['status' => ConstantHelper::STATUS_DETAIL_PO_SUDAH_TUNTAS]);
                    }
                }
            }

            foreach ($stokBaru as $idBarang => $jumlah) {
                BarangModel::where('id', $idBarang)->increment('barang_stok', $jumlah);
            }

            $totalItem = DPurchaseOrderModel::where('hpo_id', $request->po_id)->count();
            $totalTuntas = DPurchaseOrderModel::where('hpo_id', $request->po_id)
                ->where('status', ConstantHelper::STATUS_DETAIL_PO_SUDAH_TUNTAS)
                ->count();

            if ($totalItem === $totalTuntas) {
                HPurchaseOrderModel::find($request->po_id)
                    ->update(['status_penerimaan' => ConstantHelper::STATUS_PENERIMAAN_SUDAHTUNTAS]);
            } else {
                HPurchaseOrderModel::find($request->po_id)
                    ->update(['status_penerimaan' => ConstantHelper::STATUS_PENERIMAAN_DITERIMASEBAGIAN]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Berhasil menambahkan transaksi!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('danger', 'Error! Hubungi tim IT! ' . $e->getMessage());
        }
    }



    public function getHargaBarang(Request $request)
    {
        $barang = BarangModel::find($request->id);

        if ($barang) {
            return response()->json(['success' => true, 'harga' => $barang->barang_harga, 'stok' => $barang->barang_stok]);
        }

        return response()->json(['success' => false]);
    }

    public function getDetailBarang(Request $request)
    {
        $po = HPurchaseOrderModel::with('dpo.barang')->find($request->id);

        if (!$po) {
            return response()->json(['success' => false]);
        }

        $details = $po->dpo->map(function ($item) {
            return [
                'barang_id' => $item->barang_id,
                'nama_barang' => $item->barang->barang_nama ?? '-',
                'jumlah' => $item->dpo_jumlahbarang,
                'harga' => $item->dpo_harga,
                'jumlah_barangditerima' => $item->dpo_jumlahbarang_terima,
                'total_harga' => $item->dpo_totalharga
            ];
        });

        return response()->json([
            'success' => true,
            'details' => $details
        ]);
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

    public function updateStokBarang($barangId)
    {
        $totalStok = DetailBarangModel::where('barang_id', $barangId)->sum('stok');
        BarangModel::where('id', $barangId)->update(['stok' => $totalStok]);
    }
}
