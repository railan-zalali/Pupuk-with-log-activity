<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ActivityLog;
use Carbon\Carbon;

class CleanupOldActivityLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:cleanup {--days=90 : Jumlah hari log yang dipertahankan}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membersihkan log aktivitas yang sudah lama';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Ambil jumlah hari dari opsi
        $days = $this->option('days');

        // Hitung tanggal batas
        $cutoffDate = Carbon::now()->subDays($days);

        // Ambil jumlah log yang akan dihapus
        $count = ActivityLog::where('created_at', '<', $cutoffDate)->count();

        if ($count > 0) {
            // Konfirmasi penghapusan
            if ($this->confirm("Apakah Anda yakin ingin menghapus {$count} log aktivitas yang lebih lama dari {$days} hari?")) {
                // Hapus log yang lebih lama dari tanggal batas
                $deleted = ActivityLog::where('created_at', '<', $cutoffDate)->delete();

                $this->info("Berhasil menghapus {$deleted} log aktivitas.");
            } else {
                $this->info('Operasi dibatalkan.');
            }
        } else {
            $this->info("Tidak ada log aktivitas yang lebih lama dari {$days} hari.");
        }

        return 0;
    }
}
