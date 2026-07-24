<button {{ $attributes->merge(['type' => 'button', 'class' => 'ui-button inline-flex items-center px-4 py-2 text-xs uppercase tracking-widest']) }}>
    {{ $slot }}
</button>
