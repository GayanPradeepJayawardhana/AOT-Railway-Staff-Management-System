@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-2 rounded-md bg-[#ebae34] text-sm font-bold leading-5 text-black'
            : 'inline-flex items-center px-3 py-2 rounded-md text-sm font-bold leading-5 text-black hover:bg-[#ebae34]';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
