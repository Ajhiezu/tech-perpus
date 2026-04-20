<x-app-layout>
    <x-slot name="header">
        Tambah Koleksi Baru
    </x-slot>

    <div class="max-w-4xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-700">
        <x-card>
            <x-slot name="header">Formulir Pendaftaran Buku</x-slot>

            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <x-input 
                            label="Judul Lengkap Koleksi" 
                            name="title" 
                            id="title" 
                            :value="old('title')" 
                            required 
                            placeholder="Contoh: Belajar Laravel 11 untuk Pemula"
                            :error="$errors->first('title')"
                        />
                    </div>

                    <!-- Author -->
                    <x-input 
                        label="Penulis / Pengarang" 
                        name="author" 
                        id="author" 
                        :value="old('author')" 
                        required 
                        placeholder="Nama Penulis"
                        :error="$errors->first('author')"
                    />

                    <!-- ISBN -->
                    <x-input 
                        label="Nomor ISBN" 
                        name="isbn" 
                        id="isbn" 
                        :value="old('isbn')" 
                        required 
                        placeholder="978-3-16-148410-0"
                        :error="$errors->first('isbn')"
                    />

                    <!-- Category -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 px-1">Kategori Buku</label>
                        <select name="category_id" class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all smooth">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 px-1">Lokasi Rak</label>
                        <select name="location_id" class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all smooth">
                            <option value="">Pilih Lokasi</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('location_id')" class="mt-2" />
                    </div>

                    <!-- Stock -->
                    <x-input 
                        label="Jumlah Stok (Eks)" 
                        type="number" 
                        name="stock" 
                        id="stock" 
                        :value="old('stock', 0)" 
                        required 
                        min="0"
                        :error="$errors->first('stock')"
                    />

                    <!-- Year -->
                    <x-input 
                        label="Tahun Terbit" 
                        type="number" 
                        name="year" 
                        id="year" 
                        :value="old('year', date('Y'))" 
                        required 
                        :error="$errors->first('year')"
                    />

                    <!-- Price -->
                    <x-input 
                        label="Harga Buku (Rp)" 
                        type="number" 
                        name="price" 
                        id="price" 
                        :value="old('price', 0)" 
                        required 
                        min="0"
                        placeholder="Contoh: 150000"
                        :error="$errors->first('price')"
                    />

                    <!-- Fine Configuration -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 px-1">Aturan Denda Kerusakan</label>
                        <div class="flex gap-4">
                            <select name="fine_type" id="fine_type" class="w-1/3 px-4 py-3 bg-slate-50 border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all smooth">
                                <option value="fixed" {{ old('fine_type') == 'fixed' ? 'selected' : '' }}>Tetap (Fixed)</option>
                                <option value="multiplier" {{ old('fine_type') == 'multiplier' ? 'selected' : '' }}>Kali lipat (x)</option>
                                <option value="custom" {{ old('fine_type') == 'custom' ? 'selected' : '' }}>Manual</option>
                            </select>
                            <input type="text" name="fine_value" id="fine_value" value="{{ old('fine_value', '50000') }}" 
                                class="flex-1 px-4 py-3 bg-slate-50 border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all smooth"
                                placeholder="Nominal / Multiplier (e.g. 1x)">
                        </div>
                        <x-input-error :messages="$errors->get('fine_type')" class="mt-2" />
                        <x-input-error :messages="$errors->get('fine_value')" class="mt-2" />
                    </div>


                    <!-- Publisher -->
                    <div class="md:col-span-2">
                        <x-input 
                            label="Nama Penerbit" 
                            name="publisher" 
                            id="publisher" 
                            :value="old('publisher')" 
                            required 
                            placeholder="Nama Perusahaan Penerbit"
                            :error="$errors->first('publisher')"
                        />
                    </div>


                    <!-- Image Cover -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 px-1">Sampul Koleksi (URL / File)</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="image_input" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-200 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-all smooth">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-slate-400" id="upload_icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="mb-2 text-sm text-slate-500" id="upload_text"><span class="font-bold">Klik untuk upload</span> atau drag and drop</p>
                                    <p class="text-[9px] text-slate-400 tracking-widest uppercase font-bold" id="filename_display">PNG, JPG atau WEBP (Max. 2MB)</p>
                                </div>
                                <input type="file" name="image" id="image_input" class="hidden" onchange="previewFilename(this)" />
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 px-1">Sinopsis Ringkas</label>
                        <textarea name="description" rows="5" class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all smooth" placeholder="Masukkan ringkasan materi atau sinopsis buku...">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-100 flex items-center justify-end space-x-3">
                    <x-button variant="outline" type="button" onclick="window.location='{{ route('admin.books.index') }}'">Batal</x-button>
                    <x-button type="submit">Simpan ke Katalog</x-button>
                </div>
            </form>
        </x-card>
    </div>

    @push('scripts')
    <script>
        function previewFilename(input) {
            const display = document.getElementById('filename_display');
            const text = document.getElementById('upload_text');
            const icon = document.getElementById('upload_icon');
            
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                display.innerText = "File terpilih: " + fileName;
                display.classList.remove('text-slate-400');
                display.classList.add('text-primary', 'text-[11px]');
                text.innerHTML = '<span class="font-bold text-success">Siap untuk diunggah!</span>';
                icon.classList.add('text-success');
            }
        }

        // Dynamic Fine Logic
        const priceInput = document.getElementById('price');
        const fineTypeSelect = document.getElementById('fine_type');
        const fineValueInput = document.getElementById('fine_value');

        function updateFineValue() {
            const price = parseFloat(priceInput.value) || 0;
            const type = fineTypeSelect.value;

            if (type === 'fixed') {
                fineValueInput.value = price;
                fineValueInput.readOnly = true;
                fineValueInput.classList.add('bg-slate-100', 'cursor-not-allowed');
            } else if (type === 'multiplier') {
                fineValueInput.value = '2x';
                fineValueInput.readOnly = false;
                fineValueInput.classList.remove('bg-slate-100', 'cursor-not-allowed');
            } else {
                fineValueInput.readOnly = false;
                fineValueInput.classList.remove('bg-slate-100', 'cursor-not-allowed');
            }
        }

        priceInput.addEventListener('input', updateFineValue);
        fineTypeSelect.addEventListener('change', updateFineValue);
        
        // Initial run
        if (priceInput.value > 0) updateFineValue();
    </script>

    @endpush
</x-app-layout>

