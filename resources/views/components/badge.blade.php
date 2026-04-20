@props([
    'variant' => 'slate',
])

@php
    $variants = [
        'slate' => 'bg-slate-100 text-slate-700',
        'indigo' => 'bg-indigo-50 text-indigo-700',
        'emerald' => 'bg-emerald-50 text-emerald-700',
        'rose' => 'bg-rose-50 text-rose-700',
        'amber' => 'bg-amber-50 text-amber-700',
        'blue' => 'bg-blue-50 text-blue-700',
    ];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest {$variants[$variant]}"]) }}>
    {{ $slot }}
</span>
