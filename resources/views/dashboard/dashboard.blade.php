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
            <div class="overflow-auto h-64 container bg-gray-50 rounded-md shadow mb-3 mr-3 col-auto">
                <h3 class="text-l text-gray-800">Your ingredients:</h3>
                @forelse($ingredientsSupply as $ingredient)
                    <img class="h-5 w-5 inline" src="{{$ingredient->ingredient->category->icon}}"> {{$ingredient->amount}} {{ucfirst($ingredient->ingredient->name)}}<br />
                @empty
                    None so far. Add some!
                @endforelse
            </div>

            <div class="overflow-auto h-64 container bg-gray-50 rounded-md shadow mb-3 mr-3 col-span-2">
                <h3 class="text-l text-gray-800">Your meals</h3>
                @forelse($meals as $meal)
                    {{$meal->name}}
                    @forelse($meal->categories as $category)
                        <img class="h-5 w-5 inline" src="{{$category->icon}}">
                    @empty
                    @endforelse
                    <br />
                @empty
                    None so far. Add ingredients to find more meals
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
