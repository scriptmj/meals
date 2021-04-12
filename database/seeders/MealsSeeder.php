<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Meal;
use App\Models\Ingredient;
use App\Models\Category;
use App\Models\User;

class MealsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $meals = ['bacon burger', 'pasta carbonara', 'potato wedges', 'chicken teriyaki', 'jalapeno poppers', 'roast chicken', 'pulled pork', 
        'vegetable soup', 'eggs benedict', 'scotch egg', 'applesauce', 'pasta pesto', 'quesedillas', 'bami', 'nasi', 'cheeseburger', 'pancakes', 
        'honey mustard chicken', 'honey mustard ham', 'grilled salmon', 'buffalo chicken', 'rotisserie chicken', 'sugar cookies', 'feta and tomatoes'];
        foreach($meals as $meal){
            DB::table('meals')->insert([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => $meal,
                'size' => rand(1, 4),
            ]);
        }

        for($i = 0 ; $i < 50 ; $i++){
            DB::table('meals_ingredients')->insert([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'meal_id' => rand(1, Meal::count()),
                'ingredient_id' => rand(1, Ingredient::count()),
                'amount' => rand(1, 4),
            ]);
        }
        for($i = 0 ; $i < 50 ; $i++){
            DB::table('meals_categories')->insert([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'meal_id' => rand(1, Meal::count()),
                'category_id' => rand(1, Category::count()),
            ]);
        }
        for($i = 0 ; $i < 50 ; $i++){
            DB::table('meals_picked')->insert([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'meal_id' => rand(1, Meal::count()),
                'user_id' => rand(1, User::count()),
            ]);
        }
        
    }
}
