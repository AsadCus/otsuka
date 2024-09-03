<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Regency;
use App\Models\Province;
use App\Models\Role;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 10; $i++) {
            $province = Province::inRandomOrder()->first();
            $regency = Regency::where('province_id', $province->id)->inRandomOrder()->first();

            User::create([
                'name' => $faker->name,
                'role_id' => Role::inRandomOrder()->first()->id,
                'email' => $faker->email,
                'password' => Hash::make('password1'),
                'institute' => $faker->company,
                'province_id' => $province->id,
                'regency_id' => $regency->id
            ]);
        }
    }
}
