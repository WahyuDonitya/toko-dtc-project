<?php

namespace App\Http\Controllers;

use App\Helpers\ConstantHelper;
use App\Models\DBarangKeluarModel;
use App\Models\DPenerimaanBarangModel;
use App\Models\HBarangKeluarModel;
use App\Models\HPenerimaanBarangModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenerimaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penerimaan = HBarangKeluarModel::where('status', ConstantHelper::STATUS_BARANG_KELUAR_DIKIRIM)->get();
        return view('penerimaan_toko.create', compact([
            'penerimaan'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // validasi minimal
            if (!$request->no_penerimaan || !$request->barang_id) {
                throw new \Exception('Nomor penerimaan dan detail barang wajib diisi!');
            }

            // insert header penerimaan
            $insHeader = HPenerimaanBarangModel::create([
                'created_by'      => Auth::user()->id,
                'barangkeluar_id' => $request->no_penerimaan,
                'keterangan'      => $request->keterangan,
                'penerima'        => $request->penerima
            ]);

            // loop detail yang dikirim
            foreach ($request->barang_id as $key => $b) {
                // pastikan index yang relevan ada
                $dbarangKeluarId = $request->dbarang_keluarid[$key] ?? null;
                $jumlahDatangRaw = $request->jumlah_datang[$key] ?? 0;
                $expDate = $request->exp[$key] ?? null;

                // cast ke integer
                $jumlahDatang = (int) $jumlahDatangRaw;

                if (!$dbarangKeluarId) {
                    throw new \Exception("dbarang_keluarid tidak ditemukan untuk index {$key}");
                }

                // insert detail penerimaan
                $insDPenerimaan = DPenerimaanBarangModel::create([
                    'hpenerimaan_id' => $insHeader->id,
                    'barang_id'      => $b,
                    'jumlah'         => $jumlahDatang,
                    'exp_date'       => $expDate
                ]);

                // update dbarang keluar (tambah jumlah_terima)
                $updateDkeluar = DBarangKeluarModel::find($dbarangKeluarId);
                if (!$updateDkeluar) {
                    throw new \Exception("Detail barang keluar dengan id {$dbarangKeluarId} tidak ditemukan.");
                }

                // hitung jumlah terima baru (tidak melebihi jumlah yang diminta)
                $currentTerima = (int) ($updateDkeluar->jumlah_terima ?? 0);
                $orderedQty = (int) ($updateDkeluar->jumlah ?? 0);

                $newJumlahTerima = $currentTerima + $jumlahDatang;
                if ($newJumlahTerima > $orderedQty) {
                    // jika ingin mencegah overflow: clamp ke orderedQty
                    $newJumlahTerima = $orderedQty;
                }

                // tentukan status untuk baris dkeluar ini
                $newStatus = ConstantHelper::STATUS_BARANG_KELUAR_DITERIMA_KURANG;
                if ($newJumlahTerima >= $orderedQty) {
                    $newStatus = ConstantHelper::STATUS_BARANG_KELUAR_DITERIMA;
                }

                $updateDkeluar->update([
                    'jumlah_terima' => $newJumlahTerima,
                    'status_terima' => $newStatus
                ]);
            }

            // setelah semua detail diupdate, cek keseluruhan header barang keluar
            $barangKeluarId = $request->no_penerimaan;
            // ambil semua detail untuk header barang keluar tersebut
            $allDetails = DBarangKeluarModel::where('barangkeluar_id', $barangKeluarId)->get();

            // jika semua status_terima == STATUS_BARANG_KELUAR_DITERIMA maka update header
            $allReceived = $allDetails->every(function ($d) {
                return $d->status_terima == ConstantHelper::STATUS_BARANG_KELUAR_DITERIMA;
            });

            if ($allReceived) {
                // pastikan model header barang keluar benar (sesuaikan nama model kalau berbeda)
                $hBarangKeluar = HBarangKeluarModel::find($barangKeluarId);
                if ($hBarangKeluar) {
                    $hBarangKeluar->update([
                        'status' => ConstantHelper::STATUS_BARANG_KELUAR_DITERIMA
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Berhasil membuat transaksi!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('danger', $e->getMessage());
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getdetail(Request $request)
    {
        $id = $request->id;
        $detail_penerimaan = DBarangKeluarModel::where('barangkeluar_id', $id)->with('barang')->get();

        if (!$detail_penerimaan) {
            return response()->json(['success' => false, 'message' => 'tidak ada barang!']);
        }

        return response()->json([
            'success' => true,
            'details' => $detail_penerimaan
        ]);
    }
}
