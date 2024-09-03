<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(RegProvincesTableSeeder::class);
        $this->call(RegRegenciesTableSeeder::class);
        $this->call(RegDistrictsTableSeeder::class);
        $this->call(RegVillagesTableSeeder::class);
        $this->call(UserSeeder::class);
    }
}
