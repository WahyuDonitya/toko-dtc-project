<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = BarangModel::all();
        return view('barang.index', compact([
            'barang'
        ]));
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
        ]);

        DB::beginTransaction();

        try {

            $data = BarangModel::create([
                'barang_nama' => $request->barang_nama,
                'barang_barcode' => $request->barang_barcode,
                'barang_stok' => 0
            ]);

            if ($data) {
                DB::commit();
                return redirect()->back()->with('success', 'Berhasil menambahkan barang');
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
}
