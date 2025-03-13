<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\ActivityLogService;
use Symfony\Component\HttpFoundation\Response;

class LogUserActivity
{
    /**
     * Middleware untuk log aktivitas penting pengguna secara otomatis
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Proses request seperti biasa
        $response = $next($request);

        // Log hanya untuk halaman penting dan untuk pengunjung yang sudah login
        if (auth()->check() && $this->shouldLogRoute($request)) {
            $this->logUserActivity($request);
        }

        return $response;
    }

    /**
     * Tentukan apakah route perlu di-log
     */
    private function shouldLogRoute(Request $request): bool
    {
        // Array rute yang ingin di-log (bisa disesuaikan)
        $routesToLog = [
            'products.index',
            'products.create',
            'products.store',
            'products.edit',
            'products.update',
            'products.destroy',
            'sales.index',
            'sales.create',
            'sales.store',
            'sales.show',
            'sales.edit',
            'sales.update',
            'sales.destroy',
            'purchases.index',
            'purchases.create',
            'purchases.store',
            'purchases.show',
            'purchases.edit',
            'purchases.update',
            'purchases.destroy',
            'users.index',
            'users.create',
            'users.store',
            'users.edit',
            'users.update',
            'users.destroy',
            'profile.edit',
            'profile.update',
            'profile.password.update',
            'settings.index',
            'settings.update',
        ];

        // Cek apakah rute saat ini perlu dilog
        return in_array($request->route()->getName(), $routesToLog);
    }

    /**
     * Log aktivitas pengguna
     */
    private function logUserActivity(Request $request): void
    {
        $user = auth()->user();
        $routeName = $request->route()->getName();
        $method = $request->method();

        // Tentukan modul, aksi, dan tipe berdasarkan nama rute
        $routeParts = explode('.', $routeName);
        $module = $routeParts[0] ?? 'system';
        $action = $routeParts[1] ?? 'view';

        // Tipe didasarkan pada modul
        $typeMap = [
            'products' => 'inventory',
            'categories' => 'inventory',
            'suppliers' => 'inventory',
            'sales' => 'sales',
            'customers' => 'sales',
            'purchases' => 'purchase',
            'users' => 'user',
            'roles' => 'system',
            'permissions' => 'system',
            'settings' => 'system',
            'profile' => 'user',
        ];

        $type = $typeMap[$module] ?? 'system';

        // Buat deskripsi
        $description = $this->generateDescription($user, $module, $action, $request);

        // Log aktivitas
        ActivityLogService::log(
            $type,
            $module,
            $action,
            $description
        );
    }

    /**
     * Generate deskripsi berdasarkan aktivitas
     */
    private function generateDescription($user, $module, $action, $request): string
    {
        $moduleName = ucfirst($module);

        // Tentukan deskripsi berdasarkan aksi
        switch ($action) {
            case 'index':
                return "{$user->name} mengakses halaman daftar {$moduleName}";
            case 'create':
                return "{$user->name} mengakses halaman pembuatan {$moduleName} baru";
            case 'store':
                return "{$user->name} membuat data {$moduleName} baru";
            case 'show':
                $id = $request->route()->parameter(rtrim($module, 's'));
                return "{$user->name} melihat detail {$moduleName} dengan ID #{$id}";
            case 'edit':
                $id = $request->route()->parameter(rtrim($module, 's'));
                return "{$user->name} mengakses halaman edit {$moduleName} dengan ID #{$id}";
            case 'update':
                $id = $request->route()->parameter(rtrim($module, 's'));
                return "{$user->name} memperbarui data {$moduleName} dengan ID #{$id}";
            case 'destroy':
                $id = $request->route()->parameter(rtrim($module, 's'));
                return "{$user->name} menghapus data {$moduleName} dengan ID #{$id}";
            case 'password':
                if ($module === 'profile') {
                    return "{$user->name} mengubah password akunnya";
                }
                return "{$user->name} melakukan akses ke halaman {$moduleName} - {$action}";
            default:
                return "{$user->name} melakukan akses ke halaman {$moduleName} - {$action}";
        }
    }
}
