<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'id' => 1,
            'type'=>'admin',
            'name'=>'admin',
            'gender'=>'male',
            'age' => 'nine',
            'password'=> Hash::make('P@ss1234')
        ]);


        $this->call([
            CategoriesSeeder::class,
            QuestionsSeeder::class,
            CoursesSeeder::class,
        ]);
    }
}
