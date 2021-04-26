<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MealController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'App\Http\Controllers\MealController@index')->middleware('auth')->name('dashboard.index');

Route::get('/ingredients', 'App\Http\Controllers\IngredientController@ingredientControl')->middleware('auth')->name('ingredient.control');
Route::post('/ingredients', 'App\Http\Controllers\IngredientController@storeIngredient')->middleware('auth')->name('ingredient.store');
Route::put('/ingredients', 'App\Http\Controllers\IngredientController@editIngredient')->middleware('auth')->name('ingredient.put');
Route::delete('/ingredients/{ingredient}', 'App\Http\Controllers\IngredientController@deleteIngredient')->middleware('auth')->name('ingredient.delete');

Route::get('/allingredients', 'App\Http\Controllers\IngredientController@getAllIngredients')->middleware('auth')->name('ingredient.get');

Route::get('/meals', 'App\Http\Controllers\MealController@mealControl')->middleware('auth')->name('meal.control');
Route::get('/meals/edit/{meal}', 'App\Http\Controllers\MealController@editMeal')->middleware('auth')->name('meal.edit');
Route::get('/meals/{meal}', 'App\Http\Controllers\MealController@getMeal')->middleware('auth')->name('meal.get');
Route::post('/meals', 'App\Http\Controllers\MealController@storeMeal')->middleware('auth')->name('meal.store');
Route::put('/meals/edit/{meal}', 'App\Http\Controllers\MealController@putMeal')->middleware('auth')->name('meal.put');
Route::delete('/meals/{meal}', 'App\Http\Controllers\MealController@deleteMeal')->middleware('auth')->name('meal.delete');

Route::get('/meal/recipe/{meal}', 'App\Http\Controllers\MealController@seeMealPage')->middleware('auth')->name('meal.recipe');


Route::post('/', 'App\Http\Controllers\IngredientController@addSupply')->middleware('auth')->name('supply.add');
Route::delete('/ingredientsSupply/{ingredientsSupply}', 'App\Http\Controllers\IngredientController@deleteSupply')->middleware('auth')->name('supply.delete');
Route::put('/ingredientsSupply/{ingredientsSupply}', 'App\Http\Controllers\IngredientController@updateSupply')->middleware('auth')->name('supply.put');
Route::get('/ingredientsSupply/{ingredientsSupply}', 'App\Http\Controllers\IngredientController@getIngredientsSupply')->middleware('auth')->name('supply.get');

require __DIR__.'/auth.php';

