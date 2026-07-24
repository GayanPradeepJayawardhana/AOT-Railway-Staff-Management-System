@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 text-start text-base font-bold text-black bg-[#ebae34]'
            : 'block w-full ps-3 pe-4 py-2 text-start text-base font-bold text-black hover:bg-[#ebae34]';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
