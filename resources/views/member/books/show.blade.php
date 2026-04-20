<x-app-layout>
    <x-slot name="header">
        Detail Koleksi Buku
    </x-slot>

    <div class="max-w-6xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Left: Massive Cover & Status -->
            <div class="lg:col-span-5 space-y-8">
                <div class="bg-white rounded-3xl p-6 shadow-2xl shadow-slate-200 border border-slate-100 group transition-transform hover:scale-[1.02] smooth">
                    <div class="aspect-[3/4] bg-slate-100 rounded-2xl overflow-hidden relative shadow-inner">
                        @if($book->image)
                            <img src="{{ asset('storage/'.$book->image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        @endif
                        
                        <div class="absolute top-6 right-6">
                            <x-badge :variant="$book->available_stock > 0 ? 'emerald' : 'rose'" class="px-6 py-2 shadow-lg">
                                {{ $book->available_stock > 0 ? 'Tersedia di Rak' : 'Sedang Dipinjam' }}
                            </x-badge>
                        </div>
                    </div>
                </div>

                <!-- Info Cards -->
                <div class="grid grid-cols-2 gap-4">
                    <x-card>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Rak Lokasi</p>
                        <p class="text-sm font-bold text-slate-900">{{ $book->location->name }}</p>
                    </x-card>
                    <x-card>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Stok Tersedia</p>
                        <p class="text-sm font-bold text-slate-900">{{ $book->available_stock }} / {{ $book->stock }} Eks</p>
                    </x-card>
                </div>
            </div>

            <!-- Right: Rich Details -->
            <div class="lg:col-span-7 space-y-10">
                <div class="space-y-4">
                    <x-badge variant="indigo" class="px-4 py-1.5">{{ $book->category->name }}</x-badge>
                    <h1 class="text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">{{ $book->title }}</h1>
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs uppercase">
                                {{ substr($book->author, 0, 1) }}
                            </div>
                            <span class="text-sm font-bold text-slate-700">{{ $book->author }}</span>
                        </div>
                        <div class="w-px h-4 bg-slate-200"></div>
                        <span class="text-sm font-medium text-slate-500 italic">ISBN: {{ $book->isbn }}</span>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-900">Sinopsis Koleksi</h3>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Terbit: {{ $book->year }}</span>
                    </div>
                    <p class="text-slate-600 leading-relaxed text-sm lg:text-base font-medium">
                        {{ $book->description ?? 'Deskripsi belum tersedia untuk koleksi ini. Silakan hubungi petugas perpustakaan untuk informasi lebih lanjut mengenai isi dan materi buku.' }}
                    </p>
                </div>

                <div class="space-y-6 pt-6 border-t border-slate-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1 p-4 bg-slate-50 rounded-2xl">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Penerbit</p>
                            <p class="text-sm font-bold text-slate-900">{{ $book->publisher }}</p>
                        </div>
                        <div class="space-y-1 p-4 bg-slate-50 rounded-2xl">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Format</p>
                            <p class="text-sm font-bold text-slate-900">Cetak (Hardcover/Softcover)</p>
                        </div>
                    </div>

                    <div class="pt-4">
                        @auth
                            @if(Auth::user()->isMember())
                                @if($book->available_stock > 0)
                                    <form action="{{ route('member.loans.store') }}" method="POST" class="space-y-4">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Rencana Tanggal Pengembalian</label>
                                            <input type="date" name="due_date" required 
                                                min="{{ now()->addDay()->toDateString() }}" 
                                                max="{{ now()->addDays(14)->toDateString() }}"
                                                value="{{ now()->addDays(7)->toDateString() }}"
                                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all">
                                            <p class="text-[9px] text-slate-400 italic px-1">* Maksimal peminjaman adalah 14 hari.</p>
                                        </div>

                                        <x-button type="submit" class="w-full py-5 text-sm uppercase tracking-[0.2em] shadow-2xl shadow-primary/20" variant="primary">
                                            Ajukan Peminjaman Sekarang
                                        </x-button>
                                    </form>
                                @else
                                    <x-button class="w-full py-5 text-sm uppercase tracking-[0.2em]" variant="outline" disabled>
                                        Sedang Tidak Tersedia (Stok Habis)
                                    </x-button>
                                @endif
                            @else
                                <!-- Shortcut for Admin/Staff -->
                                <div class="p-6 bg-slate-50 rounded-3xl border border-dashed border-slate-200 text-center space-y-4">
                                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Panel Pintar Petugas</p>
                                    <a href="{{ route((Auth::user()->isAdmin() ? 'admin' : 'staff') . '.loans.create') }}" class="block">
                                        <x-button class="w-full py-4 text-xs uppercase tracking-[0.2em] shadow-xl" variant="primary">
                                            Catat Peminjaman Member
                                        </x-button>
                                    </a>
                                    <p class="text-[10px] text-slate-400 font-medium italic">* Gunakan tombol ini untuk mencatat peminjaman member di rak ini.</p>
                                </div>

                            @endif
                        @else

                            <div class="space-y-4">
                                <a href="{{ route('login') }}" class="block w-full">
                                    <x-button class="w-full py-5 text-sm uppercase tracking-[0.2em] shadow-2xl shadow-primary/20" variant="primary">
                                        Masuk untuk Meminjam
                                    </x-button>
                                </a>
                                <p class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    Belum punya akun? <a href="{{ route('register') }}" class="text-primary hover:underline">Daftar sekarang</a>
                                </p>
                            </div>
                        @endauth
                        
                        <p class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-6">
                            * Syarat & Ketentuan Peminjaman Berlaku
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
