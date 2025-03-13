<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory, LogsActivity;

    protected $activityLogType = 'master data';
    protected $activityLogModule = 'Supplier';

    protected $fillable = [
        'name',
        'phone',
        'address',
        'description'
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
