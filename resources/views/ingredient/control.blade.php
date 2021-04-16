<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New ingredient') }}
        </h2>
    </x-slot>

<!-- Content -->
<div class="grid grid-cols-2 gap-4 grid-flow-col">

<!-- Ingredient overview -->
<div class="overflow-auto h-100 container bg-gray-50 rounded-md shadow p-3 row-span-2">
        <h2 class="font-semibold text-xl text-gray-800 mb-3">Ingredients</h2>

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
        @forelse($ingredients as $ingredient)
                <tr>
                    <td>{{ucfirst($ingredient->name)}}</td>
                    <td><img class="h-5 w-5 inline" src="{{url('storage/icons/'.$ingredient->category->icon.'.svg')}}"></td>
                    <td>Edit/Delete</td>
                </tr>
        @empty
                <tr><td>No ingredients</td></tr>
        @endforelse
            </tbody>
        </table>
    </div>


<!-- New ingredient -->
    <div class="overflow-auto h-56 container bg-gray-50 rounded-md shadow p-3 col-auto">
        <h2 class="font-semibold text-xl text-gray-800 mb-3">Create a new ingredient</h2>

        <x-validation-errors class="mb-4" :errors="$errors" />

        <form action="{{route('ingredient.put')}}" method="POST">
        @csrf
            <x-label for="name" :value="__('Name')"></x-label>
            <x-input id="name" class="block mt-1 w-64 mb-2" type="text" name="name" :value="old('name')" required />

            <x-label for="category" :value="__('Category')"></x-label>
            <select 
                class="rounded-md shadow-sm mb-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                name="category_id" id="category">
                    @forelse($categories as $category)
                    <option value="{{$category->id}}">{{ucfirst($category->name)}}</option>
                    @empty
                    @endforelse
            </select>

            <x-button class="ml-3">
                {{ __('Add') }}
            </x-button>
        </form>
    </div>

<div id="edit-ingredient" class="hidden">
    <div class="overflow-auto h-56 container bg-gray-50 rounded-md shadow p-3 col-auto">
        <h2 class="font-semibold text-xl text-gray-800 mb-3">Edit ingredient</h2>

        <x-validation-errors class="mb-4" :errors="$errors" />

        <form action="{{route('ingredient.store')}}" method="POST">
        @csrf
        @method('PUT')
            <x-label for="name" :value="__('Name')"></x-label>
            <x-input id="name" class="block mt-1 w-64 mb-2" type="text" name="name" :value="old('name')" required />

            <x-label for="category" :value="__('Category')"></x-label>
            <select 
                class="rounded-md shadow-sm mb-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                name="category_id" id="category">
                    @forelse($categories as $category)
                    <option value="{{$category->id}}">{{ucfirst($category->name)}}</option>
                    @empty
                    @endforelse
            </select>

            <x-button class="ml-3">
                {{ __('Add') }}
            </x-button>
        </form>
    </div>
    </div>
</div>

</x-app-layout>



