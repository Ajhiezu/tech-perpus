<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Auth' }} - {{ config('app.name', 'TechPerpus') }}</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="antialiased font-sans bg-bg-main selection:bg-primary/10 selection:text-primary">
        <div class="min-h-screen flex flex-col md:flex-row shadow-2xl overflow-hidden">
            <!-- Brand Side -->
            <div class="hidden md:flex md:w-1/2 bg-slate-900 items-center justify-center p-20 relative overflow-hidden">
                <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-primary/20 to-transparent"></div>
                <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-600 rounded-full blur-[150px] opacity-10 -mr-48 -mt-48"></div>
                
                <div class="relative z-10 text-center max-w-sm">
                    <div class="w-20 h-20 bg-primary rounded-2xl flex items-center justify-center shadow-2xl mx-auto mb-12 shadow-primary/20">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h2 class="text-4xl font-extrabold text-white mb-6 tracking-tight">The Future of <span class="text-primary">Digital Literacy.</span></h2>
                    <p class="text-slate-400 text-lg leading-relaxed font-medium">
                        Seamlessly manage collections and access knowledge with our integrated SaaS ecosystem.
                    </p>
                </div>
                
                <div class="absolute bottom-12 text-slate-500 text-[10px] font-black uppercase tracking-[0.4em]">
                    &copy; 2026 TechPerpus Ecosystem
                </div>
            </div>

            <!-- Form Side -->
            <div class="flex-1 flex items-center justify-center p-8 sm:p-12 md:p-32 bg-white">
                <div class="w-full max-w-sm animate-in fade-in slide-in-from-right-4 duration-700">
                    <div class="mb-12 flex items-center space-x-2 md:hidden">
                        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <span class="text-xl font-bold tracking-tight">TechPerpus</span>
                    </div>
                    
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>
