<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{

    use LogsActivity;

    protected $activityLogType = 'transaction';
    protected $activityLogModule = 'stock movement';

    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'before_stock',
        'after_stock',
        'reference_type',
        'reference_id',
        'notes'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
