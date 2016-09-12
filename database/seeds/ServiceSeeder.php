<?php

use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('service')->insert([
            'name' => 'Шүүгээ',
            'name_en' => 'Locker',
            'view_order' => 1,
            'verified' => 'Y',
        ]);

        DB::table('service')->insert([
            'name' => 'Саун',
            'name_en' => 'Sauna',
            'view_order' => 2,
            'verified' => 'Y',
        ]);

        DB::table('service')->insert([
            'name' => 'Шүршүүр',
            'name_en' => 'Shower',
            'view_order' => 3,
            'verified' => 'Y',
        ]);
    }
}
