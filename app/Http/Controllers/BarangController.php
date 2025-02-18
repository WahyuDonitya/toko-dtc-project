<?php

namespace App\Http\Controllers;

use App\Imports\BarangImport;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $barangs = BarangModel::query();

            return DataTables::eloquent($barangs)
                ->addIndexColumn()
                ->addColumn('action', function ($barang) {
                    return '
                    <a href="' . route('barangs.show', $barang->id) . '" class="btn btn-sm btn-primary"
                        title="Lihat Detail">
                        <i class="bx bx-show"></i>
                    </a>
                    <a href="' . route('barangs.edit', $barang->id) . '" class="btn btn-sm btn-success"
                        title="Edit">
                        <i class="bx bx-edit"></i>
                    </a>
                    <button class="btn btn-sm btn-danger delete-barang" data-id="' . $barang->id . '"><i class="bx bx-trash"></i></button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('barang.index');
        // $barang = BarangModel::all();
        // $title = 'Hapus Barang!';
        // $text = "Apakah anda yakin ingin hapus data barang?";
        // confirmDelete($title, $text);
        // return view('barang.index', compact([
        //     'barang'
        // ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'barang_nama' => 'required',
            'barang_barcode' => 'required',
            "barang_harga" => 'required',
            "barang_het" => 'required'
        ]);

        DB::beginTransaction();

        try {

            $data = BarangModel::create([
                'barang_nama' => $request->barang_nama,
                'barang_barcode' => $request->barang_barcode,
                'barang_stok' => 0,
                'barang_harga' => $request->barang_harga,
                'het' => $request->barang_het
            ]);

            if ($data) {
                DB::commit();
                return redirect()->route('barangs.index')->with('success', 'Berhasil menambahkan barang');
            } else {
                DB::rollBack();
                return redirect()->back()->with('danger', 'Gagal membuat barang, hubungi IT!');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('danger', 'Gagal membuat barang, hubungi IT!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barang = BarangModel::find($id);
        return view('barang.create', compact([
            'barang'
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "barang_nama" => 'required',
            "barang_barcode" => 'required',
            "barang_harga" => 'required',
            "barang_het" => 'required'
        ]);

        DB::beginTransaction();

        try {
            $barang = BarangModel::find($id);

            $barang->update([
                'barang_nama' => $request->barang_nama,
                'barang_barcode' => $request->barang_barcode,
                'barang_harga' => $request->barang_harga,
                'het' => $request->barang_het
            ]);

            DB::commit();
            return redirect()->route('barangs.index')->with('success', 'Berhasil melakukan edit data!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('danger', 'Gagal melakukan edit Data!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $data = BarangModel::find($id)->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Berhasil hapus Data!']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'failed', 'message' => 'Gagal hapus Data!']);
        }
    }

    public function importView()
    {
        return view('barang.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new BarangImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data barang berhasil diimport!');
    }
}
