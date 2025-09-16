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
        $this->call(CategorySeeder::class);

        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Risa Nurfitriah',
        //     'email' => 'nurfitriahrisa@gmail.com',
        //     'phone' => '088555666111',
        //     'password' => 'risa1234',
        //     'role' => 'admin',
        // ]);
    }
}
