<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\Ingredient;

class IngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ingredients = ['potato', 'hamburger', 'broccoli', 'cucumber', 'lettuce', 'cheese', 'almonds', 'fish', 'minced meat', 'chicken', 'beef', 'onion', 
        'macaroni', 'rice', 'tagliatelli', 'chocolate', 'paprika', 'tomato', 'tomatosauce', 'pepper', 'chorizo', 'milk', 'egg', 'soy milk', 'cream', 
        'curry', 'syrup', 'flour', 'apple', 'garlic', 'peas', 'coffee', 'leek', 'oatmeal', 'sugar', 'butter', 'oil', 'chili', 'salse', 'bacon', 'pork'];
        foreach($ingredients as $ingredient){
            DB::table('ingredients')->insert([
                'name' => $ingredient,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'category_id' => rand(1, Category::count()),
            ]);
        }

        for($i = 0 ; $i < 30 ; $i++){
            DB::table('ingredients_supply')->insert([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_id' => rand(1, User::count()),
                'ingredient_id' => rand(1, Ingredient::count()),
                'amount' => rand(1, 8),
            ]);
        }

        // For admin testing
        for($i = 0 ; $i < count($ingredients) ; $i++){
            DB::table('ingredients_supply')->insert([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_id' => 11,
                'ingredient_id' => $i+1,
                'amount' => 10,
            ]);
        }
    }
}
