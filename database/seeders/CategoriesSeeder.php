<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Ingredient;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['dairy', 'meat', 'vegetable', 'fruit', 'pasta', 'fast food'];
        $icons = [
            'https://www.flaticon.com/svg/vstatic/svg/3496/3496925.svg?token=exp=1618390938~hmac=434c373ffaa02d47dfa2dfe21abc0fbc', 
        'https://seekicon.com/free-icon-download/food-chicken-drum-stick_1.svg', 
        'https://seekicon.com/free-icon-download/nutrition_1.svg', 
        'https://seekicon.com/free-icon-download/apple_6.svg', 
        'https://www.flaticon.com/svg/vstatic/svg/2863/2863116.svg?token=exp=1618390880~hmac=115ef837e4506391efb27d10ab0deeab', 
        'https://seekicon.com/free-icon-download/fast-food-outline_1.svg'];
        for($i = 0 ; $i < count($categories) ; $i++){
            DB::table('categories')->insert([
                'name' => $categories[$i],
                'icon' => $icons[$i],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for($i = 0 ; $i < 30 ; $i++){
            DB::table('ingredients_categories')->insertOrIgnore([
                'ingredient_id' => rand(1, Ingredient::count()),
                'category_id' => rand(1, Category::count()),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }   
    }
}
