<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class ActivityLogPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat permission untuk log aktivitas
        $permissions = [
            ['name' => 'Lihat Log Aktivitas', 'slug' => 'view_activity_logs'],
            ['name' => 'Hapus Log Aktivitas', 'slug' => 'delete_activity_logs'],
            ['name' => 'Ekspor Log Aktivitas', 'slug' => 'export_activity_logs'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['slug' => $permission['slug']],
                ['name' => $permission['name']]
            );
        }

        // Tambahkan permission ke role admin (jika tersedia)
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $permissions = Permission::whereIn('slug', [
                'view_activity_logs',
                'delete_activity_logs',
                'export_activity_logs',
            ])->get();

            $adminRole->permissions()->syncWithoutDetaching($permissions);
        }
    }
}
