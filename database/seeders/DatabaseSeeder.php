<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            "nickname" => "admin123",
            "email" => "rtub@mail.ru",
            "password" => "rtub2!1",
            "superuser" => true,
            "birthdate" => '2020-05-05'
        ]);
    }
}
