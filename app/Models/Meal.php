<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meal;
use Illuminate\Support\Facades\DB;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'size'];

    //TODO doesn't work
    public function ingredients(){
        return $this->hasManyThrough('App\Models\Ingredient', 'App\Models\MealIngredients', 'meal_id', 'id', 'id', 'ingredient_id');
    }

    public function ingredientsNeeded(){
        return $this->hasMany('App\Models\MealIngredients');
    }

    public function categories(){
        return $this->belongsToMany('App\Models\Category','meals_categories', 'meal_id');
    }

    public function mealIngredients(){
        $ingredients = DB::table('meals_ingredients')
            ->join('ingredients', 'meals_ingredients.ingredient_id', 'ingredients.id')
            ->select('meals_ingredients.amount', 'ingredients.name')
            ->where('meal_id', $this->id)
            ->get();
        return $ingredients;
    }
    
    public function getCategories(){
        $categories = DB::table('meals_categories')
            ->join('categories', 'meals_categories.category_id', 'categories.id')
            ->select('categories.name', 'categories.icon')
            ->where('meal_id', $this->id)
            ->get();
        return $categories;
    }
}
