<x-app-layout>
    <x-slot name="header">
        Eksplorasi Katalog
    </x-slot>

    <div class="space-y-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <!-- Header Section -->
        <div class="text-center md:text-left space-y-2">
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Karya Unggulan</h1>
            <p class="text-slate-500 font-medium">Temukan inspirasi dan pengetahuan baru dari koleksi terbaik kami.</p>
        </div>

        <!-- Search & Filter Area -->
        <form action="{{ route('member.books.index') }}" method="GET" class="flex flex-col md:flex-row gap-6 items-center">
            <div class="flex-1 w-full relative group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul buku, penulis, atau ISBN..." 
                    class="w-full pl-12 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all shadow-sm">
                <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary smooth" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <div class="flex space-x-2 overflow-x-auto pb-2 scrollbar-hide">
                <x-button type="button" variant="{{ !request('category') ? 'primary' : 'outline' }}" size="sm" class="flex-shrink-0" onclick="window.location='{{ route('member.books.index') }}'">
                    Semua
                </x-button>
                @foreach($categories ?? [] as $category)
                    <x-button type="button" variant="{{ request('category') == $category->slug ? 'primary' : 'outline' }}" size="sm" class="flex-shrink-0" 
                        onclick="window.location='{{ route('member.books.index', ['category' => $category->slug, 'search' => request('search')]) }}'">
                        {{ $category->name }}
                    </x-button>
                @endforeach
            </div>
        </form>


        <!-- Book Grid: cols-4 Desktop, cols-2 Tablet, cols-1 Mobile -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($books as $book)
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                    <!-- Icon / Cover container -->
                    <div class="w-full aspect-[3/4] bg-slate-100 rounded-lg overflow-hidden mb-5 flex items-center justify-center text-slate-300 relative">
                        @if($book->image)
                            <img src="{{ asset('storage/'.$book->image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-16 h-16 flex items-center justify-center bg-slate-200 rounded-full text-slate-400 group-hover:bg-primary/10 group-hover:text-primary smooth">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        @endif
                        
                        <div class="absolute top-3 right-3">
                            <x-badge :variant="$book->available_stock > 0 ? 'emerald' : 'rose'">
                                {{ $book->available_stock > 0 ? 'Tersedia' : 'Kosong' }}
                            </x-badge>
                        </div>
                    </div>

                    <!-- Content Hierarchy -->
                    <div class="space-y-1 mb-6">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">{{ $book->category->name }}</p>
                        <h3 class="text-lg font-semibold text-slate-900 leading-tight group-hover:text-primary transition-colors line-clamp-1">{{ $book->title }}</h3>
                        <p class="text-sm text-slate-500 font-medium">Oleh: {{ $book->author }}</p>
                    </div>

                    <!-- Divider & Action -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div class="flex items-center space-x-2 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-[10px] font-bold uppercase tracking-wider">{{ $book->location->name }}</span>
                        </div>
                        <a href="{{ route('member.books.show', $book) }}" class="text-xs font-bold text-primary hover:underline">Detail</a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-slate-500 font-medium">Buku tidak ditemukan dalam katalog.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $books->links() }}
        </div>
    </div>
</x-app-layout>
