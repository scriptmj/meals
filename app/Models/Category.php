<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    public function ingredients(){
        return $this->hasMany('App\Models\Ingredient');
    }

    public function meals(){
        return $this->hasMany('App\Models\Meal');
    }
}
