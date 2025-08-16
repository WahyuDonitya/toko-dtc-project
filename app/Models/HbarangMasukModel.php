<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class HbarangMasukModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hbarang_masuk';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'barangmasuk_nota',
        'supplier_id',
        'mengetahui',
        'po_id',
        'created_by'
    ];

    /**
     * Get the Po that owns the HbarangMasukModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Po(): BelongsTo
    {
        return $this->belongsTo(HPurchaseOrderModel::class, 'po_id', 'id');
    }
}
