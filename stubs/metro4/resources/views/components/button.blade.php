<button {{ $attributes->merge(['type' => 'submit', 'class' => 'button primary rounded']) }}>
    {{ $slot }}
</button>
