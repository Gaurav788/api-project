<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'role-list', 'group_name' => 'Roles'],
            ['name' => 'role-create', 'group_name' => 'Roles'],
            ['name' => 'role-edit', 'group_name' => 'Roles'],
            ['name' => 'role-delete', 'group_name' => 'Roles'],
            ['name' => 'permission-list', 'group_name' => 'Permissions'],
            ['name' => 'permission-create', 'group_name' => 'Permissions'],
            ['name' => 'permission-edit', 'group_name' => 'Permissions'],
            ['name' => 'permission-delete', 'group_name' => 'Permissions'],
            ['name' => 'user-list', 'group_name' => 'Users'],
            ['name' => 'user-create', 'group_name' => 'Users'],
            ['name' => 'user-edit', 'group_name' => 'Users'],
            ['name' => 'user-delete', 'group_name' => 'Users'],
            ['name' => 'smtp-list', 'group_name' => 'SMTP Details'],
            ['name' => 'smtp-create', 'group_name' => 'SMTP Details'],
            ['name' => 'smtp-edit', 'group_name' => 'SMTP Details'],
            ['name' => 'smtp-delete', 'group_name' => 'SMTP Details'],
            ['name' => 'responder-list', 'group_name' => 'Autoresponder Templates'],
            ['name' => 'responder-create', 'group_name' => 'Autoresponder Templates'],
            ['name' => 'responder-edit', 'group_name' => 'Autoresponder Templates'],
            ['name' => 'responder-delete', 'group_name' => 'Autoresponder Templates'],
            ['name' => 'emaillogs-list', 'group_name' => 'Email Logs'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission['name'], 'group_name' => $permission['group_name']]);
        }
    }
}