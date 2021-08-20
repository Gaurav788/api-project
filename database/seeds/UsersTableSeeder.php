<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::updateOrCreate(['email' => 'main_user@mailinator.com'], [
            'first_name' => 'Main',
            'last_name' => 'User',
            'email' => 'main_user@mailinator.com',
            'password' => bcrypt('main@user'),
            'social_type' => 'Website', 
            'remember_token' => Str::random(10), 
            'social_id' => 0,
            'status' => 1
        ]);
        $role = Role::updateOrCreate(['name' => 'Administrator']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        //create User role
        $user = User::updateOrCreate(['email' => 'demo_user@mailinator.com'], [
            'first_name' => 'Demo',
            'last_name' => 'User',
            'email' => 'demo_user@mailinator.com',
            'password' => bcrypt('demo@user'),
            'social_type' => 'Website', 
            'remember_token' => Str::random(10), 
            'social_id' => 0,
            'status' => 1
        ]);
        $role = Role::updateOrCreate(['name' => 'User']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

    }
}