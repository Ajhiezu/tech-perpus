<div {{ $attributes->merge(['class' => 'bg-white rounded-xl border border-slate-200 shadow-sm transition-all duration-300']) }}>
    @if(isset($header))
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 rounded-t-xl">
            <h3 class="text-slate-900 font-semibold tracking-tight">{{ $header }}</h3>
        </div>
    @endif
    
    <div class="p-6">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 rounded-b-xl">
            {{ $footer }}
        </div>
    @endif
</div>
