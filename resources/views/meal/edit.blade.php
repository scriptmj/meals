<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit meal') }}
        </h2>
    </x-slot>

<!-- Content -->
<div class="grid grid-cols-2 gap-4 grid-flow-col">

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



</x-app-layout>



