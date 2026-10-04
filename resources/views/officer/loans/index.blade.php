<x-app-layout>
    <x-slot name="header">
        Daftar Sirkulasi Peminjaman
    </x-slot>

    <x-slot name="actions">
        <a href="{{ route('admin.loans.create') }}" class="btn-editorial text-xs py-2 px-4 shadow-xs">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Catat Peminjaman Baru
        </a>
    </x-slot>

    <div class="space-y-6 animate-in fade-in duration-300">
        <!-- Filter Toolbar -->
        <div class="bg-white p-4 rounded-lg border border-neutral-border shadow-xs">
            <form action="{{ route('admin.loans.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                <!-- Search Input -->
                <div class="md:col-span-5 space-y-1.5">
                    <label class="text-[11px] font-semibold text-neutral-dark uppercase tracking-wider block px-0.5">Pencarian</label>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-neutral-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode sirkulasi, peminjam, atau judul buku..." 
                            class="w-full pl-9 pr-3 py-2 bg-neutral-surface border border-neutral-border rounded-md text-sm text-neutral-dark placeholder:text-neutral-muted focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all">
                    </div>
                </div>

                <!-- Status Filter Dropdown -->
                <div class="md:col-span-3 space-y-1.5">
                    <label class="text-[11px] font-semibold text-neutral-dark uppercase tracking-wider block px-0.5">Status</label>
                    <select name="status" 
                        class="w-full px-3 py-2 bg-neutral-surface border border-neutral-border rounded-md text-sm text-neutral-dark focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs">
                        <option value="">Semua Status</option>
                        <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam (Aktif)</option>
                        <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Telah Kembali</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <!-- Jenis Filter Dropdown -->
                <div class="md:col-span-2 space-y-1.5">
                    <label class="text-[11px] font-semibold text-neutral-dark uppercase tracking-wider block px-0.5">Jenis</label>
                    <select name="type" 
                        class="w-full px-3 py-2 bg-neutral-surface border border-neutral-border rounded-md text-sm text-neutral-dark focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs">
                        <option value="">Semua Jenis</option>
                        <option value="digital" {{ request('type') == 'digital' ? 'selected' : '' }}>Digital</option>
                        <option value="physical" {{ request('type') == 'physical' ? 'selected' : '' }}>Fisik</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="md:col-span-2 flex space-x-2">
                    <x-button type="submit" variant="primary" class="flex-1 text-xs uppercase tracking-wider font-semibold py-2">
                        Filter
                    </x-button>
                    @if(request('search') || request('status') || request('type'))
                        <a href="{{ route('admin.loans.index') }}" class="btn-editorial-outline text-xs uppercase tracking-wider font-semibold py-2 px-3">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table View -->
        <x-table :headers="['KODE & ANGGOTA', 'JENIS', 'KOLEKSI BUKU', 'TENGGAT', 'STATUS', 'AKSI']">
            @forelse($loans as $loan)
                <tr class="hover:bg-[#F8F8F7] transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-mono text-xs font-bold text-primary block leading-tight">{{ $loan->loan_code }}</span>
                        <span class="font-sans text-sm font-semibold text-neutral-dark block mt-0.5">{{ $loan->user->name }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($loan->isDigital())
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                Digital
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-50 text-slate-700 border border-neutral-border">
                                Fisik
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-xs text-neutral-dark line-clamp-1 max-w-[280px]">
                            {{ $loan->loanDetails->first()->book->title ?? 'Koleksi Perpustakaan' }}
                            @if($loan->loanDetails->count() > 1)
                                <span class="text-accent font-semibold text-[10px] ml-1">(+{{ $loan->loanDetails->count() - 1 }} lainnya)</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-neutral-body">
                        <span class="font-medium text-neutral-dark block">{{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}</span>
                        @if($loan->status === 'borrowed')
                            <span class="text-[10px] text-neutral-muted">{{ ceil(now()->diffInDays($loan->due_date, false)) }} hari tersisa</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($loan->status === 'borrowed')
                            <x-badge variant="primary">Dipinjam</x-badge>
                        @elseif($loan->status === 'returned')
                            <x-badge variant="emerald">Kembali</x-badge>
                        @else
                            <x-badge variant="rose">Terlambat</x-badge>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <a href="{{ route('admin.loans.show', $loan) }}" class="btn-editorial-outline text-xs py-1.5 px-3 uppercase tracking-wider font-semibold">
                            Kelola Transaksi &rarr;
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-xs text-neutral-muted italic">
                        Belum ada data transaksi peminjaman yang sesuai dengan filter.
                    </td>
                </tr>
            @endforelse
        </x-table>

        <div class="pt-4">
            {{ $loans->links() }}
        </div>
    </div>
</x-app-layout>
