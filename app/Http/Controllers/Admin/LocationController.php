<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $locations = Location::latest()
            ->when($search, function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            })
            ->paginate(10);
            
        return view('admin.locations.index', compact('locations'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:locations,name',
            'description' => 'nullable|string|max:500',
        ]);

        Location::create($validated);

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi Rak berhasil ditambahkan!');
    }

    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:locations,name,' . $location->id,
            'description' => 'nullable|string|max:500',
        ]);

        $location->update($validated);

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi Rak berhasil diperbarui!');
    }

    public function destroy(Location $location)
    {
        if ($location->books()->count() > 0) {
            return redirect()->back()->with('error', 'Lokasi tidak dapat dihapus karena masih memiliki buku.');
        }

        $location->delete();

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi Rak berhasil dihapus!');
    }
}
