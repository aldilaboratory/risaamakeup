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
        // urutan sesuai keinginan
        $order = ['akad','wedding','prewedding','engagement'];

        // ambil kategori + packages aktif (max 3 per kategori untuk tampilan)
        $categories = Category::whereIn('slug', $order)
            ->with(['packages' => function ($q) {
                $q->where('status', 'active')
                  ->take(3);
            }])
            ->get()
            // sort collection sesuai $order
            ->sortBy(fn($c) => array_search($c->slug, $order))
            ->values();

        return view('packages.index', compact('categories', 'order'));
    }

    // Detail publik
    public function showPublic(Category $category, Package $package)
    {
        // berkat scopeBindings, $package pasti milik $category
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
