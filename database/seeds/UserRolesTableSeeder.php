<?php

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_groups')->insert([
            'user_group_name' => "Super Admin"
        ]);
        DB::table('user_groups')->insert([
            'user_group_name' => "Admin"
        ]);
        DB::table('user_groups')->insert([
            'user_group_name' => "Agent"
        ]);

    }
}
