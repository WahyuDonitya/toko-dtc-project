<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HPenerimaanBarangModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hpenerimaan_barang_toko';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'created_by',
        'barangkeluar_id',
        'keterangan',
        'penerima'
    ];
}
