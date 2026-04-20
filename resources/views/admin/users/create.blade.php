<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.users.index') }}" class="p-1 px-2 hover:bg-slate-100 rounded-lg transition-colors text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-xl font-bold text-slate-900">Registrasi Pengguna Baru</h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="premium-card p-8">
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-10">
                @csrf
                
                <!-- Section 1: Profil Dasar -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-2 pb-2 border-b border-slate-100">
                        <div class="w-2 h-2 bg-indigo-500 rounded-full"></div>
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Identitas & Akses</h3>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block px-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama sesuai KTP" required
                                class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block px-1">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required
                                class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block px-1">Hak Akses (Role)</label>
                            <select name="role" required
                                class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                                <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member / Pembaca</option>
                                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Petugas Perpustakaan</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin / Pengelola</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block px-1">Nomor Telepon/WA</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx"
                                class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block px-1">Alamat Domisili</label>
                        <textarea name="address" rows="3" placeholder="Masukkan alamat lengkap..."
                            class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">{{ old('address') }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                </div>

                <!-- Section 2: Keamanan -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-2 pb-2 border-b border-slate-100">
                        <div class="w-2 h-2 bg-rose-500 rounded-full"></div>
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Kredensial & Keamanan</h3>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6 bg-slate-50/50 p-6 rounded-2xl border border-slate-100 italic">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block px-1">Kata Sandi</label>
                            <input type="password" name="password" required
                                class="w-full px-4 py-3 bg-white border-slate-200 rounded-xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block px-1">Ulangi Kata Sandi</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-4 py-3 bg-white border-slate-200 rounded-xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-8 border-t border-slate-100 flex items-center justify-between">
                    <p class="text-[10px] text-slate-400 italic">* Semua data di atas dapat diubah kembali nanti oleh Admin.</p>
                    <div class="flex space-x-4">
                        <x-button type="button" variant="outline" onclick="window.history.back()">Batal</x-button>
                        <x-button type="submit" variant="primary" class="px-8 shadow-lg shadow-primary/20">
                            Simpan Data Pengguna
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
