<x-app-layout>
    <x-slot name="header">
        Ringkasan Dashboard
    </x-slot>

    <div class="space-y-10 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <!-- Statistik Utama -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @if(Auth::user()->isAdmin() || Auth::user()->isStaff())
                <x-card>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Buku</p>
                            <h4 class="text-2xl font-bold text-slate-900">{{ $stats['total_books'] }}</h4>
                        </div>
                    </div>
                </x-card>

                <x-card>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Member Aktif</p>
                            <h4 class="text-2xl font-bold text-slate-900">{{ $stats['total_members'] }}</h4>
                        </div>
                    </div>
                </x-card>

                <x-card>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Peminjaman</p>
                            <h4 class="text-2xl font-bold text-slate-900">{{ $stats['active_loans'] }}</h4>
                        </div>
                    </div>
                </x-card>

                <x-card>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-600 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Terlambat</p>
                            <h4 class="text-2xl font-bold text-slate-900">{{ $stats['overdue_loans'] }}</h4>
                        </div>
                    </div>
                </x-card>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Table Aktivitas -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between px-2">
                    <h3 class="font-bold text-slate-900">Aktivitas Terkini</h3>
                    <x-button variant="ghost" size="sm" onclick="window.location='{{ route('activities.index') }}'">Lihat Semua</x-button>
                </div>

                <x-table :headers="['Koleksi / Member', 'Status', 'Durasi']">
                    @foreach($activities as $activity)
                        <tr class="group transition-colors hover:bg-slate-50/50">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 font-bold group-hover:scale-110 smooth">
                                        {{ substr(Auth::user()->isMember() ? $activity->title : $activity->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900 leading-none">
                                            {{ Auth::user()->isMember() ? $activity->title : $activity->user->name }}
                                        </p>
                                        <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-widest font-bold">
                                            {{ Auth::user()->isMember() ? $activity->author : ($activity->loan_code ?? 'Loan Action') }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if(Auth::user()->isMember())
                                    <x-badge variant="slate">Catalog Update</x-badge>
                                @else
                                    <x-badge :variant="$activity->status === 'borrowed' ? 'indigo' : 'emerald'">
                                        {{ ucfirst($activity->status) }}
                                    </x-badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-slate-500 italic">
                                {{ $activity->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            </div>

            <!-- Profile Info Card -->
            <div class="space-y-6">
                <div class="flex items-center justify-between px-2">
                    <h3 class="font-bold text-slate-900">Profil Saya</h3>
                </div>
                <x-card>
                    <div class="text-center py-4">
                        <div class="w-20 h-20 bg-primary/10 text-primary border-4 border-white ring-2 ring-primary/5 rounded-2xl mx-auto flex items-center justify-center text-2xl font-bold mb-4 shadow-xl">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h4 class="text-lg font-bold text-slate-900">{{ Auth::user()->name }}</h4>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">{{ Auth::user()->role }}</p>
                    </div>
                    
                    <div class="mt-8 pt-6 border-t border-slate-100 space-y-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500 font-medium">Terdaftar Sejak</span>
                            <span class="text-slate-900 font-bold">{{ Auth::user()->created_at->format('M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500 font-medium">Status Akun</span>
                            <x-badge variant="emerald">Terverifikasi</x-badge>
                        </div>
                    </div>

                    <div class="mt-8">
                        <x-button variant="outline" class="w-full" onclick="window.location='{{ route('profile.edit') }}'">
                            Pengaturan Akun
                        </x-button>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</x-app-layout>
