<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'module_settinguserprivilage',
            'module_barang',
            'module_supplier',
            'module_barangmasuk',
            'module_purchaseorder',
            'module_penerimaanbarang'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $ownerRole = Role::firstOrCreate(['name' => 'owner']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Berikan semua permissions kepada owner
        $ownerRole->syncPermissions(Permission::all());

        $user = User::find(1);
        if ($user) {
            $user->assignRole('owner');
        }
    }
}
