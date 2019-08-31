<?php

use Illuminate\Database\Seeder;

class UserRolesPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_group_permissions')->insert([
            'user_group_id' => "1",
            'permission_id' => "1",
        ]);
    }
}
