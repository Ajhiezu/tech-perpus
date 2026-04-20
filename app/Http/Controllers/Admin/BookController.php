<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $books = Book::with(['category', 'location'])
            ->when($search, function($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('author', 'LIKE', "%{$search}%")
                      ->orWhere('isbn', 'LIKE', "%{$search}%");
            })
            ->latest()
            ->paginate(10);
            
        return view('admin.books.index', compact('books'));
    }


    public function create()
    {
        $categories = Category::all();
        $locations = Location::all();
        return view('admin.books.create', compact('categories', 'locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'isbn' => 'required|string|unique:books,isbn',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'fine_type' => 'required|in:fixed,multiplier,custom',
            'fine_value' => 'required|string|max:50',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try {
            $validated['slug'] = Str::slug($request->title) . '-' . uniqid();
            $validated['available_stock'] = $request->stock;

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('books', 'public');
                $validated['image'] = $path;
            }

            Book::create($validated);

            return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
        } catch (\Exception $e) {
            \Log::error('Book creation failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan buku: ' . $e->getMessage());
        }
    }


    public function edit(Book $book)
    {
        $categories = Category::all();
        $locations = Location::all();
        return view('admin.books.edit', compact('book', 'categories', 'locations'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'fine_type' => 'required|in:fixed,multiplier,custom',
            'fine_value' => 'required|string|max:50',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);

        if ($request->title !== $book->title) {
            $validated['slug'] = Str::slug($request->title) . '-' . uniqid();
        }

        // Adjust available stock if stock changes
        $stockDiff = $request->stock - $book->stock;
        $validated['available_stock'] = max(0, $book->available_stock + $stockDiff);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($book->image) {
                \Storage::disk('public')->delete($book->image);
            }
            $path = $request->file('image')->store('books', 'public');
            $validated['image'] = $path;
        }

        $book->update($validated);


        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus!');
    }
}
