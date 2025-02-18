<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $suppliers = SupplierModel::query();

            return DataTables::eloquent($suppliers)
                ->addIndexColumn()
                ->addColumn('action', function ($supplier) {
                    return '
                    <a href="' . route('supplier.show', $supplier->id) . '" class="btn btn-sm btn-primary"
                        title="Lihat Detail">
                        <i class="bx bx-show"></i>
                    </a>
                    <a href="' . route('supplier.edit', $supplier->id) . '" class="btn btn-sm btn-success"
                        title="Edit">
                        <i class="bx bx-edit"></i>
                    </a>
                    <button class="btn btn-sm btn-danger delete-supplier" data-id="' . $supplier->id . '"><i class="bx bx-trash"></i></button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('supplier.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_nama' => 'required',
            'supplier_telpon' => 'required',
            'supplier_alamat' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $supp = SupplierModel::create([
                'supplier_nama' => $request->supplier_nama,
                'supplier_telpon' => $request->supplier_telpon,
                'supplier_alamat' => $request->supplier_alamat,
                'supplier_tempo' => $request->supplier_tempo,
                'sales_nama' => $request->sales_nama,
                'sales_phone' => $request->sales_telpon
            ]);
            DB::commit();
            return redirect()->route('supplier.index')->with('success', 'Berhasil menambahkan Supplier!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan Supplier!');
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
        $supplier = SupplierModel::find($id);
        return view('supplier.create', compact([
            'supplier'
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'supplier_nama' => 'required',
            'supplier_telpon' => 'required',
            'supplier_alamat' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $supp = SupplierModel::find($id);
            $supp->update([
                'supplier_nama' => $request->supplier_nama,
                'supplier_telpon' => $request->supplier_telpon,
                'supplier_alamat' => $request->supplier_alamat,
                'supplier_tempo' => $request->supplier_tempo,
                'sales_nama' => $request->sales_nama,
                'sales_phone' => $request->sales_telpon
            ]);
            DB::commit();
            return redirect()->route('supplier.index')->with('success', 'Berhasil melakukan edit supplier!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal melakukann edit supplier!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $data = SupplierModel::find($id)->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Berhasil hapus Data!']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'failed', 'message' => 'Gagal hapus Data!']);
        }
    }
}
