<x-app-layout>
    <x-slot name="header">
        Laporan Peminjaman Koleksi
    </x-slot>

    <x-slot name="actions">
        <x-button variant="primary" onclick="window.location='{{ route('staff.loans.create') }}'">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Catat Peminjaman
        </x-button>
    </x-slot>

    <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <!-- Dashboard Style Toolbar -->
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('staff.loans.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-[10px] font-bold uppercase tracking-[0.2em] shadow-lg shadow-indigo-600/20">Semua</a>
                <button class="px-4 py-2 bg-white border border-slate-200 text-slate-500 rounded-xl text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-slate-50 transition-colors">Sedang Dipinjam</button>
                <button class="px-4 py-2 bg-white border border-slate-200 text-slate-500 rounded-xl text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-slate-50 transition-colors">Terperiksa Denda</button>
            </div>
            <div class="relative w-full md:w-72 group">
                <input type="text" placeholder="Cari Kode atau Peminjam..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all shadow-sm">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>

        <!-- Loans Table -->
        <x-table :headers="['KODE & PEMINJAM', 'KOLEKSI', 'STATUS', 'ACTION']">
            @foreach($loans as $loan)
                <tr class="group transition-colors hover:bg-slate-50/50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 font-bold border-2 border-white ring-1 ring-slate-100 uppercase smooth group-hover:scale-110">
                                {{ substr($loan->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-xs font-black text-primary uppercase tracking-[0.2em] leading-none mb-1">{{ $loan->loan_code }}</p>
                                <p class="text-sm font-bold text-slate-900 leading-tight">{{ $loan->user->name }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="space-y-1">
                            @foreach($loan->loanDetails as $detail)
                                <div class="flex items-center text-xs font-semibold text-slate-600 truncate max-w-[200px]">
                                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full mr-2"></span>
                                    {{ $detail->book->title }}
                                </div>
                            @endforeach
                            @if($loan->loanDetails->count() > 1)
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest pl-3.5">+ {{ $loan->loanDetails->count() - 1 }} Item Lainnya</p>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($loan->status === 'borrowed')
                            <x-badge variant="indigo">Sedang Dipinjam</x-badge>
                        @elseif($loan->status === 'overdue')
                            <x-badge variant="rose" class="animate-pulse">Terlambat</x-badge>
                        @else
                            <x-badge variant="emerald">Tuntas Dikembalikan</x-badge>
                        @endif
                        <p class="text-[10px] text-slate-400 mt-1 font-medium italic">Sampai: {{ $loan->due_date->format('d M Y') }}</p>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <x-button variant="outline" size="sm" onclick="window.location='{{ route('staff.loans.show', $loan) }}'">
                            Kelola Transaksi
                        </x-button>
                    </td>
                </tr>
            @endforeach
        </x-table>

        <div class="mt-8">
            {{ $loans->links() }}
        </div>
    </div>
</x-app-layout>
