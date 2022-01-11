@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} data-role="input" {!! $attributes->merge(['class' => 'metro-input']) !!}
        >
