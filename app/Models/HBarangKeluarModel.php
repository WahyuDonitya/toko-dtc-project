<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class HBarangKeluarModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hbarang_keluar';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'created_by',
        'barangkeluar_nota',
        'penanggung_jawab',
        'catatan',
        'status'
    ];

    /**
     * Get the user that owns the HBarangKeluarModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
