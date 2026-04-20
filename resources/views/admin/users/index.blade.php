<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">
                @if(request('role') == 'staff')
                    Manajemen Petugas Perpustakaan
                @elseif(request('role') == 'member')
                    Manajemen Member & Pembaca
                @else
                    Seluruh Pengguna Sistem
                @endif
            </h2>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-button variant="primary"
            onclick="window.location='{{ route('admin.users.create', ['role' => request('role')]) }}'"
            class="shadow-lg shadow-primary/20">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah {{ request('role') == 'staff' ? 'Petugas' : (request('role') == 'member' ? 'Member' : 'User') }}
        </x-button>
    </x-slot>

    <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <!-- Search & Filter Toolbar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
            <form action="{{ route('admin.users.index') }}" method="GET"
                class="flex flex-col md:flex-row gap-4 items-end">
                <input type="hidden" name="role" value="{{ request('role') }}">

                <div class="flex-1 w-full space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Cari Nama atau
                        Email</label>
                    <div class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Ketik kata kunci pencarian..."
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-slate-100 rounded-xl text-sm focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary smooth"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                @if(!request('role'))
                    <div class="w-full md:w-48 space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Filter
                            Akses</label>
                        <select name="role_filter" onchange="this.form.role.value = this.value; this.form.submit()"
                            class="w-full px-4 py-2.5 bg-slate-50 border-slate-100 rounded-xl text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Petugas</option>
                            <option value="member" {{ request('role') == 'member' ? 'selected' : '' }}>Member</option>
                        </select>
                    </div>
                @endif

                <div class="flex space-x-2">
                    <x-button type="submit" variant="primary" class="px-6">Cari</x-button>
                    @if(request('search'))
                        <x-button type="button" variant="outline"
                            onclick="window.location='{{ route('admin.users.index', ['role' => request('role')]) }}'">
                            Reset
                        </x-button>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table View -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Daftar
                    {{ request('role') == 'staff' ? 'Petugas' : (request('role') == 'member' ? 'Member' : 'Pengguna') }}
                </h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total: {{ $users->total() }}
                    Data</p>
            </div>

            <x-table :headers="['Profil Pengguna', 'Hak Akses', 'Informasi Kontak', 'Aksi']">
                @forelse($users as $user)
                    <tr class="group transition-colors hover:bg-slate-50/50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-11 h-11 bg-gradient-to-br from-slate-100 to-slate-200 rounded-2xl flex items-center justify-center text-slate-600 font-black border-2 border-white ring-1 ring-slate-100 shadow-sm group-hover:scale-110 smooth transition-transform uppercase">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p
                                        class="text-sm font-bold text-slate-900 leading-tight group-hover:text-primary smooth transition-colors">
                                        {{ $user->name }}
                                    </p>
                                    <p class="text-[11px] text-slate-400 mt-0.5 font-medium">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->role === 'admin')
                                <x-badge variant="indigo" class="font-bold border-indigo-100 shadow-sm">ADMINISTRATOR</x-badge>
                            @elseif($user->role === 'staff')
                                <x-badge variant="blue" class="font-bold border-blue-100 shadow-sm">PETUGAS PERPUS</x-badge>
                            @else
                                <x-badge variant="slate" class="font-bold border-slate-200 shadow-sm">MEMBER PEMBACA</x-badge>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-2 text-sm">

                                <!-- Phone -->
                                <div class="flex items-center gap-2 text-slate-600">
                                    <div class="w-6 h-6 flex items-center justify-center bg-slate-100 rounded-lg">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-slate-700">
                                        {{ $user->phone ?? '-' }}
                                    </span>
                                </div>

                                <!-- Address -->
                                <div class="flex items-start gap-2 text-slate-500">
                                    <div class="w-6 h-6 flex items-center justify-center bg-slate-100 rounded-lg mt-0.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-xs leading-relaxed line-clamp-2">
                                        {{ $user->address ?? 'Alamat belum diatur' }}
                                    </p>
                                </div>

                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-1 justify-end">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="p-2 text-slate-400 hover:text-primary transition-all hover:bg-primary/5 rounded-xl group/btn">
                                    <svg class="w-5 h-5 group-hover/btn:scale-110 smooth" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </a>
                                @if(Auth::id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-slate-400 hover:text-rose-600 transition-all hover:bg-rose-50 rounded-xl group/btn">
                                            <svg class="w-5 h-5 group-hover/btn:scale-110 smooth" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                </div>
                                <h4 class="text-sm font-bold text-slate-900">Data Tidak Ditemukan</h4>
                                <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">Gunakan kata kunci atau
                                    filter lain</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </div>

        <div class="mt-8">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</x-app-layout>