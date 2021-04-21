<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meals') }}
        </h2>
    </x-slot>

<!-- Content -->
<div class="grid grid-cols-2 gap-4 grid-flow-col">

<!-- Ingredient overview -->
<div class="overflow-auto h-100 container bg-gray-50 rounded-md shadow p-3 row-span-3">
        <h2 class="font-semibold text-xl text-gray-800 mb-3">Meals</h2>

        <x-validation-errors class="mb-4" :errors="$errors" />

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="text-left">
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
        @forelse($meals as $meal)
                <tr>
                    <td>
                        <button onclick="getMealInfo('{{$meal->id}}', 'see')">
                            {{ucfirst($meal->name)}}
                        </button>
                    </td>
                    <td>
                    @forelse($meal->categories as $category)
                    <img class="h-5 w-5 inline" src="{{url('storage/icons/'.$category->icon.'.svg')}}">
                    @empty
                    @endforelse</td>
                    <td>
                        <x-button onclick="getMealInfo('{{$meal->id}}', 'edit')"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 h-5">
                            Edit
                        </x-button>
                        <form action="{{route('meal.delete', $meal)}}" method="post" class="inline">
                            @csrf
                            @method('DELETE')
                            <x-button class="h-5" onclick="return confirm('Are you sure you want delete {{$meal->name}}?')">
                                Delete
                            </x-button>
                        </form>
                    </td>
                </tr>
        @empty
                <tr><td>No meals</td></tr>
        @endforelse
            </tbody>
        </table>
    </div>

<!-- See meal -->
    <div class="overflow-auto h-auto container bg-gray-50 rounded-md shadow p-3 col-auto hidden" id="seeMealPanel">
        <h2 class="font-semibold text-xl text-gray-800 mb-3" id="seeMealTitle"></h2>
        Ingredients:
        <p id="seeMealIngredients"></p>
        <br />
        Categories:
        <p id="seeMealCategories"></p>
        <br />
        <x-button class="ml-3 mb-1" type="button" id="seeMealEditButton">
                {{ __('Edit') }}
        </x-button>
    </div>


<!-- Edit meal -->

<!-- New meal -->
    <div class="overflow-auto h-auto container bg-gray-50 rounded-md shadow p-3 col-auto">
        <h2 class="font-semibold text-xl text-gray-800 mb-3">Create a new meal</h2>

        <x-validation-errors class="mb-4" :errors="$errors" />

        <form action="{{route('meal.put')}}" method="POST">
        @csrf
            <x-label for="name" :value="__('Name')"></x-label>
            <x-input id="name" class="block mt-1 w-64 mb-2" type="text" name="name" :value="old('name')" required />

            <x-label for="categories" :value="__('Categories')"></x-label>
            <select 
                class="rounded-md shadow-sm mb-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                name="categories[]" id="categories" multiple>
                    @forelse($categories as $category)
                    <option value="{{$category->id}}">{{ucfirst($category->name)}}</option>
                    @empty
                    @endforelse
            </select>

            <x-input id="ingredientCount" value="1" name="count" type="number" hidden />
            
            <x-label for="ingredient1" :value="__('Ingredients')"></x-label>
            <select id="ingredient1" class="rounded-md shadow-sm mb-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="ingredient1" required>
                @forelse($ingredients as $ingredient)
                    <option value="{{$ingredient->id}}">{{ucfirst($ingredient->name)}}</option>
                @empty
                @endforelse
            </select>
            <x-input id="ingredientAmount1" class="inline-block mt-1 w-20 mb-2" type="number" name="ingredientAmount1" :value="old('ingredientAmount1')" required />
            <div id="ingredientsDiv"></div>
            <br />
            <x-button class="ml-3 mb-1" type="button" onclick="addAnotherIngredientField({{$ingredients}})">
                {{ __('Add another ingredient') }}
            </x-button>
            <x-button class="ml-3 mb-1" type="button" onclick="removeLastIngredientField()">
                {{ __('Remove last ingredient') }}
            </x-button>

<br />
            <x-button class="ml-3">
                {{ __('Add') }}
            </x-button>
        </form>
    </div>


<!-- Edit meal -->
<div id="edit-meal" class="hidden">
    <div class="overflow-auto h-56 container bg-gray-50 rounded-md shadow p-3 col-auto">
        <h2 class="font-semibold text-xl text-gray-800 mb-3">Edit meal</h2>

        <x-validation-errors class="mb-4" :errors="$errors" />

        <form action="{{route('meal.put')}}" method="POST">
        @csrf
        @method('PUT')
            <input type="hidden" id="edit-id" name="id"></input>
            <x-label for="edit-name" :value="__('Name')"></x-label>
            <x-input id="edit-name" class="block mt-1 w-64 mb-2" type="text" name="name" :value="old('name')" required />

            <x-label for="category" :value="__('Category')"></x-label>
            <select 
                class="rounded-md shadow-sm mb-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                name="category_id" id="edit-category">
                    @forelse($categories as $category)
                    <option value="{{$category->id}}">{{ucfirst($category->name)}}</option>
                    @empty
                    @endforelse
            </select>

            <x-button class="ml-3">
                {{ __('Edit') }}
            </x-button>
        </form>
    </div>
    </div>
</div>

</x-app-layout>



