<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Content -->

    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800">Welcome {{Auth::user()->username}}!</h2>
        
        <div class="grid grid-cols-3 gap-4">
        <!-- Ingredients overview -->
            <div class="overflow-auto h-64 container bg-gray-50 rounded-md shadow p-3 col-auto">
                <h3 class="text-l text-gray-800">Your ingredients:</h3>
                <table>
                @forelse($ingredientsSupply as $ingredient)
                <tr id="row{{$ingredient->id}}">
                    <td>
                        <img class="h-5 w-5 inline" src="{{url('storage/icons/'.$ingredient->ingredient->category->icon.'.svg')}}"> 
                    </td>
                    <td id="itemAmount{{$ingredient->id}}">
                        {{$ingredient->amount}} 
                    </td>
                    <td>
                        {{ucfirst($ingredient->ingredient->name)}}
                    </td>
                    <td id="itemButtons{{$ingredient->id}}">
                        <x-button onclick="toggleEditIngredientSupply({{$ingredient->id}})" class="h-5">
                            Edit
                        </x-button>
                        <form action="{{route('supply.delete', $ingredient)}}" method="post" class="inline">
                            @csrf
                            @method('DELETE')
                            <x-button class="h-5" onclick="return confirm('Are you sure you want delete {{$ingredient->ingredient->name}}?')">
                                Delete
                            </x-button>
                        </form>
                    </td>
                </tr>
                @empty
                    None so far. Add some!
                @endforelse
                </table>
            </div>

            <div class="overflow-auto h-64 container bg-gray-50 rounded-md shadow p-3">
                <h3 class="text-l text-gray-800">Your meals</h3>
                @forelse($meals as $meal)
                    <button onclick="getMealInfo('{{$meal->id}}')">
                    {{ucfirst($meal->name)}}
                    </button>
                    @forelse($meal->categories as $category)
                        <img class="h-5 w-5 inline" src="{{url('storage/icons/'.$category->icon.'.svg')}}">
                    @empty
                    @endforelse
                    <br />
                @empty
                    None so far. Add ingredients to find more meals
                @endforelse
            </div>

            <div class="overflow-auto h-auto container bg-gray-50 rounded-md shadow p-3 col-auto hidden" id="seeMealPanel">
                <h2 class="font-semibold text-xl text-gray-800 mb-3" id="seeMealTitle"></h2>
                Ingredients:
                <p id="seeMealIngredients"></p>
                <br />
                Categories:
                <p id="seeMealCategories"></p>
                <br />
            </div>

            <!-- Add ingredient -->
            <div class="overflow-auto h-32 container bg-gray-50 rounded-md shadow p-3 col-auto row-start-2">
                <h3 class="text-l text-gray-800">Add ingredients:</h3>
                <form action="{{route('supply.add')}}" method="POST">
                @csrf
                <select 
                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                name="ingredient" id="ingredient">
                    @forelse($ingredients as $ingredient)
                    <option value="{{$ingredient->id}}">{{ucfirst($ingredient->name)}}</option>
                    @empty
                    @endforelse
                </select>
                <x-input type="number" name="amount" id="amount" placeholder="Amount" class="w-28"/>
                <x-button class="ml-3">
                    {{ __('Add') }}
                </x-button>
                </form>
            </div>



        </div>
    </div>
</x-app-layout>
