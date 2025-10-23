<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    // Halaman list publik (tabs)
    public function indexPublic()
    {
        // Ambil semua kategori + paket aktif, urut paket dari termurah
        $categories = Category::with([
            'packages' => function ($q) {
                $q->where('status', 'active')
                  ->orderBy('price', 'asc');
                //   ->take(3); // opsional: kalau mau batasi 3 per kategori
            }
        ])
        ->orderBy('name') // atau 'id' sesuai kebutuhan
        ->get();

        return view('packages.index', compact('categories'));
    }

    public function showPublic(Category $category, Package $package)
    {
        return view('packages.show', compact('category','package'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
