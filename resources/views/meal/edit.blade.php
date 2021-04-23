<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit meal') }}
        </h2>
    </x-slot>

<!-- Content -->
<div class="grid grid-cols-2 gap-4 grid-flow-col">
    <div class="overflow-auto h-auto container bg-gray-50 rounded-md shadow p-3 col-auto">
        <h2 class="font-semibold text-xl text-gray-800 mb-3">Edit {{ucfirst($meal->name)}}</h2>

        <x-validation-errors class="mb-4" :errors="$errors" />

        <form action="{{route('meal.put', $meal)}}" method="POST">
        @csrf
        @method('PUT')
            <x-label for="name" :value="__('Name')"></x-label>
            <x-input id="name" class="block mt-1 w-64 mb-2" type="text" name="name" value="{{old('name', $meal->name)}}" required />

            <x-label for="categories" :value="__('Categories')"></x-label>
            <select 
                class="rounded-md shadow-sm mb-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                name="categories[]" id="categories" multiple>
                    @forelse($categories as $category)
                        @if($meal->isCategorySelected($category))
                        <option value="{{$category->id}}" selected>{{ucfirst($category->name)}}</option>
                        @else
                        <option value="{{$category->id}}">{{ucfirst($category->name)}}</option>
                        @endif
                    @empty
                    @endforelse
            </select>

            <x-input id="ingredientCount" value="{{$meal->ingredientCount()}}" name="count" type="number" hidden />

            <x-label for="ingredient1" :value="__('Ingredients')"></x-label>

            @forelse($meal->mealIngredients() as $mealIngredient)
            <select 
                id="ingredient{{$loop->iteration}}" 
                class="rounded-md shadow-sm mb-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                name="ingredient{{$loop->iteration}}" required>
                @foreach($ingredients as $ingredient)
                    @if($mealIngredient->id == $ingredient->id)
                    <option value="{{$ingredient->id}}" selected>{{ucfirst($ingredient->name)}}</option>
                    @else
                    <option value="{{$ingredient->id}}">{{ucfirst($ingredient->name)}}</option>
                    @endif
                @endforeach
            </select>
            <x-input id="ingredientAmount{{$loop->iteration}}" class="inline-block mt-1 w-20 mb-2" type="number" name="ingredientAmount{{$loop->iteration}}" value="{{old('ingredientAmount'.$loop->iteration, $mealIngredient->amount)}}" required />
            <br />
            @empty
            @endforelse
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
                {{ __('Edit') }}
            </x-button>
        </form>
    </div>
</x-app-layout>
