@props(['status'])

@if ($status)
    <div id="sessionStatus" {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
        {{ $status }}
    </div>
@endif
