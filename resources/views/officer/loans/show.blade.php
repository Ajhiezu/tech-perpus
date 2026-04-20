<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                Detail Pinjaman: {{ $loan->loan_code }}
            </h2>
            <div class="flex space-x-2">
                <x-secondary-button onclick="window.history.back()">Kembali</x-secondary-button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid md:grid-cols-3 gap-8">
            <!-- Loan Info Card -->
            <div class="md:col-span-2 space-y-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-50 pb-4">Daftar Buku yang Dipinjam</h3>
                    <div class="space-y-6">
                        @foreach($loan->loanDetails as $detail)
                        <div class="flex items-center space-x-4 p-4 bg-slate-50 rounded-xl">
                            <div class="w-12 h-16 bg-gray-200 rounded overflow-hidden flex-shrink-0">
                                @if($detail->book->image)
                                    <img src="{{ asset('storage/'.$detail->book->image) }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $detail->book->title }}</h4>
                                <p class="text-xs text-gray-500">{{ $detail->book->author }} (ISBN: {{ $detail->book->isbn }})</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                @if($loan->status === 'borrowed')
                <!-- Return Processing Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-8">
                    <h3 class="text-lg font-bold text-indigo-600 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 0118 0z"></path></svg>
                        Proses Pengembalian
                    </h3>
                    <form action="{{ route('staff.loans.returnBook', $loan) }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Kondisi Buku Saat Kembali</label>
                            <div class="grid grid-cols-3 gap-4">
                                <label class="relative flex flex-col items-center p-4 bg-white rounded-2xl border border-slate-200 cursor-pointer hover:border-indigo-300 transition-all group">
                                    <input type="radio" name="condition" value="good" class="hidden peer" checked>
                                    <div class="w-full h-full absolute inset-0 rounded-2xl border-2 border-transparent peer-checked:border-indigo-600 peer-checked:bg-indigo-50/30 transition-all pointer-events-none"></div>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 group-hover:text-indigo-600">Status</span>
                                    <span class="text-sm font-bold text-slate-800 peer-checked:text-indigo-700">Kondisi Baik</span>
                                </label>
                                <label class="relative flex flex-col items-center p-4 bg-white rounded-2xl border border-slate-200 cursor-pointer hover:border-indigo-300 transition-all group">
                                    <input type="radio" name="condition" value="damaged" class="hidden peer">
                                    <div class="w-full h-full absolute inset-0 rounded-2xl border-2 border-transparent peer-checked:border-amber-600 peer-checked:bg-amber-50/30 transition-all pointer-events-none"></div>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 group-hover:text-amber-600">Status</span>
                                    <span class="text-sm font-bold text-slate-800 peer-checked:text-amber-700">Rusak</span>
                                </label>
                                <label class="relative flex flex-col items-center p-4 bg-white rounded-2xl border border-slate-200 cursor-pointer hover:border-indigo-300 transition-all group">
                                    <input type="radio" name="condition" value="lost" class="hidden peer">
                                    <div class="w-full h-full absolute inset-0 rounded-2xl border-2 border-transparent peer-checked:border-rose-600 peer-checked:bg-rose-50/30 transition-all pointer-events-none"></div>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 group-hover:text-rose-600">Status</span>
                                    <span class="text-sm font-bold text-slate-800 peer-checked:text-rose-700">Hilang</span>
                                </label>

                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Catatan Tambahan (Opsional)</label>
                            <textarea name="notes" rows="3" class="w-full rounded-2xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="Contoh: Buku bercak air, halaman 12 robek sedikit..."></textarea>
                        </div>
                        <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-200 hover:scale-[1.02] transition-all">
                            Konfirmasi Pengembalian
                        </button>
                    </form>
                </div>
                @else
                <!-- Detail Info if Returned -->
                <div class="bg-indigo-600 overflow-hidden shadow-sm sm:rounded-2xl p-8 text-white flex items-center">
                    <div class="bg-white/20 p-4 rounded-2xl mr-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Buku Sudah Dikembalikan</h3>
                        <p class="opacity-80">Dikembalikan pada {{ \Carbon\Carbon::parse($loan->returnBook->return_date)->format('d M Y H:i') }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Member & Status Card -->
            <div class="space-y-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-8">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6">Informasi Member</h3>
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold uppercase mr-4">
                            {{ substr($loan->user->name, 0, 2) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">{{ $loan->user->name }}</h4>
                            <p class="text-xs text-gray-500">{{ $loan->user->email }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">No. Telepon</span>
                            <span class="font-bold">{{ $loan->user->phone ?? '-' }}</span>
                        </div>
                        <div class="pt-4 border-t border-gray-50">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Alamat</p>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $loan->user->address ?? 'Alamat belum diatur.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-8">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6">Status Pinjaman</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Tgl. Pinjam</span>
                            <span class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Tgl. Tenggat</span>
                            <span class="font-bold text-rose-600">{{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}</span>
                        </div>
                        <div class="pt-4 border-t border-gray-50">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Denda Saat Ini</p>
                            <p class="text-2xl font-extrabold text-gray-900">Rp {{ number_format($loan->fine ? $loan->fine->amount : 0, 0, ',', '.') }}</p>
                            @if($loan->fine)
                                <span class="px-2 py-0.5 bg-rose-50 text-rose-600 rounded-lg text-[10px] font-bold uppercase">{{ $loan->fine->type }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
