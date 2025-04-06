<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'baranngmasuk_detailsupplier'
    ];
}
