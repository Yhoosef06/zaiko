<?php

namespace Database\Seeders;

use App\Models\ItemCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CollegeSeeder::class,
            DepartmentSeeder::class,
            RoomSeeder::class,
            ItemsCategorySeeder::class,
            BrandSeeder::class,
            ModelSeeder::class,
            SecurityQuestionSeeder::class,
            ItemSeeder::class,
            UserSeeder::class,
            // Add more seeders here
        ]);
    }
}
