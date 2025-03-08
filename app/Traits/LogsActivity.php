<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        // Log saat membuat data baru
        static::created(function ($model) {
            $model->logActivity('create');
        });

        // Log saat mengupdate data
        static::updated(function ($model) {
            $model->logActivity('update');
        });

        // Log saat menghapus data
        static::deleted(function ($model) {
            $model->logActivity('delete');
        });

        // Log saat restore data (jika menggunakan SoftDeletes)
        if (method_exists(static::class, 'restored')) {
            static::restored(function ($model) {
                $model->logActivity('restore');
            });
        }
    }

    // Metode untuk mencatat aktivitas
    public function logActivity($action)
    {
        // Mendapatkan nama model
        $modelName = class_basename($this);

        // Mendapatkan data sebelum dan sesudah perubahan
        $beforeData = $action === 'update' ? $this->getOriginal() : null;
        $afterData = $action === 'delete' ? null : $this->getAttributes();

        // Membuat deskripsi aktivitas
        $description = $this->getActivityDescription($action, $modelName);

        // Membuat log aktivitas
        ActivityLog::create([
            'user_id' => Auth::id() ?? null,
            'type' => $this->getActivityLogType(), // Implementasikan di model
            'module' => $this->getActivityLogModule(), // Implementasikan di model
            'action' => $action,
            'description' => $description,
            'before_data' => $beforeData,
            'after_data' => $afterData,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'reference_id' => $this->id,
            'reference_type' => get_class($this)
        ]);
    }

    // Dapatkan tipe log aktivitas (dapat dioverride di Model)
    public function getActivityLogType()
    {
        return property_exists($this, 'activityLogType') ? $this->activityLogType : 'system';
    }

    // Dapatkan modul log aktivitas (dapat dioverride di Model)
    public function getActivityLogModule()
    {
        return property_exists($this, 'activityLogModule') ? $this->activityLogModule : strtolower(class_basename($this));
    }

    // Dapatkan deskripsi log aktivitas (dapat dioverride di Model)
    protected function getActivityDescription($action, $modelName)
    {
        $userId = Auth::id() ?? 'System';
        $userName = Auth::user() ? Auth::user()->name : 'System';
        $modelId = $this->id;

        $descriptions = [
            'create' => "{$userName} telah membuat {$modelName} baru dengan ID #{$modelId}",
            'update' => "{$userName} telah memperbarui {$modelName} dengan ID #{$modelId}",
            'delete' => "{$userName} telah menghapus {$modelName} dengan ID #{$modelId}",
            'restore' => "{$userName} telah mengembalikan {$modelName} dengan ID #{$modelId}"
        ];

        return $descriptions[$action] ?? "{$userName} melakukan {$action} pada {$modelName} dengan ID #{$modelId}";
    }

    // Tambahkan method untuk logging manual
    public function logCustomActivity($action, $description = null, $beforeData = null, $afterData = null)
    {
        $modelName = class_basename($this);

        if (!$description) {
            $description = $this->getActivityDescription($action, $modelName);
        }

        ActivityLog::create([
            'user_id' => Auth::id() ?? null,
            'type' => $this->getActivityLogType(),
            'module' => $this->getActivityLogModule(),
            'action' => $action,
            'description' => $description,
            'before_data' => $beforeData,
            'after_data' => $afterData,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'reference_id' => $this->id,
            'reference_type' => get_class($this)
        ]);
    }
}
