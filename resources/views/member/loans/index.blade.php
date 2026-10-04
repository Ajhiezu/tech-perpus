<x-app-layout>
    <x-slot name="header">
        Buku Pinjaman & Riwayat Sirkulasi — RPK PUSTAKA IMM SAINTEK MU
    </x-slot>

    <div class="space-y-8 animate-in fade-in duration-300">
        <!-- Editorial Section Lead -->
        <div class="space-y-1">
            <span class="text-xs uppercase tracking-[0.2em] font-semibold text-primary block">Arsip Pribadi Anggota</span>
            <h2 class="font-sans text-2xl sm:text-3xl font-bold text-neutral-dark tracking-tight">Catatan Peminjaman & Status Sirkulasi</h2>
            <p class="text-xs sm:text-sm text-neutral-body">Daftar seluruh riwayat peminjaman buku fisik dan digital, status kondisi fisik pengembalian, serta rincian kewajiban sanksi denda.</p>
        </div>

        <!-- Academic Metrics Summary -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-lg border border-neutral-border shadow-xs flex items-center space-x-3.5">
                <div class="w-10 h-10 rounded bg-primary-light text-primary flex items-center justify-center shrink-0 border border-red-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-neutral-muted uppercase tracking-wider block">Total Transaksi</span>
                    <span class="font-sans text-xl font-bold text-neutral-dark block leading-tight">{{ $loans->total() }}</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg border border-neutral-border shadow-xs flex items-center space-x-3.5">
                <div class="w-10 h-10 rounded bg-[#FFF9ED] text-accent flex items-center justify-center shrink-0 border border-[#FDE68A]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-neutral-muted uppercase tracking-wider block">Buku Digital Aktif</span>
                    <span class="font-sans text-xl font-bold text-neutral-dark block leading-tight">
                        {{ $loans->where('loan_type', 'digital')->where('status', 'borrowed')->count() }}
                    </span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg border border-neutral-border shadow-xs flex items-center space-x-3.5">
                <div class="w-10 h-10 rounded bg-[#EDF7ED] text-success flex items-center justify-center shrink-0 border border-[#C8E6C9]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-neutral-muted uppercase tracking-wider block">Buku Fisik Dipinjam</span>
                    <span class="font-sans text-xl font-bold text-neutral-dark block leading-tight">
                        {{ $loans->where('loan_type', 'physical')->where('status', 'borrowed')->count() }}
                    </span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg border border-neutral-border shadow-xs flex items-center space-x-3.5">
                <div class="w-10 h-10 rounded bg-red-50 text-danger flex items-center justify-center shrink-0 border border-red-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-neutral-muted uppercase tracking-wider block">Tagihan Denda Aktif</span>
                    <span class="font-sans text-lg font-bold text-danger block leading-tight">
                        @php
                            $unpaidFines = $loans->sum(function($l) {
                                return ($l->fine && $l->fine->status === 'unpaid') ? $l->fine->amount : 0;
                            });
                        @endphp
                        Rp {{ number_format($unpaidFines, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex items-center gap-2 border-b border-neutral-border pb-3">
            <a href="{{ route('anggota.loans.index') }}" 
               class="px-3.5 py-1.5 rounded text-xs font-semibold transition-colors {{ !request('type') ? 'bg-primary text-white' : 'bg-white text-neutral-body border border-neutral-border hover:border-primary hover:text-primary' }}">
                Semua Peminjaman
            </a>
            <a href="{{ route('anggota.loans.index', ['type' => 'digital']) }}" 
               class="px-3.5 py-1.5 rounded text-xs font-semibold transition-colors flex items-center gap-1.5 {{ request('type') === 'digital' ? 'bg-primary text-white' : 'bg-white text-neutral-body border border-neutral-border hover:border-primary hover:text-primary' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Peminjaman Digital (E-Book)
            </a>
            <a href="{{ route('anggota.loans.index', ['type' => 'physical']) }}" 
               class="px-3.5 py-1.5 rounded text-xs font-semibold transition-colors flex items-center gap-1.5 {{ request('type') === 'physical' ? 'bg-primary text-white' : 'bg-white text-neutral-body border border-neutral-border hover:border-primary hover:text-primary' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                Peminjaman Fisik (Rak)
            </a>
        </div>

        <!-- Loans Circulation Table -->
        <x-table :headers="['KODE & TANGGAL', 'VOLUME BUKU', 'MASA PINJAM / TENGGAT', 'STATUS & KASUS PENGEMBALIAN', 'RINCIAN DENDA', 'AKSI']">
            @forelse($loans as $loan)
                <tr class="group transition-colors hover:bg-[#F8F8F7]">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-mono text-xs font-bold text-primary block">{{ $loan->loan_code }}</span>
                        <span class="text-[10px] text-neutral-muted block mt-0.5">Pinjam: {{ $loan->created_at->format('d M Y') }}</span>
                        @if($loan->isDigital())
                            <span class="inline-flex items-center gap-1 mt-1.5 px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider bg-[#FFF9ED] text-[#B45309] border border-[#FDE68A]">
                                Digital PDF
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 mt-1.5 px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider bg-neutral-100 text-neutral-dark border border-neutral-200">
                                Buku Fisik
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-4">
                        <div class="space-y-1.5">
                            @foreach($loan->loanDetails as $detail)
                                @if($detail->book)
                                    <div class="flex items-start text-xs">
                                        <span class="w-1.5 h-1.5 bg-primary rounded-full mr-2 mt-1.5 shrink-0"></span>
                                        <div class="min-w-0">
                                            <a href="{{ route('anggota.books.show', $detail->book) }}" class="font-semibold text-neutral-dark hover:text-primary transition-colors block line-clamp-1">
                                                {{ $detail->book->title }}
                                            </a>
                                            <span class="text-[10px] text-neutral-muted font-mono block">
                                                {{ $detail->book->author }} • Rak: {{ $detail->book->location->name ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-xs font-bold text-neutral-dark">
                            {{ $loan->due_date->format('d M Y') }}
                        </div>
                        @if($loan->status === 'borrowed')
                            @php
                                $daysRemaining = ceil(now()->startOfDay()->diffInDays($loan->due_date, false));
                            @endphp
                            <p @class([
                                'text-[10px] font-medium mt-0.5',
                                'text-danger font-bold' => $daysRemaining < 0,
                                'text-danger font-semibold' => $daysRemaining >= 0 && $daysRemaining <= 2,
                                'text-neutral-muted' => $daysRemaining > 2,
                            ])>
                                {{ $daysRemaining > 0 ? $daysRemaining . ' hari tersisa' : ($daysRemaining === 0 ? 'Hari ini tenggat' : 'Terlambat ' . abs($daysRemaining) . ' hari') }}
                            </p>
                        @else
                            <p class="text-[10px] text-success font-medium mt-0.5">Selesai</p>
                        @endif
                    </td>

                    <!-- Status & Kasus Pengembalian Column -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($loan->status === 'borrowed')
                            @if(\Carbon\Carbon::parse($loan->due_date)->isPast())
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-bold bg-red-50 text-danger border border-red-200 rounded">
                                    <svg class="w-3 h-3 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Terlambat (Aktif)
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-bold bg-primary-light text-primary border border-red-200 rounded">
                                    <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Sedang Dipinjam
                                </span>
                            @endif
                        @elseif($loan->status === 'returned')
                            @if($loan->returnBook)
                                @if($loan->returnBook->condition === 'good')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-bold bg-[#EDF7ED] text-success border border-[#C8E6C9] rounded">
                                        <svg class="w-3 h-3 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        Kembali Normal (Baik)
                                    </span>
                                @elseif($loan->returnBook->condition === 'damaged')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-bold bg-[#FFF9ED] text-accent border border-[#FDE68A] rounded">
                                        <svg class="w-3 h-3 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        Kembali Rusak
                                    </span>
                                @elseif($loan->returnBook->condition === 'lost')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-bold bg-red-50 text-danger border border-red-200 rounded">
                                        <svg class="w-3 h-3 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Koleksi Hilang
                                    </span>
                                @endif
                                <span class="text-[10px] text-neutral-muted block mt-1 font-mono">
                                    Tgl: {{ \Carbon\Carbon::parse($loan->returnBook->return_date)->format('d M Y') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-bold bg-[#EDF7ED] text-success border border-[#C8E6C9] rounded">
                                    ✓ Dikembalikan
                                </span>
                            @endif
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold bg-neutral-100 text-neutral-dark rounded">
                                {{ ucfirst($loan->status) }}
                            </span>
                        @endif
                    </td>

                    <!-- Informasi Rincian Denda Column -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($loan->fine && $loan->fine->amount > 0)
                            <div>
                                <span class="font-sans text-xs font-bold {{ $loan->fine->status === 'paid' ? 'text-neutral-dark' : 'text-danger' }}">
                                    Rp {{ number_format($loan->fine->amount, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] text-neutral-muted block font-mono">
                                    @if($loan->fine->type === 'late')
                                        Keterlambatan
                                    @elseif($loan->fine->type === 'damaged')
                                        Kerusakan Fisik
                                    @elseif($loan->fine->type === 'lost')
                                        Penggantian Hilang
                                    @else
                                        {{ ucfirst($loan->fine->type) }}
                                    @endif
                                </span>
                                @if($loan->fine->status === 'paid')
                                    <span class="inline-flex items-center gap-1 text-[9px] font-bold text-success bg-[#EDF7ED] border border-[#C8E6C9] px-1.5 py-0.2 rounded mt-0.5">
                                        ✓ LUNAS ({{ \Carbon\Carbon::parse($loan->fine->payment_date)->format('d/m/Y') }})
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[9px] font-bold text-danger bg-red-50 border border-red-200 px-1.5 py-0.2 rounded mt-0.5">
                                        ✕ BELUM DIBAYAR
                                    </span>
                                @endif
                            </div>
                        @else
                            <span class="text-[11px] font-mono text-neutral-muted">Bebas Denda</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        @if($loan->isDigital() && $loan->isActive())
                            @php
                                $book = $loan->loanDetails->first()?->book;
                            @endphp
                            @if($book)
                                <a href="{{ route('anggota.books.reader', $book) }}" 
                                   class="btn-editorial text-[11px] py-1.5 px-3 uppercase tracking-wider font-semibold inline-flex items-center gap-1 shadow-xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Baca Buku
                                </a>
                            @endif
                        @else
                            @php
                                $firstBook = $loan->loanDetails->first()?->book;
                            @endphp
                            @if($firstBook)
                                <a href="{{ route('anggota.books.show', $firstBook) }}" class="text-primary hover:text-primary-dark text-xs font-semibold inline-flex items-center gap-1">
                                    <span>Detail Buku</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            @endif
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="w-12 h-12 rounded-full bg-primary-light text-primary flex items-center justify-center mx-auto mb-3 border border-red-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <p class="font-sans text-base font-bold text-neutral-dark">Belum Ada Riwayat Peminjaman</p>
                        <p class="text-xs text-neutral-muted mt-1">Anda belum memiliki peminjaman buku fisik maupun digital di RPK PUSTAKA IMM SAINTEK MU.</p>
                        <div class="mt-4">
                            <a href="{{ route('anggota.books.index') }}" class="btn-editorial text-xs py-2 px-5">
                                Jelajahi Katalog Buku
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-table>

        <div class="pt-4">
            {{ $loans->links() }}
        </div>
    </div>
</x-app-layout>
