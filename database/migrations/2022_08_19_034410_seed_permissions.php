<?php

declare(strict_types=1);

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $admin = Role::create(['name' => 'admin']);

        $admin->givePermissionTo([
            Permission::create(['name' => 'view.admin-page']),

            // Users
            Permission::create(['name' => 'users.view.any']),
            Permission::create(['name' => 'users.create']),
            Permission::create(['name' => 'users.update.any']),
            Permission::create(['name' => 'users.delete.any']),
        ]);
    }
};