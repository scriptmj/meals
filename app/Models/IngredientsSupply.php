<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientsSupply extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ingredient_id', 'amount'];

    public $table = 'ingredients_supply';

    public function user(){
        return $this->hasOne('App\Models\User');
    }
    public function ingredient(){
        return $this->hasOne('App\Models\Ingredient', 'id', 'ingredient_id');
    }
}
