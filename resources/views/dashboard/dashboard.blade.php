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
                    <!-- <img class="h-5 w-5 inline" src="{{$ingredient->ingredient->category->icon}}"> {{$ingredient->amount}} {{ucfirst($ingredient->ingredient->name)}}<br /> -->
                    <img class="h-5 w-5 inline" src="{{url('storage/icons/'.$ingredient->ingredient->category->icon.'.svg')}}"> {{$ingredient->amount}} {{ucfirst($ingredient->ingredient->name)}}<br />
                @empty
                    None so far. Add some!
                @endforelse
            </div>

            <div class="overflow-auto h-64 container bg-gray-50 rounded-md shadow mb-3 mr-3 col-span-2">
                <h3 class="text-l text-gray-800">Your meals</h3>
                @forelse($meals as $meal)
                    {{$meal->name}}
                    @forelse($meal->categories as $category)
                        <img class="h-5 w-5 inline" src="{{url('storage/icons/'.$category->icon.'.svg')}}">
                    @empty
                    @endforelse
                    <br />
                @empty
                    None so far. Add ingredients to find more meals
                @endforelse
            </div>

            <!-- Add ingredient -->
            <div class="overflow-auto h-24 container bg-gray-50 rounded-md shadow mb-3 mr-3 col-auto">
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
