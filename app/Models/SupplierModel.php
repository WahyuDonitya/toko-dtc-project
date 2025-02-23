<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'supplier';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'supplier_nama',
        'supplier_telpon',
        'supplier_alamat',
        'supplier_tempo',
        'sales_nama',
        'sales_phone'
    ];
}
