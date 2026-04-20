<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.users.index') }}" class="p-1 px-2 hover:bg-slate-100 rounded-lg transition-colors text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-xl font-bold text-slate-900">Edit Profil Pengguna</h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="premium-card p-8">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-10">
                @csrf
                @method('PUT')
                
                <!-- Profile Header Card -->
                <div class="flex items-center space-x-6 p-6 bg-slate-50 rounded-2xl border border-slate-100">
                    <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white text-2xl font-bold shadow-lg shadow-indigo-600/20">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 leading-tight">{{ $user->name }}</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $user->email }}</p>
                        <x-badge variant="{{ $user->role === 'admin' ? 'indigo' : ($user->role === 'staff' ? 'blue' : 'slate') }}" class="mt-2">
                            {{ ucfirst($user->role) }}
                        </x-badge>
                    </div>
                </div>

                <!-- Section 1: Data Utama -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-2 pb-2 border-b border-slate-100">
                        <div class="w-2 h-2 bg-indigo-500 rounded-full"></div>
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Informasi Dasar</h3>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block px-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block px-1">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block px-1">Role / Hak Akses</label>
                            <select name="role" required
                                class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                                <option value="member" {{ old('role', $user->role) == 'member' ? 'selected' : '' }}>Member / Pembaca</option>
                                <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Petugas Perpustakaan</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin / Pengelola</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block px-1">Nomor WA/Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block px-1">Alamat Lengkap</label>
                        <textarea name="address" rows="3"
                            class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">{{ old('address', $user->address) }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                </div>

                <!-- Section 2: Keamanan (Opsional) -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-2 pb-2 border-b border-slate-100">
                        <div class="w-2 h-2 bg-rose-500 rounded-full"></div>
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Ubah Keamanan (Opsional)</h3>
                    </div>

                    <div class="p-4 bg-rose-50 rounded-xl border border-rose-100 flex items-start space-x-3 mb-4">
                        <svg class="w-5 h-5 text-rose-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-[10px] text-rose-600 font-medium leading-relaxed">Kosongkan kolom password di bawah jika Anda tidak ingin mengubah kata sandi pengguna ini.</p>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block px-1">Password Baru</label>
                            <input type="password" name="password" placeholder="••••••••"
                                class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block px-1">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" placeholder="••••••••"
                                class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-8 border-t border-slate-100 flex items-center justify-end space-x-4">
                    <x-button type="button" variant="outline" onclick="window.history.back()">Batal</x-button>
                    <x-button type="submit" variant="primary" class="px-8 shadow-lg shadow-primary/20">
                        Perbarui Data Pengguna
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
