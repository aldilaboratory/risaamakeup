<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $packages = Package::with('category')->latest()->paginate(10);
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $categories = Category::orderBy('name')->get();
        return view('admin.packages.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $request->validate([
            'title'            => 'required|string|max:150',
            'slug'             => ['nullable','string','max:160',
                Rule::unique('packages','slug')->where(fn($q) =>
                    $q->where('category_id', $request->category_id)
                )
            ],
            'category_id'      => 'required|exists:categories,id',
            'price'            => 'required|integer|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'description'      => 'nullable|string',
            'cover_image'      => 'nullable|image|max:2048',
            'status'           => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('packages','public');
        }
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        Package::create($data);
        return redirect()->route('admin.packages.index')->with('success','Package dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package) {
        $categories = Category::orderBy('name')->get();
        return view('admin.packages.edit', compact('package','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package) {
        $data = $request->validate([
            'title'            => 'required|string|max:150',
            'slug'             => ['nullable','string','max:160',
                Rule::unique('packages','slug')
                    ->ignore($package->id) // abaikan diri sendiri
                    ->where(fn($q) => $q->where('category_id', $request->category_id))
            ],
            'category_id'      => 'required|exists:categories,id',
            'price'            => 'required|integer|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'description'      => 'nullable|string',
            'cover_image'      => 'nullable|image|max:2048',
            'status'           => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($package->cover_image) Storage::disk('public')->delete($package->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('packages','public');
        }
        // $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $data['slug'] = $data['slug'] ?? Package::generateSlug($data['title'], (int)$data['category_id']);


        $package->update($data);
        return redirect()->route('admin.packages.index')->with('success','Package diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package) {
        if ($package->cover_image) Storage::disk('public')->delete($package->cover_image);
        $package->delete();
        return back()->with('success','Package dihapus.');
    }
}
