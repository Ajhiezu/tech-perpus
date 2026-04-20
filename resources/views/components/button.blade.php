@props([
    'variant' => 'primary',
    'type' => 'button',
    'size' => 'md'
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 focus:ring-4 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $variants = [
        'primary' => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500/20 shadow-md shadow-indigo-600/10',
        'outline' => 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 focus:ring-slate-100',
        'danger' => 'bg-rose-500 text-white hover:bg-rose-600 focus:ring-rose-500/20 shadow-md shadow-rose-500/10',
        'success' => 'bg-emerald-500 text-white hover:bg-emerald-600 focus:ring-emerald-500/20 shadow-md shadow-emerald-500/10',
        'ghost' => 'bg-transparent text-slate-500 hover:bg-slate-100 hover:text-slate-900',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];
@endphp

<button {{ $attributes->merge(['type' => $type, 'class' => "$baseClasses {$variants[$variant]} {$sizes[$size]}"]) }}>
    {{ $slot }}
</button>
