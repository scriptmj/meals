<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Title') }}
        </h2>
    </x-slot>

<!-- Content -->

</x-app-layout>




<!-- Button -->
<x-button class="ml-3">
    {{ __('Submit') }}
</x-button>



<!-- Form -->


<form action="{{route('')}}" method="">
    <x-label for="" :value="__('')"></x-label>
    <x-input id="" class="block mt-1 w-full" type="" name="" :value="old('')" required autofocus />
</form>