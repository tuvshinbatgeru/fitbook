<?php

use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('club')->insert([
            'club_id' => 'flexgym',
            'short_name' => 'flex Gym',
            'full_name' => 'Flex gym inc.',
            'address' => 'Самбуугийн гудамж, Улаанбаатар',
            'description' => 'Flex Gym монголын анхны 24 цаг ажилдаг. No1',
            'lat' => 47.922288,
            'lng' => 106.904515,
            'is_active' => 'Y',
        ]);

        DB::table('club')->insert([
            'club_id' => 'goldengym',
            'short_name' => 'Golden Gym',
            'full_name' => 'Golden gym inc.',
            'address' => 'Самбуугийн гудамж, Улаанбаатар',
            'description' => 'Golden Gym mongolia',
            'lat' => 47.922856,
            'lng' => 106.905620,
            'is_active' => 'Y',
        ]);

        DB::table('club')->insert([
            'club_id' => 'havai',
            'short_name' => 'Havai Fitness',
            'full_name' => 'Havai gym inc.',
            'address' => 'Самбуугийн гудамж, Улаанбаатар',
            'description' => 'Havai Gym mongolia',
            'lat' => 47.9195812,
            'lng' => 106.9017175,
            'is_active' => 'Y',
        ]);

        DB::table('club')->insert([
            'club_id' => 'strong',
            'short_name' => 'Strong Fitness',
            'full_name' => 'Strong gym inc.',
            'address' => 'Самбуугийн гудамж, Улаанбаатар',
            'description' => 'Strong Gym mongolia',
            'lat' => 47.9039120,
            'lng' => 106.9135940,
            'is_active' => 'Y', 
        ]);
    }
}
