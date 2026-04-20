<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Daftar Peminjaman') }}
            </h2>
            <a href="{{ route('staff.loans.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                Catat Pinjam
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-0 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kode & Member</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Buku</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tenggat</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($loans as $loan)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-8 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-indigo-600 mb-1">{{ $loan->loan_code }}</div>
                                    <div class="text-xs font-bold text-gray-900">{{ $loan->user->name }}</div>
                                </td>
                                <td class="px-8 py-4">
                                    <div class="text-xs text-gray-600 line-clamp-1">
                                        {{ $loan->loanDetails->first()->book->title }} 
                                        @if($loan->loanDetails->count() > 1)
                                            <span class="text-indigo-500 font-bold ml-1">(+{{ $loan->loanDetails->count() - 1 }} lainnya)</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap">
                                    @if($loan->status === 'borrowed')
                                        <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-xs font-bold uppercase tracking-wider">Dipinjam</span>
                                    @elseif($loan->status === 'returned')
                                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold uppercase tracking-wider">Kembali</span>
                                    @else
                                        <span class="px-3 py-1 bg-rose-50 text-rose-600 rounded-full text-xs font-bold uppercase tracking-wider">Terlambat</span>
                                    @endif
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('staff.loans.show', $loan) }}" class="inline-flex items-center px-4 py-2 bg-slate-50 text-slate-700 rounded-lg hover:bg-slate-100 transition-colors text-xs font-bold uppercase tracking-widest">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @if($loans->isEmpty())
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center text-gray-500 italic">
                                    Belum ada data peminjaman.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $loans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
