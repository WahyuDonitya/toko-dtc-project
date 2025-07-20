<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailBarangModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detail_barang';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'barang_id',
        'harga_beli',
        'harga_jual',
        'batch',
        'exp_date',
        'stok',
        'status'
    ];
}
