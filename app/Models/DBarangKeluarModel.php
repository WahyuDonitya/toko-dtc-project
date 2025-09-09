<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DBarangKeluarModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dbarang_keluar';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'barangkeluar_id',
        'barang_id',
        'jumlah',
        'exp_date',
        'status_terima'
    ];

    /**
     * Get the barang that owns the DBarangKeluarModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(BarangModel::class, 'barang_id', 'id');
    }
}
