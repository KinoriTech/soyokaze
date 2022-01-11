@props(['value'])

<label {{ $attributes->merge(['class' => 'text-medium text-medium fg-gray']) }}>
    {{ $value ?? $slot }}
</label>
