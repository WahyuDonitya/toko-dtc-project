<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembayaranPo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'history_pembayaran_po';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'po_id',
        'user_id',
        'metode_pembayaran',
        'keterangan',
        'tanggal_pembayaran',
        'jumlah_bayar'
    ];
}
