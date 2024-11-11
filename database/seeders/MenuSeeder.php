<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create(['name' => 'Home', 'url' => '/', 'order' => 1]);
        Menu::create(['name' => 'About', 'url' => '/about', 'order' => 2]);
        Menu::create(['name' => 'Services', 'url' => '/services', 'order' => 3]);
        Menu::create(['name' => 'Contact', 'url' => '/contact', 'order' => 4]);
    }
}
