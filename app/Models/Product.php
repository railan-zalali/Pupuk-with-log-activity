<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, HasFactory, LogsActivity;

    // Definisikan properti untuk log aktivitas
    protected $activityLogType = 'inventory';
    protected $activityLogModule = 'product';

    protected $fillable = [
        'name',
        'code',
        'description',
        'image_path',
        'category_id',
        'purchase_price',
        'selling_price',
        'stock',
        'min_stock'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
