<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IngredientsSupply;
use App\Models\Ingredient;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class IngredientController extends Controller
{
    public function addSupply(){
        $this->validateAddIngredient();
        $userSupply = Auth::user()->ingredients;
        $ingredientId = request('ingredient');
        if($userSupply->contains('ingredient_id', $ingredientId)){
            $existingSupply = $userSupply->firstWhere('ingredient_id', $ingredientId);
            $existingSupply->amount += request('amount') ? request('amount') : 1;
            $existingSupply->update();
        } else {
            $ingredientSupply = new IngredientsSupply();
            $ingredientSupply->ingredient_id = $ingredientId;
            if(request('amount')){
                $ingredientSupply->amount = request('amount');
            }
            $ingredientSupply->user_id = Auth::user()->id;
            $ingredientSupply->save();
        }
        return redirect(route('dashboard.index'));
    }

    public function deleteSupply(IngredientsSupply $ingredientsSupply){
        $ingredientsSupply->delete();
        return redirect(route('dashboard.index'));
    }

    public function getIngredientsSupply(IngredientsSupply $ingredientsSupply){
        $ingredientsSupply->name = $ingredientsSupply->ingredient->name;
        $ingredientsSupply->icon = $ingredientsSupply->ingredient->category->icon;
        return $ingredientsSupply;
    }

    public function updateSupply(IngredientsSupply $ingredientsSupply){
        $ingredientsSupply->amount = request('amount');
        $ingredientsSupply->update();
    }

    public function ingredientControl(){
        if(!Auth::user()->isAdmin()){
            return view('error', ['error' => __('auth.notAdmin')]);
        } else {
            $categories = Category::get();
            $ingredients = Ingredient::orderBy('name')->get();
            return view('ingredient.control', ['categories' => $categories, 'ingredients' => $ingredients]);
        }
    }

    public function storeIngredient(){
        if(!Auth::user()->isAdmin()){
            return view('error', ['error' => __('auth.notAdmin')]);
        } else {
            $ingredient = new Ingredient($this->validateNewIngredient());
            $ingredient->name = strtolower($ingredient->name);
            $ingredient->save();
            return redirect(route('ingredient.control'));
        }
    }

    public function editIngredient(){
        if(!Auth::user()->isAdmin()){
            return view('error', ['error' => __('auth.notAdmin')]);
        } else {
            $this->validateNewIngredient();
            $ingredient = Ingredient::find(request('id'));
            $ingredient->name = strtolower(request('name'));
            $ingredient->category_id = request('category_id');
            $ingredient->update();
            return redirect(route('ingredient.control'));
        }
    }

    public function getAllIngredients(){
        $ingredients = Ingredient::orderBy('name')->get();
        return $ingredients;
    }

    public function deleteIngredient(Ingredient $ingredient){
        if(!Auth::user()->isAdmin()){
            return view('error', ['error' => __('auth.notAdmin')]); 
        } else {
            $ingredient->delete();
            return redirect(route('ingredient.control'));
        }
    }

    private function validateNewIngredient(){
        return request()->validate([
            'name' => 'required|string',
            'category_id' => 'required|numeric|exists:categories,id',
        ]);
    }

    private function validateAddIngredient(){
        return request()->validate([
            'ingredient' => 'required|exists:ingredients,id|numeric',
            'amount' => 'nullable|numeric',
        ]);
    }
}
