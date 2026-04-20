<x-app-layout>
    <x-slot name="header">
        Riwayat Pinjaman Saya
    </x-slot>

    <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-card class="bg-indigo-50/50 border-indigo-100">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white shadow-lg shadow-indigo-600/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">Total Pinjaman</p>
                        <h4 class="text-xl font-bold text-slate-900">{{ $loans->total() }}</h4>
                    </div>
                </div>
            </x-card>
            <x-card>
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">Aktif</p>
                        <h4 class="text-xl font-bold text-slate-900">{{ $loans->where('status', 'borrowed')->count() }}</h4>
                    </div>
                </div>
            </x-card>
            <x-card>
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">Selesai</p>
                        <h4 class="text-xl font-bold text-slate-900">{{ $loans->where('status', 'returned')->count() }}</h4>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Loans Table -->
        <x-table :headers="['KODE PINJAM', 'JUDUL BUKU', 'BATAS WAKTU', 'STATUS']">
            @forelse($loans as $loan)
                <tr class="group transition-colors hover:bg-slate-50/50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <p class="text-xs font-black text-primary uppercase tracking-[0.2em] leading-none mb-1 group-hover:translate-x-1 smooth">{{ $loan->loan_code }}</p>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Dibuat: {{ $loan->created_at->format('d/m/Y') }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="space-y-1">
                            @foreach($loan->loanDetails as $detail)
                                <div class="flex items-center text-xs font-semibold text-slate-700">
                                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full mr-2"></span>
                                    <span class="truncate max-w-[250px]">{{ $detail->book->title }}</span>
                                </div>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-xs font-bold text-slate-700">
                            {{ $loan->due_date->format('d M Y') }}
                        </div>
                        <p class="text-[9px] text-slate-400 font-medium italic mt-1 italic">
                            {{ ceil(now()->diffInDays($loan->due_date, false)) }} hari tersisa
                        </p>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($loan->status === 'borrowed')
                            <x-badge variant="indigo">Berjalan</x-badge>
                        @elseif($loan->status === 'overdue')
                            <x-badge variant="rose">Terlambat</x-badge>
                        @else
                            <x-badge variant="emerald">Selesai</x-badge>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-20 text-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Belum ada riwayat peminjaman</p>
                    </td>
                </tr>
            @endforelse
        </x-table>

        <div class="mt-8">
            {{ $loans->links() }}
        </div>
    </div>
</x-app-layout>
