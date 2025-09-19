<?php


use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminPackageController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Package;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    $order = ['akad','wedding','prewedding','engagement'];

    $categories = Category::whereIn('slug', $order)
        ->with(['packages' => function ($q) {
            $q->where('status', 'active')
              ->latest()
              ->take(3);
        }])
        ->get()
        ->sortBy(fn($c) => array_search($c->slug, $order))
        ->values();

    return view('welcome', compact('categories','order'));
});

Route::scopeBindings()->group(function () {
// penting: letakkan ini dulu
Route::get('/booking/{booking}/pay', [BookingController::class,'payPage'])
    ->whereNumber('booking')
    ->middleware('auth')
    ->name('booking.pay.page');

Route::get('/booking/{booking}/thank-you', [BookingController::class,'thankYou'])
    ->whereNumber('booking')
    ->middleware('auth')
    ->name('booking.thank-you');

// baru setelah itu rute 2 segmen (category/package)
Route::get('/booking/{category:slug}/{package:slug}', [BookingController::class, 'create'])
    ->middleware('auth')
    ->name('booking.create');
Route::post('/booking/{category:slug}/{package:slug}', [BookingController::class, 'store'])
    ->middleware('auth')
    ->name('booking.store');

    // Midtrans server → kita (webhook)
    Route::post('/midtrans/notification', [BookingController::class,'notificationHandler'])
        ->name('midtrans.notification');
});

Route::post('/midtrans/check', [BookingController::class, 'checkStatus'])
    ->name('midtrans.check');

// PUBLIC (opsional): list & detail by slug
Route::get('/packages', [PackageController::class, 'indexPublic'])->name('packages.public.index');

Route::scopeBindings()->group(function () {
    Route::get('/categories/{category:slug}/packages/{package:slug}',
        [PackageController::class, 'showPublic']
    )->name('packages.public.show');
});

Route::get('/dashboard', function () {
    // kalau admin, arahkan ke admin dashboard
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // user biasa tetap lihat dashboard default
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', AdminCategoryController::class)->except('show');
    Route::resource('packages', AdminPackageController::class)->except('show');
    
    // Orders routes
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{booking}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{booking}/approve', [AdminOrderController::class, 'approve'])->name('orders.approve');
    Route::patch('/orders/{booking}/reject', [AdminOrderController::class, 'reject'])->name('orders.reject');
    Route::patch('/orders/{booking}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

require __DIR__.'/auth.php';
