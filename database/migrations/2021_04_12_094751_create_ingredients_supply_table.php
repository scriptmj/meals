<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientsSupplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredients_supply', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('amount')->default(1);
        });

        Schema::table('ingredients_supply', function (Blueprint $table) {
            $table->foreignId('ingredient_id')->constrained();
            $table->foreignId('user_id')->constrained();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredients_supply');
    }
}
