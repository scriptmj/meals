<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IngredientsSupply;
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

    private function validateAddIngredient(){
        return request()->validate([
            'ingredient' => 'required|exists:ingredients,id|numeric',
            'amount' => 'nullable|numeric',
        ]);
    }
}
