<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'module',
        'action',
        'description',
        'before_data',
        'after_data',
        'ip_address',
        'user_agent',
        'reference_id',
        'reference_type'
    ];

    protected $casts = [
        'before_data' => 'array',
        'after_data' => 'array',
    ];

    // Relasi dengan user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi polimorfik dengan model yang berhubungan
    public function reference()
    {
        return $this->morphTo();
    }

    // Scope untuk memfilter berdasarkan tipe aktivitas
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Scope untuk memfilter berdasarkan modul
    public function scopeOfModule($query, $module)
    {
        return $query->where('module', $module);
    }

    // Scope untuk memfilter berdasarkan aksi
    public function scopeOfAction($query, $action)
    {
        return $query->where('action', $action);
    }

    // Scope untuk memfilter berdasarkan pengguna
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Scope untuk memfilter aktivitas dalam rentang tanggal
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }
}
