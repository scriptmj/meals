<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meal;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'size'];

    public function ingredients(){
        return $this->hasManyThrough('App\Models\Ingredient', 'App\Models\MealIngredients', 'meal_id', 'id', 'id', 'meal_id');
    }

    public function ingredientsNeeded(){
        return $this->hasMany('App\Models\MealIngredients');
    }

    public function categories(){
        return $this->hasMany('App\Models\Category', 'meal_id', 'meals_categories');
    }
}
