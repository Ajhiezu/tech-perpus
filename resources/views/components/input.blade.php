@props(['disabled' => false, 'label' => '', 'error' => ''])

<div>
    @if($label)
        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 px-1">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all smooth disabled:opacity-50']) !!}>
    </div>

    @if($error)
        <p class="mt-2 text-xs font-semibold text-rose-500 px-1">{{ $error }}</p>
    @endif
</div>
