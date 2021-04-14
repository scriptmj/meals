<!-- This example requires Tailwind CSS v2.0+ -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Content -->

    <h4>Welcome {{Auth::user()->name}}</h4>
</x-app-layout>