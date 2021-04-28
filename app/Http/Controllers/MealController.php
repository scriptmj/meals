<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Ingredient;
use App\Models\Category;
use App\Models\MealIngredients;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\MealRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class MealController extends Controller
{
    public function index(){
        $ingredientsSupply = Auth::user()->ingredients;
        $meals = $this->findAllValidMeals($ingredientsSupply);
        $ingredients = Ingredient::orderBy('name')->get();
        $favouriteMeals = $this->getFavouriteMeals();
        return view('dashboard.dashboard', ['ingredientsSupply' => $ingredientsSupply, 'meals' => $meals, 'ingredients' => $ingredients, 'favouriteMeals' => $favouriteMeals]);
    }

    private function getFavouriteMeals(){
        $items = DB::table('meals_picked')->where('user_id', Auth::user()->id)->get();
        $meals = new Collection();
        foreach($items as $item){
            if($meals->contains('meal_id', $item->meal_id)){
                $meals->firstWhere('meal_id', $item->meal_id)->count += 1;
            } else {
                $item->count = 1;
                $item->name = Meal::where('id', $item->meal_id)->first()->name;
                $meals->push($item);
            }
        }
        return $meals->sortByDesc('count')->take(5);
    }

    public function findAllValidMeals($supply){
        $validMeals = new Collection();
        for($i = 1 ; $i < Meal::count() ; $i++){
            $meal = Meal::find($i);
            $ingredients = $meal->ingredientsNeeded;
            foreach($ingredients as $ingredient){
                if(!$supply->contains('ingredient_id', $ingredient->ingredient_id)){
                    break;
                } else if($supply->firstWhere('ingredient_id', $ingredient->ingredient_id)->amount < $ingredient->amount){
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

    public function storeMeal(MealRequest $mealRequest){
        $meal = new Meal();
        $meal->name = strtolower(request('name'));
        $meal->recipe = request('recipe');
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

    public function putMeal(MealRequest $mealRequest){
        $meal = Meal::find(request('id'));
        $meal->name = request('name');
        $meal->recipe = request('recipe');
        $meal->update();
        for($i = 1 ; $i <= request('count') ; $i++){
            $this->validateIndividualIngredient($i);
            $existingIngredient = $this->findExistingMealIngredients($meal, $i);
            if($existingIngredient){
                if($existingIngredient->amount != request('ingredientAmount'.$i)){
                    $existingIngredient->amount = request('ingredientAmount'.$i);
                    $existingIngredient->update();
                }
            } else {
                $ingredient = new MealIngredients();
                $ingredient->meal_id = $meal->id;
                $ingredient->ingredient_id = request('ingredient'.$i);
                $ingredient->amount = request('ingredientAmount'.$i);
                $ingredient->save();
            }
        }
        $meal->categories()->sync(request('categories'));
        return redirect(route('meal.control'));
    }

    public function deleteMeal(Meal $meal){
        if(!Auth::user()->isAdmin()){
            return view('error', ['error' => __('auth.notAdmin')]);
        } else {
            $meal->delete();
            return redirect(route('meal.control'));
        }
    }

    public function seeMealPage(Meal $meal){
        return view('meal.recipe', ['meal' => $this->getMeal($meal)]);
    }

    public function pickMeal(Meal $meal){
        DB::table('meals_picked')->insert([
            'meal_id' => $meal->id,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
        return redirect(route('dashboard.index'));
    }
    
    private function validateIndividualIngredient($count){
        return request()->validate([
            'ingredient'.$count => 'required|exists:ingredients,id|numeric',
            'ingredientAmount'.$count => 'required|numeric|gte:1',
        ]);
    }

    private function findExistingMealIngredients($meal, $count){
        return MealIngredients::where('meal_id', $meal->id)->where('ingredient_id', request('ingredient'.$count))->get()->first();
    }
}
