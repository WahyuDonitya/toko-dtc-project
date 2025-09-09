<?php

namespace App\Http\Controllers;

use App\Helpers\ConstantHelper;
use App\Models\BarangModel;
use App\Models\DBarangKeluarModel;
use App\Models\DetailBarangModel;
use App\Models\HBarangKeluarModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $barang_keluar = HBarangKeluarModel::orderBy('created_at', 'desc')->with(['user']);

            return DataTables::eloquent($barang_keluar)
                ->addIndexColumn()
                ->addColumn('barangkeluar_nota', function ($row) {
                    return $row->barangkeluar_nota ?? '-';
                })
                ->addColumn('penanggung_jawab', function ($row) {
                    return $row->penanggung_jawab ?? '-';
                })
                ->addColumn('pembuat', function ($row) {
                    return $row->user->name ?? '-';
                })
                ->addColumn('catatan', function ($row) {
                    return $row->catatan ?? '-';
                })
                ->addColumn('created_at_format', function ($row) {
                    try {
                        return $row->created_at ? \Carbon\Carbon::parse($row->created_at)->format('d-M-Y') : '-';
                    } catch (\Exception $e) {
                        return '-';
                    }
                })
                ->addColumn('aksi', function ($row) {
                    $showUrl = route('barang-keluar.show', $row->id);
                    return '
                        <a href="' . $showUrl . '" class="btn btn-sm btn-primary">
                            <i class="bx bx-show"></i>
                        </a>
                    ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('barang_keluar.index');
    }

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
            // buat header

            $header = HBarangKeluarModel::create([
                'created_by' => Auth::user()->id,
                'barangkeluar_nota' => $this->createNoNota(),
                'penanggung_jawab' => $request->penanggung_jawab,
                'catatan' => $request->catatan,
                'status' => ConstantHelper::STATUS_BARANG_KELUAR_DIKIRIM
            ]);

            foreach ($request->barang_id as $index => $barangId) {
                $jumlah = $request->jumlah_barang[$index];

                $barang = BarangModel::where('id', $barangId)->lockForUpdate()->first();

                if (!$barang) {
                    throw new Exception("Barang dengan ID $barangId tidak ditemukan.");
                }

                if ($jumlah > $barang->barang_stok) {
                    throw new Exception("Jumlah barang keluar untuk {$barang->barang_nama} melebihi stok yang tersedia ({$barang->barang_stok}).");
                }

                if ($jumlah == 0) {
                    throw new Exception('Barang harus lebih dari 0!');
                }

                // transaksi detail barang keluar FIFO START

                $jumlahCounter = $jumlah;

                do {
                    $detail_barang = DetailBarangModel::where('barang_id', $barangId)
                        ->where('status', ConstantHelper::STATUS_DETAIL_BARANG_ADA)
                        ->whereDate('exp_date', '>', now())
                        ->orderBy('exp_date', 'asc')
                        ->lockForUpdate()
                        ->first();

                    // kondisi barang kehabisan stok
                    if (!$detail_barang) {
                        throw new Exception("Jumlah barang keluar untuk {$barang->barang_nama} tidak memiliki cukup stok, Periksa stok!");
                    }
                    // kondisi jumlah barang keluar lebih banyak dari stok yang ada
                    else if ($jumlahCounter >= $detail_barang->stok) {
                        $jumlahCounter -= $detail_barang->stok;

                        //buat detail barang keluar
                        $detail = DBarangKeluarModel::create([
                            'barangkeluar_id' => $header->id,
                            'barang_id' => $barangId,
                            'jumlah' => $detail_barang->stok,
                            'exp_date' => $detail_barang->exp_date,
                            'status_terima'  => ConstantHelper::STATUS_BARANG_KELUAR_DIKIRIM
                        ]);

                        $detail_barang->update([
                            'status' => ConstantHelper::STATUS_DETAIL_BARANG_HABIS,
                            'stok' => 0
                        ]);
                    }
                    // kondisi stok lebih dari jumlah keluar
                    else if ($jumlahCounter < $detail_barang->stok) {
                        $stok = $detail_barang->stok;

                        //buat detail barang keluar
                        $detail = DBarangKeluarModel::create([
                            'barangkeluar_id' => $header->id,
                            'barang_id' => $barangId,
                            'jumlah' => $jumlahCounter,
                            'exp_date' => $detail_barang->exp_date,
                            'status_terima'  => ConstantHelper::STATUS_BARANG_KELUAR_DIKIRIM
                        ]);

                        $detail_barang->update([
                            'stok' => $stok - $jumlahCounter
                        ]);

                        $jumlahCounter = 0;
                    }
                } while ($jumlahCounter > 0);

                // transaksi detail barang keluar FIFO END

                //update stok barang gudang
                $barang->update([
                    'barang_stok' => DetailBarangModel::where('barang_id', $barangId)
                        ->where('status', ConstantHelper::STATUS_DETAIL_BARANG_ADA)
                        ->sum('stok')
                ]);
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

    public function show(Request $request, $id)
    {
        $barang_keluar = HBarangKeluarModel::where('id', $id)->with(['user'])->first();

        if ($request->ajax()) {
            $dbarang_keluar = DBarangKeluarModel::where('barangkeluar_id', $id)->with(['barang']);

            return DataTables::eloquent($dbarang_keluar)
                ->addIndexColumn()
                ->addColumn('barang', function ($row) {
                    return $row->barang->barang_nama ?? '-';
                })
                ->addColumn('exp_date', function ($row) {
                    return $row->exp_date ?? '-';
                })
                ->addColumn('jumlah', function ($row) {
                    return $row->jumlah ?? '-';
                })
                ->make(true);
        }

        return view('barang_keluar.show', compact([
            'barang_keluar'
        ]));
    }

    function createNoNota()
    {
        $tanggal = Carbon::now()->format('dmy');

        $lastNota = HBarangKeluarModel::whereDate('created_at', Carbon::today())
            ->orderBy('barangkeluar_nota', 'desc')
            ->first();

        if ($lastNota) {
            $lastNumber = (int)substr($lastNota->no_nota, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        $noNota = 'BK' . $tanggal . $newNumber;

        return $noNota;
    }
}
