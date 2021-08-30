<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'adminhoanganh@gmail.com',
                'password' => bcrypt('123456'),
                'phone'=>'0363689258',
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'user',
                'email' => 'hoanganh@gmail.com',
                'password' => bcrypt('123456'),
                'phone'=>'0363689258',
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
        ]);
        DB::table('permissions')->insert([
            ['name' => 'list_user'],
            ['name' => 'update_user'],
            ['name' => 'delete_user'],
            ['name' => 'role_list'],
            ['name' => 'role_add'],
            ['name' => 'role_edit'],
            ['name' => 'role_delete'],
        ]);
        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'user'],
            ['name' => 'writer']
        ]);
        DB::table('user_roles')->insert([
            ['role_id' => 1,'user_id' => 1],
            ['role_id' => 2,'user_id' => 2]
        ]);
        DB::table('permission_role')->insert([
            ['permission_id' => 1, 'role_id' => 1],
            ['permission_id' => 2, 'role_id' => 1],
            ['permission_id' => 3, 'role_id' => 1],
            ['permission_id' => 4, 'role_id' => 1],
            ['permission_id' => 5, 'role_id' => 1],
        ]);
    }
}
