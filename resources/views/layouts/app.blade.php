<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TechPerpus') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>

<body class="font-sans antialiased text-slate-800 bg-bg-main selection:bg-primary/20 selection:text-primary">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: true, mobileSidebarOpen: false }">

        <!-- Sidebar: Fixed Desktop, Off-canvas Mobile -->
        <aside
            class="fixed inset-y-0 left-0 z-50 bg-white border-r border-slate-200 transition-all duration-300 transform lg:translate-x-0 flex flex-col"
            :class="{
                    'w-64': sidebarOpen, 
                    'w-20': !sidebarOpen,
                    'translate-x-0': mobileSidebarOpen,
                    '-translate-x-full': !mobileSidebarOpen
                }">
            <!-- Brand logo area -->
            <div class="h-20 flex items-center px-6 border-b border-slate-100 flex-shrink-0 overflow-hidden">

                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 flex-shrink-0">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-primary to-indigo-600 flex-shrink-0 flex items-center justify-center rounded-xl text-white shadow-lg shadow-primary/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-slate-900 transition-all duration-300"
                        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 -translate-x-10 w-0'">Tech<span
                            class="text-primary">Perpus</span></span>
                </a>
            </div>

            <!-- Navigation Sidebar Links -->
            <nav class="flex-1 px-3 py-4 space-y-2 overflow-y-auto custom-scrollbar">

                <div class="px-3 mb-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]"
                    x-show="sidebarOpen">Menu Utama</div>

                <a href="{{ route('dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-active' : 'sidebar-inactive' }}"
                    x-data="{ tooltip: false }" @mouseenter="!sidebarOpen ? tooltip = true : null"
                    @mouseleave="tooltip = false">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Dashboard</span>

                    <!-- Tooltip -->
                    <div x-show="tooltip" x-cloak
                        class="absolute left-full ml-2 px-2 py-1 bg-slate-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                        Dashboard</div>
                </a>

                <a href="{{ route('activities.index') }}"
                    class="sidebar-link {{ request()->routeIs('activities.index') ? 'sidebar-active' : 'sidebar-inactive' }}"
                    x-data="{ tooltip: false }" @mouseenter="!sidebarOpen ? tooltip = true : null"
                    @mouseleave="tooltip = false">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Aktivitas</span>

                    <!-- Tooltip -->
                    <div x-show="tooltip" x-cloak
                        class="absolute left-full ml-2 px-2 py-1 bg-slate-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                        Riwayat Log</div>
                </a>

                @if(!Auth::user()->isMember())
                    <a href="{{ route('admin.settings.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'sidebar-active' : 'sidebar-inactive' }}"
                        x-data="{ tooltip: false }" @mouseenter="!sidebarOpen ? tooltip = true : null"
                        @mouseleave="tooltip = false">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                            :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Pengaturan</span>

                        <div x-show="tooltip" x-cloak
                            class="absolute left-full ml-2 px-2 py-1 bg-slate-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                            Konfigurasi Sistem</div>
                    </a>
                @endif



                @if(Auth::user()->isMember())
                    <a href="{{ route('member.loans.index') }}"
                        class="sidebar-link {{ request()->routeIs('member.loans.index') ? 'sidebar-active' : 'sidebar-inactive' }}"
                        x-data="{ tooltip: false }" @mouseenter="!sidebarOpen ? tooltip = true : null"
                        @mouseleave="tooltip = false">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                            :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Pinjaman Saya</span>

                        <div x-show="tooltip" x-cloak
                            class="absolute left-full ml-2 px-2 py-1 bg-slate-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                            Buku yang Dipinjam</div>
                    </a>
                @endif



                @if(Auth::user()->isAdmin() || Auth::user()->isStaff())
                    <div class="px-3 mt-6 mb-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]"
                        x-show="sidebarOpen">Koleksi & Ruang</div>

                    <a href="{{ route('admin.books.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.books.*') ? 'sidebar-active' : 'sidebar-inactive' }}"
                        x-data="{ tooltip: false }" @mouseenter="!sidebarOpen ? tooltip = true : null"
                        @mouseleave="tooltip = false">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                            :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Buku</span>

                        <div x-show="tooltip" x-cloak
                            class="absolute left-full ml-2 px-2 py-1 bg-slate-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                            Data Buku</div>
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'sidebar-active' : 'sidebar-inactive' }}"
                        x-data="{ tooltip: false }" @mouseenter="!sidebarOpen ? tooltip = true : null"
                        @mouseleave="tooltip = false">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                        <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                            :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Kategori</span>

                        <div x-show="tooltip" x-cloak
                            class="absolute left-full ml-2 px-2 py-1 bg-slate-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                            Kategori</div>
                    </a>

                    <a href="{{ route('admin.locations.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.locations.*') ? 'sidebar-active' : 'sidebar-inactive' }}"
                        x-data="{ tooltip: false }" @mouseenter="!sidebarOpen ? tooltip = true : null"
                        @mouseleave="tooltip = false">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                            :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Lokasi</span>

                        <div x-show="tooltip" x-cloak
                            class="absolute left-full ml-2 px-2 py-1 bg-slate-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                            Lokasi Rak</div>
                    </a>

                    @if(Auth::user()->role === 'admin')
                        <!-- Manajemen Petugas -->
                        <div class="space-y-1 mb-4">
                            <a href="{{ route('admin.users.index', ['role' => 'staff']) }}"
                                class="sidebar-link {{ request('role') == 'staff' && !request()->routeIs('admin.users.create') ? 'sidebar-active' : 'sidebar-inactive' }}"
                                x-data="{ tooltip: false }" @mouseenter="!sidebarOpen ? tooltip = true : null"
                                @mouseleave="tooltip = false">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                                    :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Manajemen
                                    Petugas</span>
                                <div x-show="tooltip"
                                    class="absolute left-full ml-2 px-2 py-1 bg-slate-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                                    Staff Management</div>
                            </a>
                        </div>

                        <!-- Manajemen Member -->
                        <div class="mb-6 space-y-1 border-b border-slate-100 pb-4">
                            <a href="{{ route('admin.users.index', ['role' => 'member']) }}"
                                class="sidebar-link {{ request('role') == 'member' && !request()->routeIs('admin.users.create') ? 'sidebar-active' : 'sidebar-inactive' }}"
                                x-data="{ tooltip: false }" @mouseenter="!sidebarOpen ? tooltip = true : null"
                                @mouseleave="tooltip = false">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                                <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                                    :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Manajemen
                                    Member</span>
                                <div x-show="tooltip"
                                    class="absolute left-full ml-2 px-2 py-1 bg-slate-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                                    Member Management</div>
                            </a>
                        </div>
                    @endif

                    <div class="px-3 mt-6 mb-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]"
                        x-show="sidebarOpen">Transaksi</div>
                    <a href="{{ route((Auth::user()->isAdmin() ? 'admin' : 'staff') . '.loans.index') }}"
                        class="sidebar-link {{ request()->routeIs('*.loans.*') ? 'sidebar-active' : 'sidebar-inactive' }}"
                        x-data="{ tooltip: false }" @mouseenter="!sidebarOpen ? tooltip = true : null"
                        @mouseleave="tooltip = false">

                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                            :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Peminjaman</span>

                        <div x-show="tooltip" x-cloak
                            class="absolute left-full ml-2 px-2 py-1 bg-slate-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                            Transaksi</div>
                    </a>

                    <a href="{{ route('admin.reports.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'sidebar-active' : 'sidebar-inactive' }}"
                        x-data="{ tooltip: false }" @mouseenter="!sidebarOpen ? tooltip = true : null"
                        @mouseleave="tooltip = false">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                            :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Laporan</span>

                        <div x-show="tooltip" x-cloak
                            class="absolute left-full ml-2 px-2 py-1 bg-slate-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                            Reports & Analytic</div>
                    </a>





                @endif


                <div class="px-3 mt-6 mb-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]"
                    x-show="sidebarOpen">Lainnya</div>
                <a href="{{ url('/') }}" class="sidebar-link sidebar-inactive" x-data="{ tooltip: false }"
                    @mouseenter="!sidebarOpen ? tooltip = true : null" @mouseleave="tooltip = false">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                        </path>
                    </svg>
                    <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Katalog Publik</span>

                    <div x-show="tooltip" x-cloak
                        class="absolute left-full ml-2 px-2 py-1 bg-slate-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                        Landing Page</div>
                </a>
            </nav>

            <!-- Bottom Sidebar Profile logout -->
            <div class="p-4 border-t border-slate-100 bg-white flex-shrink-0">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-4 py-3 text-sm font-bold text-rose-500 hover:bg-rose-50 rounded-xl transition-all group overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        <span class="ml-3 transition-all duration-300 whitespace-nowrap"
                            :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Keluar Sistem</span>
                    </button>
                </form>
            </div>
        </aside>


        <!-- Main Content -->
        <div class="flex-1 min-w-0 transition-all duration-300" :class="sidebarOpen ? 'lg:pl-64' : 'lg:pl-20'">
            <!-- Topbar -->
            <header
                class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40 flex items-center justify-between px-8">
                <div class="flex items-center space-x-6">
                    <button @click="sidebarOpen = !sidebarOpen; mobileSidebarOpen = !mobileSidebarOpen"
                        class="w-10 h-10 flex items-center justify-center hover:bg-slate-100 rounded-xl transition-colors text-slate-500 shadow-sm border border-slate-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <div class="hidden md:block relative w-96 group">
                        <input type="text" placeholder="Cari Koleksi, Member, atau Aktivitas..."
                            class="w-full pl-12 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-primary/5 focus:border-primary focus:bg-white transition-all">
                        <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <div class="flex items-center space-x-6">
                    <div class="flex items-center space-x-4 pr-6 border-r border-slate-100">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-black text-slate-900 leading-none mb-1">{{ Auth::user()->name }}</p>
                            <span
                                class="px-2 py-0.5 bg-primary-light text-[10px] font-black text-primary uppercase tracking-[0.1em] rounded-md">{{ Auth::user()->role }}</span>
                        </div>
                        <div
                            class="w-11 h-11 bg-gradient-to-br from-slate-100 to-slate-200 rounded-2xl flex items-center justify-center text-slate-500 font-black border-2 border-white ring-4 ring-slate-50 uppercase shadow-sm transition-transform hover:scale-105 active:scale-95 cursor-pointer">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>

                    <a href="{{ route('profile.edit') }}"
                        class="w-10 h-10 flex items-center justify-center hover:bg-slate-100 rounded-xl transition-all text-slate-400 hover:text-primary border border-transparent hover:border-slate-200 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </a>
                </div>
            </header>

            <!-- Page Content Area -->
            <main class="px-8 lg:px-12 py-12">
                @isset($header)
                    <div class="mb-12 flex flex-col md:flex-row md:items-end md:justify-between gap-6">
                        <div class="space-y-2">
                            <h1 class="text-4xl font-black text-slate-900 tracking-tight">{{ $header }}</h1>
                            <p class="text-lg text-slate-500 font-medium">Pengelolaan ekosistem perpustakaan digital cerdas.
                            </p>
                        </div>

                        @isset($actions)
                            <div class="flex space-x-4">
                                {{ $actions }}
                            </div>
                        @endisset
                    </div>
                @endisset

                <div class="animate-in fade-in slide-in-from-bottom-4 duration-700">
                    {{ $slot }}
                </div>
            </main>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Operasi Berhasil',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#4F46E5',
                    customClass: {
                        popup: 'rounded-3xl border-0 shadow-2xl',
                        confirmButton: 'rounded-2xl px-10 py-4 font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-primary/20'
                    }
                });
            @endif
            });
    </script>
    @stack('scripts')
</body>

</html>