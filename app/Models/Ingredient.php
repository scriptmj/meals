<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function categories(){
        return $this->belongsToMany('App\Models\Category');
    }

    public function meals(){
        return $this->belongsToMany('App\Models\Meal');
    }
}
