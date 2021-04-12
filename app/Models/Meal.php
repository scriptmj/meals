<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'size'];

    public function ingredients(){
        return $this->hasMany('App\Model\Ingredient');
    }

    public function categories(){
        return $this->hasMany('App\Models\Category');
    }
}
