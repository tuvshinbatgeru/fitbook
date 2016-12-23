<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('roles')->insert([
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'System admin',
            'created_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);

        DB::table('roles')->insert([
            'name' => 'manager',
            'display_name' => 'Manager',
            'description' => 'System manager',
            'created_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);

        DB::table('roles')->insert([
            'name' => 'teacher',
            'display_name' => 'Teacher',
            'description' => 'System teacher',
            'created_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);

        DB::table('roles')->insert([
            'name' => 'reception',
            'display_name' => 'reception',
            'description' => 'System reception',
            'created_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);
    }
}
