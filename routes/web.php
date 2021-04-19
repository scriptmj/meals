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


Route::post('/', 'App\Http\Controllers\IngredientController@addSupply')->middleware('auth')->name('supply.add');

require __DIR__.'/auth.php';

