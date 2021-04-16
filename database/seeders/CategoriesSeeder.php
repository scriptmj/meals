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
        $icons = ['dairy', 'meat', 'vegetable', 'fruit', 'pasta', 'fast_food'];
        for($i = 0 ; $i < count($categories) ; $i++){
            DB::table('categories')->insert([
                'name' => $categories[$i],
                'icon' => $icons[$i],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
