<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TechPerpus - Modern Library Ecosystem</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
            body { font-family: 'Outfit', sans-serif; }
        </style>
    </head>
    <body class="antialiased bg-bg-main text-slate-800 selection:bg-primary/10 selection:text-primary">
        
        <!-- Premium Navbar -->
        <nav class="h-24 bg-white/80 backdrop-blur-xl border-b border-slate-200 sticky top-0 z-50 flex items-center">
            <div class="max-w-7xl mx-auto px-6 w-full flex justify-between items-center">
                <div class="flex items-center space-x-3 group cursor-pointer">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-primary/20 group-hover:rotate-12 transition-transform duration-500">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <span class="text-2xl font-extrabold text-slate-900 tracking-tight block leading-none">Tech<span class="text-primary">Perpus</span></span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Ecosystem</span>
                    </div>
                </div>
                
                <div class="hidden lg:flex items-center space-x-10 text-sm font-bold text-slate-500">
                    <a href="#catalog" class="hover:text-primary transition-colors">Catalog</a>
                    <a href="#" class="hover:text-primary transition-colors">Vision</a>
                    <a href="#" class="hover:text-primary transition-colors">API</a>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-premium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-primary px-4 transition-colors">Sign In</a>
                        <a href="{{ route('register') }}" class="btn-premium">Get Started</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <header class="py-24 relative overflow-hidden bg-white">
            <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-[600px] h-[600px] bg-primary/5 rounded-full blur-[120px]"></div>
            <div class="max-w-7xl mx-auto px-6 relative z-10 grid lg:grid-cols-2 gap-16 items-center">
                <div class="text-left">
                    <div class="inline-flex items-center px-4 py-2 bg-primary-light rounded-full text-primary text-xs font-bold mb-8 animate-float">
                        <span class="w-2 h-2 bg-primary rounded-full mr-2 animate-pulse"></span>
                        Trusted by 10,000+ Readers
                    </div>
                    <h1 class="text-6xl md:text-7xl font-extrabold text-slate-900 mb-8 tracking-tight leading-[1.1]">
                        The Future of <br/>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-indigo-600">Digital Literacy.</span>
                    </h1>
                    <p class="text-xl text-slate-500 max-w-xl mb-12 leading-relaxed">
                        A seamless blend of physical browsing and high-speed digital technology designed for the modern intellectual ecosystem.
                    </p>
                    <div class="flex items-center space-x-6">
                        <a href="#catalog" class="btn-premium px-10 py-4 shadow-2xl shadow-primary/30">Explore Library</a>
                        <a href="#" class="btn-premium-outline px-10 py-4">Our Vision</a>
                    </div>
                </div>
                <div class="hidden lg:block relative">
                    <div class="w-[500px] h-[600px] bg-slate-100 rounded-[4rem] overflow-hidden rotate-3 shadow-2xl border-8 border-white">
                        <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2000&auto=format&fit=crop" alt="Library" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-bottom p-12">
                            <div class="text-white">
                                <p class="text-3xl font-bold italic mb-2">"Books are a uniquely portable magic."</p>
                                <p class="text-sm font-bold uppercase tracking-widest text-white/60">— Stephen King</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Catalog Section -->
        <section id="catalog" class="py-32 bg-bg-main">
            <div class="max-w-7xl mx-auto px-6">
                <!-- Header Section -->
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8">
                    <div>
                        <h2 class="text-4xl font-extrabold text-slate-900 mb-4">Curated Masterpieces</h2>
                        <p class="text-slate-500 text-lg max-w-xl">Deep dive into our hand-picked collection of works designed to sharpen your mind and expand your horizons.</p>
                    </div>
                    <a href="#" class="text-primary font-bold flex items-center group">
                        View Full Catalog
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>

                <!-- Grid Content -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                    @forelse($books ?? [] as $book)
                    <div class="card-premium group p-3">
                        <!-- Cover Container -->
                        <div class="w-full aspect-[3/4.5] bg-slate-100 rounded-xl overflow-hidden mb-6 relative">
                            @if($book->image)
                                <img src="{{ asset('storage/'.$book->image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
                                    <svg class="w-20 h-20 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur-md px-3 py-1 text-[10px] font-black text-primary uppercase tracking-widest rounded-full shadow-lg">{{ $book->category->name }}</span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="px-2 pb-4">
                            <h3 class="text-xl font-bold text-slate-900 leading-tight group-hover:text-primary transition-colors line-clamp-1 mb-1">{{ $book->title }}</h3>
                            <p class="text-sm font-semibold text-slate-400 mb-6 italic">{{ $book->author }}</p>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-xs font-bold text-slate-500">
                                    <div class="w-2 h-2 bg-success rounded-full mr-2"></div>
                                    {{ $book->available_stock }} Available
                                </div>
                                <a href="{{ route('public.books.show', $book) }}" class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all shadow-sm">
                                    <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                </a>

                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-32 text-center bg-white rounded-3xl border-4 border-dashed border-slate-100">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <p class="text-slate-400 font-bold text-xl uppercase tracking-widest">No Collections Found</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Premium Footer -->
        <footer class="bg-white border-t border-slate-100 pt-32 pb-16">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-16 mb-24">
                    <div class="col-span-2">
                        <div class="flex items-center space-x-3 mb-8">
                            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <span class="text-2xl font-bold text-slate-900 tracking-tight">TechPerpus</span>
                        </div>
                        <p class="text-lg text-slate-500 leading-relaxed max-w-sm mb-10">
                            Empowering communities through digital innovation and seamless access to human knowledge.
                        </p>
                        <div class="flex space-x-6">
                            <a href="#" class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all shadow-sm">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                            </a>
                            <a href="#" class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all shadow-sm">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-slate-900 uppercase tracking-[0.2em] mb-8">Navigation</h4>
                        <ul class="space-y-4 text-sm font-bold text-slate-500">
                            <li><a href="#" class="hover:text-primary transition-colors">Our Catalog</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Membership Plan</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Knowledge Base</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-slate-900 uppercase tracking-[0.2em] mb-8">Corporate</h4>
                        <ul class="space-y-4 text-sm font-bold text-slate-500">
                            <li><a href="#" class="hover:text-primary transition-colors">About TechKasir</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Privacy Shield</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Cookie Manager</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Footer -->
                <div class="pt-12 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center text-xs font-bold text-slate-400 gap-6">
                    <p>&copy; 2026 TechPerpus Ecosystem. Engineered with Excellence.</p>
                    <div class="flex space-x-8">
                        <a href="#" class="hover:text-primary transition-colors">Security Audit</a>
                        <a href="#" class="hover:text-primary transition-colors">System Status</a>
                    </div>
                </div>
            </div>
        </footer>

    </body>
</html>
