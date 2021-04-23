<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Meal;
use App\Models\Ingredient;
use App\Models\Category;
use App\Models\User;

class MealsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $standardRecipe = "Jelly-o cake wafer tiramisu jujubes sweet roll marshmallow apple pie. Jujubes halvah cake pie halvah. Toffee brownie tart cheesecake marzipan. Marzipan bonbon candy pudding icing jelly tart chocolate. Bear claw ice cream candy jujubes cotton candy. Gummi bears powder lemon drops gingerbread topping chupa chups. Tiramisu candy caramels halvah sesame snaps. Lollipop dessert pie gingerbread cheesecake topping gingerbread.
        Carrot cake icing lemon drops marzipan. Tiramisu lemon drops cupcake sweet pudding ice cream bonbon wafer. Topping cupcake chupa chups oat cake gingerbread. Gummi bears cupcake icing pudding. Wafer wafer cotton candy. Brownie wafer jujubes.
        Toffee topping lollipop ice cream. Oat cake marzipan topping cake cake. Halvah biscuit ice cream. Jelly fruitcake apple pie brownie chocolate cake tart bonbon dragée chocolate bar. Gingerbread macaroon cookie gummi bears topping carrot cake wafer chupa chups. Jujubes pie dessert cookie halvah cake. Chupa chups cookie dessert apple pie halvah. Oat cake dessert wafer carrot cake soufflé gummies jelly-o marshmallow.
        Dragée candy apple pie dessert jujubes liquorice topping brownie lollipop. Soufflé lollipop caramels. Sesame snaps cookie chupa chups. Biscuit biscuit tootsie roll jelly oat cake. Halvah pastry chupa chups cupcake soufflé cake. Ice cream cake gummies cookie. Sesame snaps chocolate bar jelly bonbon jelly beans. Candy canes pastry pudding chocolate cake macaroon topping pie tart sweet roll.
        Danish gingerbread candy canes chocolate pudding tiramisu biscuit. Gingerbread sugar plum candy canes. Sweet roll chocolate bar candy. Pudding carrot cake powder powder. Sugar plum pie bonbon. Jelly-o carrot cake cookie soufflé donut dessert. Candy donut cupcake. Tiramisu chocolate lollipop tootsie roll croissant jelly cake chocolate candy canes. Tiramisu gummies halvah cupcake caramels tootsie roll cake carrot cake cupcake.";
        $meals = ['bacon burger', 'pasta carbonara', 'potato wedges', 'chicken teriyaki', 'jalapeno poppers', 'roast chicken', 'pulled pork', 
        'vegetable soup', 'eggs benedict', 'scotch egg', 'applesauce', 'pasta pesto', 'quesedillas', 'bami', 'nasi', 'cheeseburger', 'pancakes', 
        'honey mustard chicken', 'honey mustard ham', 'grilled salmon', 'buffalo chicken', 'rotisserie chicken', 'sugar cookies', 'feta and tomatoes'];
        foreach($meals as $meal){
            DB::table('meals')->insert([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => $meal,
                'size' => rand(1, 4),
                'recipe' => $standardRecipe,
            ]);
        }

        for($i = 0 ; $i < 50 ; $i++){
            DB::table('meals_ingredients')->insert([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'meal_id' => rand(1, Meal::count()),
                'ingredient_id' => rand(1, Ingredient::count()),
                'amount' => rand(1, 4),
            ]);
        }
        for($i = 0 ; $i < 50 ; $i++){
            DB::table('meals_categories')->insert([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'meal_id' => rand(1, Meal::count()),
                'category_id' => rand(1, Category::count()),
            ]);
        }
        for($i = 0 ; $i < 50 ; $i++){
            DB::table('meals_picked')->insert([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'meal_id' => rand(1, Meal::count()),
                'user_id' => rand(1, User::count()),
            ]);
        }
        
    }
}
