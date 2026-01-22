<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DPenerimaanBarangModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dpenerimaan_barang_toko';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'hpenerimaan_id',
        'barang_id',
        'jumlah',
        'exp_date'
    ];
}
