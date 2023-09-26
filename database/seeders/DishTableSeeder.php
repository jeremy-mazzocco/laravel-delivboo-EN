<?php

namespace Database\Seeders;

use App\Models\Dish;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DishTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dishesData = include base_path('database/DishData.php');
        $userIncrement = 0;

        for ($i = 0; $i < 8; $i++) {

            foreach ($dishesData as $dish) {

                $dish['user_id'] += $userIncrement;
                Dish::create($dish);
                
            }

            $userIncrement += 10;
        }
    }
}
