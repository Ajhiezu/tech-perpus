<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Catat Peminjaman Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-8">
                <form action="{{ route('staff.loans.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-8">
                        <label for="user_id" class="block text-sm font-bold text-gray-700 uppercase mb-2">Pilih Peminjam (Member/Staff)</label>
                        <select name="user_id" id="user_id" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <option value="">-- Pilih Peminjam --</option>
                            @foreach($borrowers as $borrower)
                                <option value="{{ $borrower->id }}">
                                    {{ $borrower->name }} ({{ $borrower->email }}) — {{ strtoupper($borrower->role) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                    </div>


                    <div class="mb-8 p-6 bg-slate-50 rounded-2xl border border-slate-100">
                        <label for="due_date" class="block text-sm font-bold text-slate-700 uppercase mb-2">Batas Waktu Pengembalian</label>
                        <input type="date" name="due_date" id="due_date" required 
                            min="{{ now()->addDay()->toDateString() }}" 
                            max="{{ now()->addDays(14)->toDateString() }}"
                            value="{{ now()->addDays(7)->toDateString() }}"
                            class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm font-bold text-slate-700">
                        <p class="mt-2 text-[10px] text-slate-400 font-medium italic">* Default peminjaman adalah 7 hari. Maksimal 14 hari.</p>
                        <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                    </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto p-4 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                            @foreach($books as $book)
                            <label class="relative flex items-center p-4 bg-white rounded-xl border border-gray-100 cursor-pointer hover:border-indigo-300 transition-all group">
                                <input type="checkbox" name="book_ids[]" value="{{ $book->id }}" class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <span class="ml-4 flex flex-col">
                                    <span class="text-sm font-bold text-gray-900 group-hover:text-indigo-600">{{ $book->title }}</span>
                                    <span class="text-xs text-gray-500">Stok: {{ $book->available_stock }}</span>
                                </span>
                            </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('book_ids')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                        <x-secondary-button class="mr-3" onclick="window.history.back()">Batal</x-secondary-button>
                        <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 py-3 px-8">
                            Simpan Peminjaman
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
