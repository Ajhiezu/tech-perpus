<x-app-layout>
    <x-slot name="header">Riwayat Aktivitas</x-slot>

    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <x-card>
            <x-slot name="header">Aktivitas Terbaru</x-slot>

            <div class="space-y-4">
                @forelse($activities as $loan)
                    <div class="flex items-start space-x-4 p-4 bg-slate-50 border border-slate-100 rounded-xl hover:shadow-sm transition-all group">
                        <div @class([
                            'w-10 h-10 rounded-lg flex items-center justify-center text-white shrink-0',
                            'bg-indigo-500' => $loan->status === 'borrowed',
                            'bg-emerald-500' => $loan->status === 'returned',
                            'bg-rose-500' => $loan->status === 'overdue',
                        ])>
                            @if($loan->status === 'borrowed')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            @elseif($loan->status === 'returned')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-900">
                                <span class="font-bold text-indigo-600">{{ $loan->user->name }}</span>
                                @if($loan->status === 'borrowed')
                                    memesan buku
                                @elseif($loan->status === 'returned')
                                    mengembalikan buku
                                @else
                                    terlambat mengembalikan buku
                                @endif
                            </p>
                            <div class="mt-1 flex items-center space-x-2 text-xs text-slate-500">
                                @foreach($loan->loanDetails as $detail)
                                    <span class="bg-white border border-slate-200 px-2 py-0.5 rounded text-slate-600 truncate max-w-[200px]">{{ $detail->book->title }}</span>
                                @endforeach
                            </div>
                            <div class="mt-2 text-[10px] text-slate-400 font-medium uppercase tracking-widest flex items-center space-x-3">
                                <span>{{ $loan->created_at->diffForHumans() }}</span>
                                <span>•</span>
                                <span>ID: #{{ $loan->id }}</span>
                                @if($loan->fine_amount > 0)
                                    <span class="text-rose-500 font-bold bg-rose-50 px-2 py-0.5 rounded">Denda: Rp {{ number_format($loan->fine_amount) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-400 italic">Belum ada aktivitas tercatat.</div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $activities->links() }}
            </div>
        </x-card>
    </div>
</x-app-layout>
