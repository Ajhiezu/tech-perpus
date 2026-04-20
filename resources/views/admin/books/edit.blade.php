<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.books.index') }}" class="p-1 px-2 hover:bg-slate-100 rounded-lg transition-colors text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-xl font-bold text-slate-900">Edit Book Information</h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="premium-card p-8">
            <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Current Preview -->
                    <div class="md:col-span-2 flex items-center space-x-6 bg-slate-50 p-6 rounded-xl border border-slate-100 mb-2">
                        <div class="w-24 h-32 bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden flex-shrink-0">
                            @if($book->image)
                                <img src="{{ asset('storage/'.$book->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">Current Cover</p>
                            <h3 class="text-lg font-bold text-slate-800 leading-tight mb-2">{{ $book->title }}</h3>
                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded-md text-[10px] font-bold uppercase tracking-widest">{{ $book->category->name }}</span>
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Book Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required 
                            class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-lg focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Author -->
                    <div>
                        <label for="author" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Author</label>
                        <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" required 
                            class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-lg focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                        <x-input-error :messages="$errors->get('author')" class="mt-2" />
                    </div>

                    <!-- ISBN -->
                    <div>
                        <label for="isbn" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">ISBN Number</label>
                        <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}" required 
                            class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-lg focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                        <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Category</label>
                        <select name="category_id" id="category_id" required 
                            class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-lg focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location_id" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Rack Location</label>
                        <select name="location_id" id="location_id" required 
                            class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-lg focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ old('location_id', $book->location_id) == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Stock -->
                    <div class="md:col-span-1">
                        <label for="stock" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Total Stock</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $book->stock) }}" required min="0"
                            class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-lg focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                        <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                    </div>

                    <!-- Publication Year -->
                    <div class="md:col-span-1">
                        <label for="year" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Publication Year</label>
                        <input type="number" name="year" id="year" value="{{ old('year', $book->year) }}" required 
                            class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-lg focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                        <x-input-error :messages="$errors->get('year')" class="mt-2" />
                    </div>

                    <!-- Price -->
                    <div class="md:col-span-1">
                        <label for="price" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Price (Rp)</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $book->price) }}" required min="0"
                            class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-lg focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    <!-- Fine Config -->
                    <div class="md:col-span-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Damage Fine Config</label>
                        <div class="flex gap-2">
                            <select name="fine_type" class="w-1/2 px-4 py-3 bg-slate-50 border-slate-200 rounded-lg focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                                <option value="fixed" {{ old('fine_type', $book->fine_type) == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                <option value="multiplier" {{ old('fine_type', $book->fine_type) == 'multiplier' ? 'selected' : '' }}>Multiplier (x)</option>
                                <option value="custom" {{ old('fine_type', $book->fine_type) == 'custom' ? 'selected' : '' }}>Custom</option>
                            </select>
                            <input type="text" name="fine_value" value="{{ old('fine_value', $book->fine_value) }}" 
                                class="flex-1 px-4 py-3 bg-slate-50 border-slate-200 rounded-lg focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium"
                                placeholder="Value">
                        </div>
                    </div>

                    <!-- Publisher -->
                    <div class="md:col-span-2">
                        <label for="publisher" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Publisher</label>
                        <input type="text" name="publisher" id="publisher" value="{{ old('publisher', $book->publisher) }}" required 
                            class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-lg focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">
                        <x-input-error :messages="$errors->get('publisher')" class="mt-2" />
                    </div>


                    <!-- New Image -->
                    <div class="md:col-span-2">
                        <label for="image" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Change Book Cover (optional)</label>
                        <input type="file" name="image" id="image" 
                            class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm transition-all focus:ring-4 focus:ring-primary/10">
                        <p class="text-[9px] text-slate-400 mt-2 italic px-1">* Leave empty to keep current cover</p>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Synopsis / Description</label>
                        <textarea name="description" id="description" rows="5" 
                            class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-lg focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium">{{ old('description', $book->description) }}</textarea>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end space-x-4">
                    <a href="{{ route('admin.books.index') }}" class="btn-outline">Cancel</a>
                    <button type="submit" class="btn-indigo">Update Item Details</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
