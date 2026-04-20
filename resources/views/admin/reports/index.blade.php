<x-app-layout>
    <x-slot name="header">Laporan & Rekapitulasi</x-slot>

    <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <!-- Filter Toolbar -->
        <x-card>
            <x-slot name="header">Filter Laporan</x-slot>
            <form action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Mulai Dari</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all smooth">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Sampai Dengan</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all smooth">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Status Pinjam</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all smooth">
                        <option value="">Semua Status</option>
                        <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Kembali</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>
                <div class="flex space-x-2">
                    <x-button type="submit" class="flex-1">Tampilkan</x-button>
                    <x-button type="button" variant="outline" onclick="window.location='{{ route('admin.reports.index') }}'">Reset</x-button>
                </div>
            </form>
        </x-card>

        <!-- Data Display -->
        <div class="space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-[0.1em]">Hasil Rekapitulasi</h3>
                <div class="flex space-x-3">
                    <x-button variant="outline" onclick="window.location='{{ route('admin.reports.pdf', request()->all()) }}'">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        Cetak PDF
                    </x-button>
                    <x-button variant="outline" onclick="window.location='{{ route('admin.reports.excel', request()->all()) }}'">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Export Excel
                    </x-button>
                </div>
            </div>

            <x-table :headers="['ID', 'Peminjam', 'Buku', 'Tanggal', 'Denda', 'Status']">
                @foreach($loans as $loan)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-xs font-mono text-slate-500">#{{ $loan->id }}</td>
                        <td class="px-6 py-4">
                            <p class="text-xs font-bold text-slate-900 leading-tight">{{ $loan->user->name }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $loan->user->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-[10px] font-medium text-slate-600 line-clamp-1">
                                {{ $loan->loanDetails->map(fn($d) => $d->book->title)->implode(', ') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-[10px] font-bold text-slate-700">{{ $loan->loan_date }}</div>
                            <div class="text-[9px] text-slate-400">Sampai: {{ $loan->due_date }}</div>
                        </td>
                        <td @class(['px-6 py-4 text-xs font-bold', 'text-rose-600' => $loan->fine_amount > 0, 'text-slate-400' => $loan->fine_amount == 0])>
                            Rp {{ number_format($loan->fine_amount) }}
                        </td>
                        <td class="px-6 py-4">
                            @if($loan->status === 'returned')
                                <x-badge variant="emerald">Kembali</x-badge>
                            @elseif($loan->status === 'borrowed')
                                <x-badge variant="indigo">Aktif</x-badge>
                            @elseif($loan->status === 'overdue')
                                <x-badge variant="rose">Terlambat</x-badge>
                            @else
                                <x-badge variant="slate">Batal</x-badge>
                            @endif
                        </td>
                    </tr>
                @endforeach
                @if($loans->isEmpty())
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic">Data tidak ditemukan untuk filter ini.</td>
                    </tr>
                @endif
            </x-table>

            <div class="mt-8 px-2">
                {{ $loans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
