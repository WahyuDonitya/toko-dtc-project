<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DPurchaseOrderModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'd_purchaseorder';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'hpo_id',
        'barang_id',
        'dpo_jumlahbarang',
        'dpo_jumlahbarang_terima',
        'dpo_harga',
        'dpo_totalharga',
        'status'
    ];

    /**
     * Get the Barang that owns the dPurchaseOrderModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Barang(): BelongsTo
    {
        return $this->belongsTo(BarangModel::class, 'barang_id', 'id');
    }
}
