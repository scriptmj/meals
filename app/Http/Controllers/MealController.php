<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Ingredient;
use App\Models\Category;
use App\Models\MealIngredients;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class MealController extends Controller
{
    public function index(){
        $ingredientsSupply = Auth::user()->ingredients;
        $meals = $this->findAllValidMeals($ingredientsSupply);
        $ingredients = Ingredient::orderBy('name')->get();
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

    public function mealControl(){
        if(!Auth::user()->isAdmin()){
            return view('error', ['error' => __('auth.notAdmin')]);
        } else {
            $meals = Meal::orderBy('name')->get();
            $categories = Category::orderBy('name')->get();
            $ingredients = Ingredient::orderBy('name')->get();
            return view('meal.control', ['meals' => $meals, 'categories' => $categories, 'ingredients' => $ingredients]);
        }
    }

    public function storeMeal(){
        if(!Auth::user()->isAdmin()){
            return view('error', ['error' => __('auth.notAdmin')]);
        } else {
            //dd(request());
            $meal = new Meal($this->validateNewMeal());
            $meal->name = strtolower($meal->name);
            $meal->save();
            for($i = 1 ; $i <= request('count') ; $i++){
                $this->validateIndividualIngredient($i);
                $ingredient = new MealIngredients();
                $ingredient->meal_id = $meal->id;
                $ingredient->ingredient_id = request('ingredient'.$i);
                $ingredient->amount = request('ingredientAmount'.$i);
                $ingredient->save();
            }
            $meal->categories()->attach(request('categories'));
            return redirect(route('meal.control'));
        }
    }

    public function editMeal(Meal $meal){
        if(!Auth::user()->isAdmin()){
            return view('error', ['error' => __('auth.notAdmin')]);
        } else {
            $categories = Category::orderBy('name')->get();
            $ingredients = Ingredient::orderBy('name')->get();
            return view('meal.edit', ['meal' => $meal, 'categories' => $categories, 'ingredients' => $ingredients]);
        }
    }
    public function getMeal(Meal $meal){
        $meal->categories = $meal->getCategories();
        $meal->ingredients = $meal->mealIngredients();
        foreach($meal->categories as $category){
            $category->icon = url('storage/icons/'.$category->icon.'.svg');
        }
        return $meal;
    }

    public function putMeal(){

    }

    public function deleteMeal(){

    }

    private function validateNewMeal(){
        return request()->validate([
            'name' => 'required|string',
            'categories' => 'required|array',
        ]);
    }

    private function validateIndividualIngredient($count){
        return request()->validate([
            'ingredient'.$count => 'required|exists:ingredients,id|numeric',
            'ingredientAmount'.$count => 'required|numeric|gte:1',
        ]);
    }
}
