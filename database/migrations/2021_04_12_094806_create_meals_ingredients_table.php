<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealsIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals_ingredients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('amount')->default(1);
        });

        Schema::table('meals_ingredients', function (Blueprint $table) {
            $table->foreignId('meal_id')->constrained();
            $table->foreignId('ingredient_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meals_ingredients');
    }
}
