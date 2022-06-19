<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password'  =>  \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        $this->call([
            RolesAndPermissionsSeeder::class,
            ClientSeeder::class,
            ProjectSeeder::class,
            TaskSeeder::class,

        ]);

    }
}
