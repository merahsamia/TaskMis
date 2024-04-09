<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        //$this->call(LaratrustSeeder::class);

        $users = public_path('sqls/users.sql');
        DB::unprepared(file_get_contents($users));
        $this->command->info('Users table seeded');

        $departments = public_path('sqls/departments.sql');
        DB::unprepared(file_get_contents($departments));
        $this->command->info('Departments table seeded');
        
        $permissions = public_path('sqls/permissions.sql');
        DB::unprepared(file_get_contents($permissions));
        $this->command->info('Permissions table seeded');
        
        $roles = public_path('sqls/roles.sql');
        DB::unprepared(file_get_contents($roles));
        $this->command->info('Roles table seeded');
        
        $permission_user = public_path('sqls/permission_user.sql');
        DB::unprepared(file_get_contents($permission_user));
        $this->command->info('Permission_User table seeded');
        
        $role_user = public_path('sqls/role_user.sql');
        DB::unprepared(file_get_contents($role_user));
        $this->command->info('Role_User table seeded');
        
       
        
    }
}
