<?php

use Illuminate\Database\Seeder;

class SocialiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('socialite')->insert([
            'name' => 'fitbook',
        ]);

        DB::table('socialite')->insert([
            'name' => 'facebook',
        ]);

        DB::table('socialite')->insert([
            'name' => 'twitter',
        ]);

        DB::table('socialite')->insert([
            'name' => 'gmail',
        ]);
    }
}
