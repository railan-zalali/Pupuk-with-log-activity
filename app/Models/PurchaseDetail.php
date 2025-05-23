<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory, LogsActivity;

    protected $activityLogType = 'transaction';
    protected $activityLogModule = 'purchase detail';

    protected $fillable = [
        'product_id',
        'quantity',
        'purchase_price',
        'subtotal'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
