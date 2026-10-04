<x-app-layout>
    <x-slot name="header">
        Detail Koleksi Buku
    </x-slot>

    <x-slot name="actions">
        <a href="{{ route('admin.books.index') }}" class="btn-editorial-outline text-xs py-2 px-3.5 uppercase tracking-wider inline-flex items-center">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        @if($book->hasDigital())
            <a href="{{ route('admin.books.reader', $book) }}" target="_blank" class="px-3.5 py-2 text-xs font-semibold uppercase tracking-wider bg-[#FFF9ED] text-[#B45309] border border-[#FDE68A] hover:bg-amber-100 rounded transition-colors inline-flex items-center shadow-xs">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Baca Digital
            </a>
        @endif
        <a href="{{ route('admin.books.edit', $book) }}" class="btn-editorial text-xs py-2 px-4 uppercase tracking-wider inline-flex items-center">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Edit Buku
        </a>
    </x-slot>

    <div class="space-y-6 animate-in fade-in duration-300">
        
        <!-- Book Identity & Breadcrumb Banner Card -->
        <div class="bg-white p-5 rounded-lg border border-neutral-border shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1.5">
                <nav class="flex items-center gap-2 text-[11px] text-neutral-muted uppercase tracking-wider font-mono">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Dasbor</a>
                    <span>/</span>
                    <a href="{{ route('admin.books.index') }}" class="hover:text-primary transition-colors">Katalog Buku</a>
                    <span>/</span>
                    <span class="text-primary font-bold">{{ $book->book_code ?? 'DETAIL' }}</span>
                </nav>
                <div class="flex flex-wrap items-center gap-2.5">
                    <h2 class="text-xl sm:text-2xl font-bold text-neutral-dark tracking-tight leading-snug">
                        {{ $book->title }}
                    </h2>
                    @if($book->collection_type === 'fisik_digital')
                        <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] font-bold bg-primary-light text-primary border border-red-200 rounded">
                            Fisik & Digital
                        </span>
                    @elseif($book->collection_type === 'digital')
                        <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] font-bold bg-[#FFF9ED] text-[#B45309] border border-[#FDE68A] rounded">
                            Digital
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] font-bold bg-[#EDF7ED] text-success border border-[#C8E6C9] rounded">
                            Fisik
                        </span>
                    @endif
                </div>
                <p class="text-xs text-neutral-body">
                    Penulis: <span class="font-semibold text-neutral-dark">{{ $book->author }}</span> • 
                    Kategori: <span class="font-semibold text-primary">{{ $book->category->name ?? 'Umum' }}</span> • 
                    Kode Buku: <span class="font-mono font-bold text-neutral-dark">{{ $book->book_code ?? '-' }}</span>
                </p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('admin.books.index') }}" class="btn-editorial-outline text-xs py-2 px-3.5 uppercase tracking-wider inline-flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Katalog
                </a>
            </div>
        </div>

        <!-- Main Info Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Left Column: Cover & Quick Specs (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Cover Card -->
                <div class="bg-white p-4 sm:p-5 rounded-lg border border-neutral-border shadow-xs">
                    <div class="aspect-[3/4.2] bg-neutral-surface rounded overflow-hidden relative border border-neutral-border shadow-xs flex items-center justify-center">
                        @if($book->cover_url)
                            <img id="detail-cover-img" src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                        @else
                            <img id="detail-cover-img" src="" alt="{{ $book->title }}" class="w-full h-full object-cover hidden">
                            <div id="detail-cover-placeholder" class="w-full h-full flex flex-col items-center justify-center p-6 text-center bg-neutral-surface">
                                <div class="w-14 h-14 rounded-full bg-white flex items-center justify-center text-primary mb-3 shadow-xs border border-neutral-border">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <span class="font-sans text-sm font-bold text-neutral-dark">{{ $book->title }}</span>
                                <span class="text-xs text-neutral-muted mt-1">{{ $book->author }}</span>
                                <span class="inline-block mt-3 px-2 py-0.5 bg-white border border-neutral-border text-[10px] font-bold text-neutral-muted uppercase tracking-wider rounded">RPK PUSTAKA IMM SAINTEK MU</span>
                            </div>

                            @if($book->hasDigital())
                                <script>
                                    (async function autoRenderPdfCover() {
                                        let attempts = 0;
                                        while (typeof window.renderPdfFirstPage !== 'function' && attempts < 50) {
                                            await new Promise(r => setTimeout(r, 100));
                                            attempts++;
                                        }

                                        if (typeof window.renderPdfFirstPage !== 'function') {
                                            console.warn('PDF.js renderer is not available.');
                                            return;
                                        }

                                        try {
                                            const pdfUrl = '{{ route("admin.books.stream", $book) }}';
                                            const resp = await fetch(pdfUrl);
                                            if (!resp.ok) return;

                                            const blob = await resp.blob();
                                            const file = new File([blob], 'naskah.pdf', { type: 'application/pdf' });
                                            const res = await window.renderPdfFirstPage(file, 15000);

                                            if (res.success && (res.blob || res.imageBase64)) {
                                                const imgEl = document.getElementById('detail-cover-img');
                                                const placeholderEl = document.getElementById('detail-cover-placeholder');

                                                if (imgEl) {
                                                    imgEl.src = res.imageBase64;
                                                    imgEl.classList.remove('hidden');
                                                }
                                                if (placeholderEl) {
                                                    placeholderEl.classList.add('hidden');
                                                    placeholderEl.classList.remove('flex');
                                                }

                                                const formData = new FormData();
                                                formData.append('_token', '{{ csrf_token() }}');
                                                if (res.blob) {
                                                    formData.append('cover_image', res.blob, 'cover.webp');
                                                } else {
                                                    formData.append('cover_base64', res.imageBase64);
                                                }

                                                await fetch('{{ route("admin.books.auto-cover", $book) }}', {
                                                    method: 'POST',
                                                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                                                    body: formData
                                                });
                                            }
                                        } catch (err) {
                                            console.warn('Auto cover render error:', err);
                                        }
                                    })();
                                </script>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Availability & Location Summary Card -->
                <div class="bg-white p-5 rounded-lg border border-neutral-border shadow-xs space-y-4">
                    <h3 class="text-xs font-bold text-neutral-dark uppercase tracking-wider pb-2 border-b border-neutral-border">
                        Status & Parameter Fisik
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between py-1 border-b border-neutral-border/60">
                            <span class="text-neutral-muted">Format Koleksi:</span>
                            <span class="font-semibold text-neutral-dark capitalize">
                                {{ $book->collection_type === 'fisik_digital' ? 'Fisik & Digital' : ($book->collection_type === 'digital' ? 'Digital Saja' : 'Buku Fisik') }}
                            </span>
                        </div>

                        @if($book->collection_type !== 'digital')
                            <div class="flex items-center justify-between py-1 border-b border-neutral-border/60">
                                <span class="text-neutral-muted">Ketersediaan Stok:</span>
                                <div>
                                    <span class="font-bold text-success">{{ $book->available_stock }}</span>
                                    <span class="text-neutral-muted">/ {{ $book->stock }} Eksemplar</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between py-1 border-b border-neutral-border/60">
                                <span class="text-neutral-muted">Lokasi Rak Simpan:</span>
                                <span class="font-semibold text-neutral-dark uppercase font-mono">
                                    {{ $book->location->name ?? '-' }}
                                </span>
                            </div>
                        @endif

                        <div class="flex items-center justify-between py-1 border-b border-neutral-border/60">
                            <span class="text-neutral-muted">Taksiran Nilai Buku:</span>
                            <span class="font-bold text-neutral-dark">
                                Rp {{ number_format($book->price ?? 0, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="py-1">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-neutral-muted">Skema Ganti Rugi:</span>
                                <span class="font-semibold text-neutral-dark capitalize">
                                    @if($book->fine_type === 'fixed')
                                        Tetap (Harga Asli)
                                    @elseif($book->fine_type === 'multiplier')
                                        Kelipatan ({{ $book->fine_value }})
                                    @else
                                        Manual
                                    @endif
                                </span>
                            </div>
                            <p class="text-[11px] text-neutral-muted italic">
                                @if($book->fine_type === 'multiplier')
                                    * Denda dihitung: {{ $book->fine_value }} × Rp {{ number_format($book->price ?? 0, 0, ',', '.') }}
                                @elseif($book->fine_type === 'fixed')
                                    * Denda senilai 1x taksiran harga buku (Rp {{ number_format($book->price ?? 0, 0, ',', '.') }})
                                @else
                                    * Denda nominal khusus: Rp {{ number_format((float) preg_replace('/[^0-9.]/', '', $book->fine_value), 0, ',', '.') }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Digital PDF Card -->
                @if($book->hasDigital())
                    <div class="p-4 bg-primary-light/60 rounded-lg border border-red-200 space-y-3">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <h4 class="text-xs font-bold text-neutral-dark uppercase tracking-wider">Naskah Digital Aktif</h4>
                        </div>
                        <p class="text-xs text-neutral-body">
                            Berkas dokumen PDF naskah tersimpan di server dan siap diakses via pembaca digital.
                        </p>
                        <a href="{{ route('admin.books.reader', $book) }}" target="_blank" class="w-full btn-editorial text-xs py-2 px-4 uppercase tracking-wider text-center block">
                            Buka Digital Reader (PDF)
                        </a>
                    </div>
                @endif
            </div>

            <!-- Right Column: Bibliographic Details & Circulation History (8 cols) -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Bibliographic Details Card -->
                <div class="bg-white p-6 rounded-lg border border-neutral-border shadow-xs space-y-6">
                    <div class="pb-3 border-b border-neutral-border flex items-center justify-between">
                        <h3 class="text-sm font-bold text-neutral-dark uppercase tracking-wider">
                            Informasi Bibliografi Naskah
                        </h3>
                        <span class="text-xs font-mono font-bold text-primary px-2.5 py-1 bg-primary-light border border-red-200 rounded">
                            {{ $book->book_code ?? '-' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
                        <div>
                            <span class="text-neutral-muted uppercase tracking-wider block font-semibold text-[10px] mb-1">Judul Buku</span>
                            <span class="text-sm font-bold text-neutral-dark block leading-snug">{{ $book->title }}</span>
                        </div>

                        <div>
                            <span class="text-neutral-muted uppercase tracking-wider block font-semibold text-[10px] mb-1">Penulis / Pengarang</span>
                            <span class="text-sm font-semibold text-neutral-dark block">{{ $book->author }}</span>
                        </div>

                        <div>
                            <span class="text-neutral-muted uppercase tracking-wider block font-semibold text-[10px] mb-1">Kategori / Klasifikasi</span>
                            <span class="inline-block mt-0.5 font-semibold text-primary bg-primary-light border border-red-200 px-2 py-0.5 rounded">
                                {{ $book->category->name ?? 'Umum' }}
                            </span>
                        </div>

                        <div>
                            <span class="text-neutral-muted uppercase tracking-wider block font-semibold text-[10px] mb-1">Nomor ISBN</span>
                            <span class="text-xs font-mono font-semibold text-neutral-dark block">{{ $book->isbn ?? '-' }}</span>
                        </div>

                        <div>
                            <span class="text-neutral-muted uppercase tracking-wider block font-semibold text-[10px] mb-1">Penerbit</span>
                            <span class="text-xs font-semibold text-neutral-dark block">{{ $book->publisher ?? '-' }}</span>
                        </div>

                        <div>
                            <span class="text-neutral-muted uppercase tracking-wider block font-semibold text-[10px] mb-1">Tahun Terbit</span>
                            <span class="text-xs font-semibold text-neutral-dark block">{{ $book->year ?? '-' }}</span>
                        </div>

                        <div>
                            <span class="text-neutral-muted uppercase tracking-wider block font-semibold text-[10px] mb-1">Bahasa Pengantar</span>
                            <span class="text-xs font-semibold text-neutral-dark block">{{ $book->language ?? 'Indonesia' }}</span>
                        </div>

                        <div>
                            <span class="text-neutral-muted uppercase tracking-wider block font-semibold text-[10px] mb-1">Jumlah Halaman</span>
                            <span class="text-xs font-semibold text-neutral-dark block">{{ $book->page_count ? $book->page_count . ' Halaman' : '-' }}</span>
                        </div>
                    </div>

                    <!-- Synopsis / Description -->
                    <div class="pt-4 border-t border-neutral-border">
                        <span class="text-neutral-muted uppercase tracking-wider block font-semibold text-[10px] mb-2">Sinopsis / Ringkasan Koleksi</span>
                        @if($book->description)
                            <div class="text-xs text-neutral-body leading-relaxed whitespace-pre-line bg-neutral-surface p-4 rounded border border-neutral-border">
                                {{ $book->description }}
                            </div>
                        @else
                            <p class="text-xs text-neutral-muted italic bg-neutral-surface p-4 rounded border border-neutral-border">
                                Belum ada deskripsi atau ringkasan sinopsis untuk buku ini.
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Recent Loan Activity Card -->
                <div class="bg-white rounded-lg border border-neutral-border overflow-hidden shadow-xs">
                    <div class="px-6 py-4 border-b border-neutral-border bg-neutral-surface flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-primary"></span>
                            <h3 class="text-sm font-bold text-neutral-dark uppercase tracking-wider">
                                Riwayat Sirkulasi Pinjaman Terkini
                            </h3>
                        </div>
                        <span class="text-xs text-neutral-muted font-mono">Total Transaksi: {{ count($recentLoans) }}</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-neutral-dark divide-y divide-neutral-border">
                            <thead class="bg-neutral-surface text-[10px] uppercase font-bold text-neutral-muted tracking-wider">
                                <tr>
                                    <th class="px-6 py-3">Peminjam</th>
                                    <th class="px-6 py-3">Tipe</th>
                                    <th class="px-6 py-3">Tgl Pinjam</th>
                                    <th class="px-6 py-3">Tenggat</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Kondisi Pengembalian</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-border">
                                @forelse($recentLoans as $detail)
                                    @php $loan = $detail->loan; @endphp
                                    @if($loan)
                                        <tr class="hover:bg-neutral-surface/60 transition-colors">
                                            <td class="px-6 py-3.5 whitespace-nowrap">
                                                <div class="font-semibold text-neutral-dark">{{ $loan->user->name ?? 'Anggota' }}</div>
                                                <div class="text-[10px] text-neutral-muted font-mono">{{ $loan->loan_code }}</div>
                                            </td>
                                            <td class="px-6 py-3.5 whitespace-nowrap">
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $loan->loan_type === 'digital' ? 'bg-[#FFF9ED] text-[#B45309]' : 'bg-[#EDF7ED] text-success' }}">
                                                    {{ $loan->loan_type ?? 'Fisik' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-3.5 whitespace-nowrap text-neutral-body">
                                                {{ $loan->loan_date ? $loan->loan_date->format('d/m/Y') : '-' }}
                                            </td>
                                            <td class="px-6 py-3.5 whitespace-nowrap text-neutral-body font-mono">
                                                {{ $loan->due_date ? $loan->due_date->format('d/m/Y') : '-' }}
                                            </td>
                                            <td class="px-6 py-3.5 whitespace-nowrap">
                                                @if($loan->status === 'borrowed')
                                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-primary bg-primary-light border border-red-200 px-2 py-0.5 rounded">
                                                        Dipinjam
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-success bg-[#EDF7ED] border border-[#C8E6C9] px-2 py-0.5 rounded">
                                                        Selesai
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-3.5 whitespace-nowrap text-neutral-body">
                                                @if($loan->returnBook)
                                                    <span class="capitalize font-semibold text-neutral-dark">
                                                        {{ $loan->returnBook->condition === 'good' ? 'Baik' : ($loan->returnBook->condition === 'damaged' ? 'Rusak' : 'Hilang') }}
                                                    </span>
                                                @else
                                                    <span class="text-neutral-muted italic">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-xs text-neutral-muted italic">
                                            Belum ada catatan sirkulasi peminjaman untuk buku ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
