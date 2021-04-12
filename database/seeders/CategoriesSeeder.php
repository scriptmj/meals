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
        $categories = ['dairy', 'vegetarian', 'meat', 'vegetable', 'fruit', 'pasta'];
        foreach($categories as $category){
            DB::table('categories')->insert([
                'name' => $category,
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
