<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CollectionController
{
    public function index(Request $request)
    {
        // Master list
        $collections = Collection::withCount('products')->latest()->get();
        
        // Detail view data (if editing)
        $selectedCollection = null;
        if ($request->has('edit')) {
            $selectedCollection = Collection::with('products')->find($request->edit);
        }

        // Available products for selection
        $products = Product::all();

        return view('admin.collections.index', compact('collections', 'selectedCollection', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
            'is_published' => 'nullable|boolean'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('collections', 'public');
            $imagePath = 'storage/' . $path; // Fixed path format
        }

        $collection = Collection::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'image' => $imagePath,
            'is_published' => $request->has('is_published'), // Toggle check
        ]);

        if (!empty($validated['products'])) {
            $collection->products()->sync($validated['products']);
        }

        return redirect()->route('admin.collections.index', ['edit' => $collection->id])
            ->with('success', 'Koleksi berhasil dibuat!');
    }

    public function update(Request $request, Collection $collection)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
            'is_published' => 'nullable|boolean'
        ]);

        $data = [
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'is_published' => $request->has('is_published'),
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($collection->image) {
                $oldPath = str_replace('storage/', '', $collection->image);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('collections', 'public');
            $data['image'] = 'storage/' . $path;
        }

        $collection->update($data);

        if (isset($validated['products'])) {
            $collection->products()->sync($validated['products']);
        } else {
            // Handle case where all products are removed (if implied by empty array, but form might send empty array or nothing)
            // If the field is present but empty, sync empty. If not present (e.g. standard HTML form without hidden input), careful.
            // Using array type validation implies it's an array if present.
            if ($request->has('products')) {
                 $collection->products()->sync($validated['products']);
            } else {
                 $collection->products()->detach();
            }
        }

        return redirect()->route('admin.collections.index', ['edit' => $collection->id])
            ->with('success', 'Koleksi berhasil diperbarui!');
    }

    public function destroy(Collection $collection)
    {
        if ($collection->image) {
            $oldPath = str_replace('storage/', '', $collection->image);
            Storage::disk('public')->delete($oldPath);
        }
        
        $collection->products()->detach();
        $collection->delete();

        return redirect()->route('admin.collections.index')
            ->with('success', 'Koleksi berhasil dihapus!');
    }
}
