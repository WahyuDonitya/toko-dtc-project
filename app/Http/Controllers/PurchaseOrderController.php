<?php

namespace App\Http\Controllers;

use App\Helpers\ConstantHelper;
use App\Models\BarangModel;
use App\Models\DPurchaseOrderModel;
use App\Models\HPurchaseOrderModel;
use App\Models\PembayaranPo;
use App\Models\SupplierModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $po = HPurchaseOrderModel::query()->with(['Supplier', 'User'])->orderBy('created_at', 'desc');

            return DataTables::eloquent($po)
                ->addIndexColumn()
                ->addColumn('supplier_nama', function ($po) {
                    return $po->supplier ? $po->supplier->supplier_nama : '-';
                })
                ->addColumn('created_by_nama', function ($po) {
                    return $po->created_by ? $po->User->name : '-';
                })
                ->addColumn('sales_info', function ($po) {
                    return $po->hpo_sales . ' - ' . $po->hpo_sales_phone;
                })
                ->addColumn('created_at_formatted', function ($po) {
                    return $po->created_at->format('d-M-Y');
                })
                ->addColumn('hpo_jatuhtempo_formatted', function ($po) {
                    if (empty($po->hpo_jatuhtempo)) {
                        return '-';
                    }
                    if ($po->hpo_jatuhtempo instanceof \Carbon\Carbon) {
                        return $po->hpo_jatuhtempo->format('d-M-Y');
                    }
                    return \Carbon\Carbon::createFromFormat('Y-m-d', $po->hpo_jatuhtempo)->format('d-M-Y');
                })
                ->addColumn('action', function ($po) {
                    return '
                    <a href="' . route('purchase-order.show', $po->id) . '" class="btn btn-sm btn-primary"
                        title="Lihat Detail">
                        <i class="bx bx-show"></i>
                    </a>
                    ';
                })
                ->addColumn('is_lunas_badge', function ($po) {
                    if ($po->isLunas == 1) {
                        return '<span class="badge bg-success">Lunas</span>';
                    }
                    return '<span class="badge bg-warning text-dark">Belum Lunas</span>';
                })
                ->addColumn('is_penerimaan_badge', function ($po) {
                    if ($po->status_penerimaan == ConstantHelper::STATUS_PENERIMAAN_BELUMDITERIMA) {
                        return '<span class="badge bg-danger">Belum Dikirim</span>';
                    } else if ($po->status_penerimaan == ConstantHelper::STATUS_PENERIMAAN_DITERIMASEBAGIAN) {
                        return '<span class="badge bg-warning">Dikirim Sebagian</span>';
                    } else if ($po->status_penerimaan == ConstantHelper::STATUS_PENERIMAAN_SUDAHTUNTAS) {
                        return '<span class="badge bg-success">Sudah Lunas</span>';
                    }
                })
                ->filterColumn("supplier_nama", function ($query, $value) {
                    $query->whereHas("Supplier", fn ($q) => $q->where('supplier_nama', 'LIKE', "%$value%"));
                })
                ->rawColumns(['action', 'is_lunas_badge', 'is_penerimaan_badge'])
                ->make(true);
        }
        return view('purchase-order.index');
    }

    public function show($id, Request $request)
    {
        $hpo = HPurchaseOrderModel::find($id);

        // TAB: DETAIL BARANG
        if ($request->get('type') == 'details') {
            $query = DPurchaseOrderModel::with('barang')->where('hpo_id', $id);

            if ($request->ajax()) {
                return DataTables::eloquent($query)
                    ->addIndexColumn()
                    ->editColumn('barang_id', function ($item) {
                        return $item->barang->barang_nama ?? '-';
                    })
                    ->editColumn('dpo_harga', function ($item) {
                        return 'Rp ' . number_format($item->dpo_harga, 0, ',', '.');
                    })
                    ->editColumn('dpo_totalharga', function ($item) {
                        return 'Rp ' . number_format($item->dpo_totalharga, 0, ',', '.');
                    })
                    ->editColumn('status', function ($item) {
                        if ($item->status == 0) {
                            return '<span class="badge bg-danger">Belum Diterima</span>';
                        } elseif ($item->status == 1) {
                            return '<span class="badge bg-warning text-dark">Sebagian Diterima</span>';
                        } elseif ($item->status == 2) {
                            return '<span class="badge bg-success">Komplit</span>';
                        } else {
                            return '<span class="badge bg-secondary">Tidak Diketahui</span>';
                        }
                    })
                    ->rawColumns(['status'])
                    ->make(true);
            }
        }

        // TAB: RIWAYAT PEMBAYARAN
        if ($request->get('type') == 'payments') {
            $query = PembayaranPo::where('po_id', $id)->orderBy('created_at', 'desc');

            if ($request->ajax()) {
                return DataTables::eloquent($query)
                    ->addIndexColumn()
                    ->editColumn('created_at', function ($item) {
                        return \Carbon\Carbon::parse($item->created_at)->format('d-m-Y');
                    })
                    ->editColumn('jumlah_bayar', function ($item) {
                        return 'Rp ' . number_format($item->jumlah_bayar, 0, ',', '.');
                    })
                    ->make(true);
            }
        }

        return view('purchase-order.show', compact('hpo'));
    }


    public function create()
    {
        $barang = BarangModel::all();
        $supplier = SupplierModel::all();
        return view('purchase-order.create', compact([
            'barang',
            'supplier'
        ]));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier' => 'required',
            'jatuh_tempo' => 'required',
            'sales_nama' => 'required',
            'grandtotal' => 'required',
            'detail_supplier' => 'nullable|string',
            'barang_ids' => 'required|array',
            'jumlahs' => 'required|array',
            'jumlahs.*' => 'integer|min:1',
            'hargas' => 'required|array',
            'hargas.*' => 'numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with([
                    'barang_po' => [
                        'barang_ids' => $request->barang_ids ?? [],
                        'jumlahs' => $request->jumlahs ?? [],
                        'hargas' => $request->hargas ?? [],
                    ],
                    'old_supplier' => $request->supplier
                ]);
        }

        DB::beginTransaction();

        try {
            // create header
            $header = HPurchaseOrderModel::create([
                'hpo_nota' => $this->createNoNota(),
                'supplier_id' => $request->supplier,
                'hpo_supplierdetail' => $request->detail_supplier,
                'hpo_sales' => $request->sales_nama,
                'hpo_sales_phone' => $request->sales_phone,
                'hpo_jumlahpembelian' => $this->clearFormat($request->grandtotal),
                'hpo_jumlahdibayar' => 0,
                'hpo_jumlahbelumdibayar' => $this->clearFormat($request->grandtotal),
                'isLunas' => ConstantHelper::IS_LUNAS_BELUM,
                'hpo_jatuhtempo' => $request->jatuh_tempo,
                'created_by' => Auth::user()->id,
                'status_penerimaan' => ConstantHelper::STATUS_DETAIL_PO_BELUM_DITERIMA
            ]);

            // create detail
            foreach ($request->barang_ids as $key => $barang) {
                DPurchaseOrderModel::create([
                    'hpo_id' => $header->id,
                    'barang_id' => $barang,
                    'dpo_jumlahbarang' => $request->jumlahs[$key],
                    'dpo_jumlahbarang_terima' => 0,
                    'dpo_harga' => $request->hargas[$key],
                    'dpo_totalharga' => $this->clearFormat($request->totals[$key]),
                    'status' => ConstantHelper::STATUS_DETAIL_PO_BELUM_TUNTAS
                ]);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil menambahkan transaksi!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with([
                    'barang_po' => [
                        'barang_ids' => $request->barang_ids ?? [],
                        'jumlahs' => $request->jumlahs ?? [],
                        'hargas' => $request->hargas ?? [],
                    ],
                    'old_supplier' => $request->supplier,
                ])
                ->with('danger', 'Error! Hubungi tim IT!' . $e->getMessage());
        }
    }

    public function storepopayment(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'jumlah_bayar' => 'required|numeric|min:1',
            'metode_pembayaran' => 'required'
        ]);

        DB::beginTransaction();
        try {
            // Simpan pembayaran baru
            PembayaranPo::create([
                'user_id' => Auth::user()->id,
                'po_id' => $request->po_id,
                'metode_pembayaran' => $request->metode_pembayaran,
                'jumlah_bayar' => $request->jumlah_bayar,
                'tanggal_pembayaran' => $request->tanggal
            ]);

            $po = HPurchaseOrderModel::find($request->po_id);

            $jumlahdibayar = $po->hpo_jumlahdibayar;
            $jumlahpembelian = $po->hpo_jumlahpembelian;

            $total_bayar_baru = $jumlahdibayar + $request->jumlah_bayar;

            if ($total_bayar_baru > $jumlahpembelian) {
                DB::rollBack();
                return redirect()->back()->with('danger', 'Melebihi jumlah yang harus dibayar');
            }

            $jumlahbelumdibayar = $jumlahpembelian - $total_bayar_baru;

            $updateData = [
                'hpo_jumlahdibayar' => $total_bayar_baru,
                'hpo_jumlahbelumdibayar' => $jumlahbelumdibayar
            ];

            if ($total_bayar_baru == $jumlahpembelian) {
                $updateData['isLunas'] = ConstantHelper::IS_LUNAS_SUDAH;
            }

            $po->update($updateData);

            DB::commit();
            return redirect()->back()->with('open_tab', 'pembayaran')->with('success', 'Berhasil mencatat pembayaran');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('danger', 'Error Hubungi tim IT!');
        }
    }


    function createNoNota()
    {
        $tanggal = Carbon::now()->format('dmy');

        $lastNota = HPurchaseOrderModel::whereDate('created_at', Carbon::today())
            ->orderBy('hpo_nota', 'desc')
            ->first();

        if ($lastNota) {
            $lastNumber = (int)substr($lastNota->no_nota, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        $noNota = 'PO' . $tanggal . $newNumber;

        return $noNota;
    }

    function clearFormat($req)
    {
        $hasil = (int) str_replace('.', '', $req);
        return $hasil;
    }
}
