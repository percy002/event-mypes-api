<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Event::create([
            'name' => 'Evento MYPES',
            'description' => 'Evento de capacitación de MYPES',
            'start_date' => '2024-06-13 00:00:00',
            'end_date' => '2024-06-13 23:59:00'
        ]);
    }
}
