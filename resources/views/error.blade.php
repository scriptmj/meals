<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Error') }}
        </h2>
    </x-slot>

<!-- Content -->

{{$error}}

</x-app-layout>



