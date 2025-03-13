<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes, LogsActivity, HasFactory;

    protected $activityLogType = 'transaction';
    protected $activityLogModule = 'purchase';

    protected $fillable = [
        'invoice_number',
        'supplier_id',
        'user_id',
        'date',
        'total_amount',
        'notes'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}
