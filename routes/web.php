<?php


use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminPackageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return view('welcome');
});

Route::get('/dashboard', function () {
    // kalau admin, arahkan ke admin dashboard
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // user biasa tetap lihat dashboard default
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// PUBLIC (opsional): list & detail by slug
Route::get('/packages', [PackageController::class, 'indexPublic'])->name('packages.public.index');
Route::scopeBindings()->group(function () {
    Route::get('/categories/{category:slug}/packages/{package:slug}', function (Category $category, Package $package) {
        // $package otomatis dicari TERBATAS pada $category (scoped)
        // pastikan relasi: Package belongsTo Category
        return view('packages.show', compact('category','package'));
    })->name('packages.public.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('packages', PackageController::class);
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', AdminCategoryController::class)->except('show');
    Route::resource('packages', AdminPackageController::class)->except('show');
});

require __DIR__.'/auth.php';
