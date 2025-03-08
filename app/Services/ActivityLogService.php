<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    /**
     * Log aktivitas manual (tidak terkait dengan model tertentu)
     */
    public static function log($type, $module, $action, $description, $referenceId = null, $referenceType = null, $beforeData = null, $afterData = null)
    {
        return ActivityLog::create([
            'user_id' => Auth::id() ?? null,
            'type' => $type,
            'module' => $module,
            'action' => $action,
            'description' => $description,
            'before_data' => $beforeData,
            'after_data' => $afterData,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'reference_id' => $referenceId,
            'reference_type' => $referenceType
        ]);
    }

    /**
     * Log aktivitas login pengguna
     */
    public static function logLogin($user)
    {
        return self::log(
            'auth',
            'user',
            'login',
            "User {$user->name} telah login ke sistem",
            $user->id,
            get_class($user)
        );
    }

    /**
     * Log aktivitas logout pengguna
     */
    public static function logLogout($user)
    {
        return self::log(
            'auth',
            'user',
            'logout',
            "User {$user->name} telah logout dari sistem",
            $user->id,
            get_class($user)
        );
    }

    /**
     * Log aktivitas kegagalan login 
     */
    public static function logFailedLogin($email)
    {
        return self::log(
            'auth',
            'user',
            'failed_login',
            "Percobaan login gagal untuk email {$email}"
        );
    }

    /**
     * Log aktivitas stok masuk
     */
    public static function logStockIn($product, $quantity, $source, $sourceId)
    {
        $beforeStock = $product->stock - $quantity;
        $afterStock = $product->stock;

        return self::log(
            'inventory',
            'stock',
            'stock_in',
            "Stok masuk {$quantity} untuk produk {$product->name}, stok sekarang {$afterStock}",
            $product->id,
            get_class($product),
            ['before_stock' => $beforeStock, 'source' => $source, 'source_id' => $sourceId],
            ['after_stock' => $afterStock, 'quantity' => $quantity]
        );
    }

    /**
     * Log aktivitas stok keluar
     */
    public static function logStockOut($product, $quantity, $source, $sourceId)
    {
        $beforeStock = $product->stock + $quantity;
        $afterStock = $product->stock;

        return self::log(
            'inventory',
            'stock',
            'stock_out',
            "Stok keluar {$quantity} untuk produk {$product->name}, stok sekarang {$afterStock}",
            $product->id,
            get_class($product),
            ['before_stock' => $beforeStock, 'source' => $source, 'source_id' => $sourceId],
            ['after_stock' => $afterStock, 'quantity' => $quantity]
        );
    }

    /**
     * Log aktivitas pembayaran
     */
    public static function logPayment($sale, $amount, $method, $status)
    {
        return self::log(
            'sales',
            'payment',
            'payment_received',
            "Pembayaran diterima sebesar Rp " . number_format($amount, 0, ',', '.') . " untuk faktur {$sale->invoice_number} dengan metode {$method}",
            $sale->id,
            get_class($sale),
            ['before_status' => $sale->getOriginal('payment_status')],
            [
                'after_status' => $status,
                'amount' => $amount,
                'method' => $method,
                'remaining' => $sale->remaining_amount
            ]
        );
    }

    /**
     * Mendapatkan log aktifitas terbaru
     */
    public static function getLatestLogs($limit = 10)
    {
        return ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Mendapatkan log aktifitas berdasarkan filter
     */
    public static function getFilteredLogs($filters, $perPage = 15)
    {
        $query = ActivityLog::with('user');

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['module'])) {
            $query->where('module', $filters['module']);
        }

        if (!empty($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }

        if (!empty($filters['search'])) {
            $query->where('description', 'like', '%' . $filters['search'] . '%');
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }
}
