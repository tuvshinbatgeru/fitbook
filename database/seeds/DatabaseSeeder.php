<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(SocialiteTableSeeder::class);
        $this->call(ClubSeeder::class);
        $this->call(WidgetSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(GenreSeeder::class);
    }
}
