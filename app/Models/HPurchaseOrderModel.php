<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class HPurchaseOrderModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'h_purchaseorder';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'hpo_nota',
        'supplier_id',
        'hpo_supplierdetail',
        'hpo_sales',
        'hpo_sales_phone',
        'hpo_jumlahpembelian',
        'hpo_jumlahdibayar',
        'hpo_jumlahbelumdibayar',
        'isLunas',
        'status_penerimaan',
        'hpo_jatuhtempo',
        'created_by'
    ];

    /**
     * Get the Supplier associated with the HPurchaseOrderModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Supplier(): HasOne
    {
        return $this->hasOne(SupplierModel::class, 'id', 'supplier_id');
    }

    /**
     * Get the User associated with the HPurchaseOrderModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function User(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    /**
     * Get all of the Dpo for the HPurchaseOrderModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Dpo(): HasMany
    {
        return $this->hasMany(DPurchaseOrderModel::class, 'hpo_id', 'id');
    }
    
}
