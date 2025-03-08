<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Menampilkan daftar log aktivitas
     */
    public function index(Request $request)
    {
        // Cek apakah user memiliki permission untuk melihat log
        if (!auth()->user()->hasPermission('view_activity_logs')) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $filters = $request->only(['type', 'module', 'action', 'user_id', 'start_date', 'end_date', 'search']);
        $logs = ActivityLogService::getFilteredLogs($filters);

        // Data untuk dropdown filter
        $types = ActivityLog::distinct('type')->pluck('type');
        $modules = ActivityLog::distinct('module')->pluck('module');
        $actions = ActivityLog::distinct('action')->pluck('action');
        $users = User::all();

        return view('activity_logs.index', compact('logs', 'filters', 'types', 'modules', 'actions', 'users'));
    }

    /**
     * Menampilkan detail log aktivitas
     */
    public function show(ActivityLog $activityLog)
    {
        // Cek apakah user memiliki permission untuk melihat log
        if (!auth()->user()->hasPermission('view_activity_logs')) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return view('activity_logs.show', compact('activityLog'));
    }

    /**
     * Menghapus log aktivitas (hanya untuk admin)
     */
    public function destroy(ActivityLog $activityLog)
    {
        // Cek apakah user memiliki permission untuk menghapus log
        if (!auth()->user()->hasPermission('delete_activity_logs')) {
            return redirect()->route('activity_logs.index')->with('error', 'Anda tidak memiliki izin untuk menghapus log aktivitas.');
        }

        $activityLog->delete();

        return redirect()->route('activity_logs.index')->with('success', 'Log aktivitas berhasil dihapus.');
    }

    /**
     * Menghapus semua log aktivitas (hanya untuk admin)
     */
    public function destroyAll(Request $request)
    {
        // Cek apakah user memiliki permission untuk menghapus log
        if (!auth()->user()->hasPermission('delete_activity_logs')) {
            return redirect()->route('activity_logs.index')->with('error', 'Anda tidak memiliki izin untuk menghapus log aktivitas.');
        }

        // Konfirmasi penghapusan dengan password
        if (!auth()->validate(['email' => auth()->user()->email, 'password' => $request->password])) {
            return redirect()->route('activity_logs.index')->with('error', 'Password yang Anda masukkan salah.');
        }

        ActivityLog::truncate();

        return redirect()->route('activity_logs.index')->with('success', 'Semua log aktivitas berhasil dihapus.');
    }

    /**
     * Mengekspor log aktivitas ke CSV
     */
    public function export(Request $request)
    {
        // Cek apakah user memiliki permission untuk mengekspor log
        if (!auth()->user()->hasPermission('export_activity_logs')) {
            return redirect()->route('activity_logs.index')->with('error', 'Anda tidak memiliki izin untuk mengekspor log aktivitas.');
        }

        $filters = $request->only(['type', 'module', 'action', 'user_id', 'start_date', 'end_date', 'search']);
        $logs = ActivityLogService::getFilteredLogs($filters, 1000); // Batasi maksimal 1000 baris

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="activity_logs_' . date('Y-m-d') . '.csv"',
        ];

        $columns = ['ID', 'Waktu', 'Pengguna', 'Tipe', 'Modul', 'Aksi', 'Deskripsi', 'IP Address'];

        $callback = function () use ($logs, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($logs as $log) {
                $row = [
                    $log->id,
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->user ? $log->user->name : 'System',
                    $log->type,
                    $log->module,
                    $log->action,
                    $log->description,
                    $log->ip_address
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
