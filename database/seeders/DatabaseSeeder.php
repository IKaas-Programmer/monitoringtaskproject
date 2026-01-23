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

        User::factory()->create([
            'name' => 'Project Manager Admin',
            'email' => 'AdminHitamPutih@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // 2. Membuat beberapa User Member (untuk ditugaskan ke Task)
        User::factory(3)->create([
            'role' => 'member'
        ]);

        // Memanggil Seeder lainnya
        $this->call([
            ProjectSeeder::class,
            TaskSeeder::class,
            CommentSeeder::class,
        ]);
    }
}