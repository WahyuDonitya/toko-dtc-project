<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barang = BarangModel::all();
        return view('barang_masuk.index', compact([
            'barang'
        ]));
    }
}
