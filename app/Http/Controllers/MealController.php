<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Ingredient;
use App\Models\Meal;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class MealController extends Controller
{
    public function index(){
        $ingredientsSupply = Auth::user()->ingredients;
        $meals = $this->findAllValidMeals($ingredientsSupply);
        $ingredients = Ingredient::get();
        return view('dashboard.dashboard', ['ingredientsSupply' => $ingredientsSupply, 'meals' => $meals, 'ingredients' => $ingredients]);
    }

    public function findAllValidMeals($supply){
        $validMeals = new Collection();
        for($i = 1 ; $i < Meal::count() ; $i++){
            $meal = Meal::find($i);
            $ingredients = $meal->ingredientsNeeded;
            foreach($ingredients as $ingredient){
                if(!$supply->contains('ingredient_id', $ingredient->ingredient_id)){
                    break;
                } else if($supply->keyBy('ingredient_id')->first()->amount < $ingredient->amount){
                    break;
                } else if($ingredient == $ingredients->last()){
                    $validMeals->push($meal);
                }
            }
        }
        return $validMeals;
    }
}
