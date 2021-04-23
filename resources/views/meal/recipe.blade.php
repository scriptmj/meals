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
    {{$meal->name}}
</div>

</x-app-layout>



