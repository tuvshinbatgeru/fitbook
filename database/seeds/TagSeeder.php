<?php

use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tags')->insert([
            'name' => 'сургалт',
            'name_en' => 'training',
        ]);

        DB::table('tags')->insert([
            'name' => 'хөтөлбөр',
            'name_en' => 'plan',
        ]);

        DB::table('tags')->insert([
            'name' => 'нүүр зураг',
            'name_en' => 'profile',
        ]);
    }
}
