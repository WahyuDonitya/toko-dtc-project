<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DbarangMasukModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dbarang_masuk';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'hbarang_masuk',
        'barang_id',
        'barangmasuk_jumlah',
        'barangmasuk_harga',
        'exp'
    ];

    public function hbarangMasuk()
    {
        return $this->belongsTo(HbarangMasukModel::class, 'hbarang_masuk');
    }

    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'barang_id');
    }
}
