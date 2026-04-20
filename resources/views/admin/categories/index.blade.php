<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Manajemen Kategori') }}
        </h2>
    </x-slot>

    <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <!-- Add & Search Toolbar -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <x-card class="lg:col-span-1 border-primary/10">
                <x-slot name="header">Tambah Kategori</x-slot>
                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <x-input label="Nama Kategori" name="name" placeholder="Contoh: Sains, Novel" required :error="$errors->first('name')" />
                    <x-button type="submit" class="w-full">Simpan Kategori</x-button>
                </form>
            </x-card>

            <div class="lg:col-span-2 space-y-6">
                <x-card>
                    <x-slot name="header">Daftar Koleksi Kategori</x-slot>
                    
                    <form action="{{ route('admin.categories.index') }}" method="GET" class="mb-6 flex gap-4">
                        <div class="flex-1 relative group">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..." 
                                class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all smooth">
                            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary smooth" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <x-button type="submit" variant="primary">Cari</x-button>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Nama</th>
                                    <th class="px-4 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Info</th>
                                    <th class="px-4 py-3 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($categories as $category)
                                <tr class="group hover:bg-slate-50/50 transition-colors" x-data="{ editing: false, name: '{{ $category->name }}' }">
                                    <td class="px-4 py-4">
                                        <template x-if="!editing">
                                            <span class="text-sm font-bold text-slate-900">{{ $category->name }}</span>
                                        </template>
                                        <template x-if="editing">
                                            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="flex gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <input type="text" name="name" x-model="name" class="text-sm font-bold border-slate-200 rounded-lg focus:ring-primary/20 focus:border-primary px-2 py-1 w-full">
                                                <button type="submit" class="text-primary"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></button>
                                                <button type="button" @click="editing = false" class="text-slate-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                            </form>
                                        </template>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <x-badge variant="indigo">{{ $category->books()->count() }} Koleksi</x-badge>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="flex justify-end space-x-2">
                                            <button @click="editing = true" class="p-2 text-slate-400 hover:text-amber-500 transition-colors hover:bg-amber-50 rounded-lg">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-500 transition-colors hover:bg-rose-50 rounded-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-12 text-center text-slate-400 text-sm italic">Belum ada kategori ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $categories->links() }}
                    </div>
                </x-card>
            </div>
        </div>
    </div>

</x-app-layout>
