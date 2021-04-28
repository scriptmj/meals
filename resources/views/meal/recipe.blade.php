<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Recipe') }}
        </h2>
    </x-slot>

<!-- Content -->
<div class="grid grid-cols-2 gap-4 grid-flow-col">

<!-- Ingredient overview -->
<div class="overflow-auto h-100 container bg-gray-50 rounded-md shadow p-3 row-span-3">
    <div class="p-2 flexbox">
        <h2 class="font-semibold text-xl inline">
        {{ucfirst($meal->name)}}
        </h2>
        <form action="{{route('meal.pick', $meal)}}" method="POST" class="inline float-right">
        @csrf
            <x-button>I made this meal</x-button>
        </form>
    </div>
    <hr />
    <div class="p-2">
        <h3 class="font-semibold text-l">Ingredients:</h3>
        @forelse($meal->ingredients as $ingredient)
            {{$ingredient->amount}} {{$ingredient->name}}<br />
        @empty
        @endforelse
    </div>
    <hr />
    <div class="p-2">
        {!!$meal->recipe!!}
    </div>
    
</div>

</x-app-layout>



