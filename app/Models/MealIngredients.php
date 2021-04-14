<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealIngredients extends Model
{
    use HasFactory;

    protected $fillable = ['meal_id', 'ingredient_id'];

    public $table = 'meals_ingredients';

    public function ingredients(){
        return $this->hasOne('App\Models\Ingredient');
    }

    public function meal(){
        return $this->hasOne('App\Models\Meal');
    }
}
