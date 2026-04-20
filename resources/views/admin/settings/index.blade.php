<x-app-layout>
    <x-slot name="header">
        Pengaturan Sistem
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Sidebar Info -->
            <div class="md:col-span-1 space-y-6">
                <div class="bg-indigo-600 rounded-2xl p-6 text-white shadow-xl shadow-indigo-600/20">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Konfigurasi Library</h3>
                    <p class="text-indigo-100 text-sm leading-relaxed">Sesuaikan parameter operasional perpustakaan untuk mengoptimalkan kinerja dan kedisiplinan anggota.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Bantuan</h4>
                    <p class="text-xs text-slate-500 leading-relaxed italic">"Denda keterlambatan digunakan untuk menghitung total denda secara otomatis saat anggota mengembalikan buku melewati batas waktu."</p>
                </div>
            </div>

            <!-- Settings Form -->
            <div class="md:col-span-2">
                <x-card>
                    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <h3 class="text-slate-900 font-bold mb-1">Denda & Keuangan</h3>
                                <p class="text-xs text-slate-400 font-medium">Atur nominal denda untuk berbagai skenario peminjaman.</p>
                            </div>

                            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 space-y-6">
                                <x-input 
                                    label="Denda Keterlambatan Per Hari (Rp)" 
                                    name="late_fine_per_day" 
                                    type="number" 
                                    placeholder="Contoh: 1000"
                                    value="{{ old('late_fine_per_day', $settings['late_fine_per_day'] ?? 1000) }}"
                                    required
                                    min="0"
                                    :error="$errors->first('late_fine_per_day')"
                                />
                                <p class="text-[10px] text-slate-400 italic px-2">* Nilai ini akan dikalikan dengan jumlah hari keterlambatan saat pengembalian.</p>
                            </div>

                            <div class="pt-6 border-t border-slate-100">
                                <x-button type="submit" class="w-full">
                                    Simpan Perubahan Pengaturan
                                </x-button>
                            </div>
                        </div>
                    </form>
                </x-card>
            </div>
        </div>
    </div>
</x-app-layout>
