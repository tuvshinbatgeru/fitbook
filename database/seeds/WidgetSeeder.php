<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WidgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('widgets')->insert([
            'section_id' => 1,
            'content_map' => 'header-default',
            'name' => 'Толгой',
            'name_en' => 'Header',
            'price' => 10,
            'description' => 'Энгийн толгойн хэсгийн жишээ',
            'description_en' => 'Default header component as widget',
            'photo_id' => 'http://localhost/images/users/teacher_example.jpg',
            'usage_id' => 0,
            'is_default' => 'Y'
        ]);	

        DB::table('widgets')->insert([
            'section_id' => 2,
            'content_map' => 'teacher-default',
            'name' => 'Teachers collection',
            'name_en' => 'Teachers collection',
            'price' => 8,
            'description' => 'Багш нарын жагсаалт',
            'description_en' => 'Teachers widget default',
            'photo_id' => 'http://localhost/images/users/teacher_example.jpg',
            'usage_id' => 1,
            'is_default' => 'Y'
        ]);	

        DB::table('widgets')->insert([
            'section_id' => 2,
            'content_map' => 'training-default',
            'name' => 'Training collection',
            'name_en' => 'Training collection',
            'price' => 8,
            'description' => 'Багш нарын жагсаалт',
            'description_en' => 'Training widget default',
            'photo_id' => 'http://localhost/images/users/teacher_example.jpg',
            'usage_id' => 2,
            'is_default' => 'Y'
        ]);	
    }
}
