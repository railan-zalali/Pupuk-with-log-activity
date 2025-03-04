<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'user_id',
        'customer_id',
        'date',
        'total_amount',
        'discount',
        'paid_amount',
        'down_payment',
        'change_amount',
        'payment_method',
        'payment_status',
        'remaining_amount',
        'due_date',
        'notes'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
