<?php

use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('genre')->insert([
            'name' => 'фитнесс',
            'name_en' => 'fitness',
            'icon' => 'fa-save',
            'verified' => 'Y'
        ]);

        DB::table('genre')->insert([
            'name' => 'усанд сэлэлт',
            'name_en' => 'swimming',
            'icon' => 'fa-save',
            'verified' => 'Y'
        ]);

        DB::table('genre')->insert([
            'name' => 'ёог',
            'name_en' => 'Yoga',
            'icon' => 'fa-save',
            'verified' => 'Y'
        ]);
    }
}
