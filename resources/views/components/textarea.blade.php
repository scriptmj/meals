
@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-textarea mt-1 block w-full rounded-md shadow-sm border-gray-300']) !!}></textarea>
