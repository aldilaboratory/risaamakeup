<?php


use App\Http\Controllers\Admin\AdminAdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminPackageController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserTestimonialController;
use App\Models\Category;
use App\Models\Package;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    $categories = \App\Models\Category::with(['packages' => function ($q) {
            $q->where('status', 'active')
              ->orderBy('price', 'asc');
            //   ->take(3); // opsional
        }])
        ->orderBy('name')   // atau 'id', bebas
        ->get();

    // Pagination 6 per halaman, hanya booking paid
    $testimonials = Testimonial::with(['booking.package','booking.category'])
        ->whereHas('booking', fn($q) => $q->where('payment_status', 'paid'))
        ->latest()
        ->paginate(6)                 // <= ubah jumlah sesuai kebutuhan
        ->withQueryString();

    // Supaya setelah pindah halaman langsung lompat ke section testimoni
    $testimonials->fragment('testimonials');

    return view('welcome', compact('categories','testimonials'));
});

Route::scopeBindings()->group(function () {
    // penting: letakkan ini dulu
    Route::get('/booking/{booking}/pay', [BookingController::class,'payPage'])
        ->whereNumber('booking')
        ->middleware('auth')
        ->name('booking.pay.page');

    Route::get('/booking/{booking}/invoice', [BookingController::class,'invoice'])
        ->whereNumber('booking')->middleware('auth')->name('booking.invoice');

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
    
    // User booking tracking
    Route::get('/my-bookings', [BookingController::class, 'userBookings'])->name('user.bookings');
    Route::post('/booking/{booking}/regenerate-token', [BookingController::class, 'regenerateSnapToken'])
        ->name('booking.regenerate-token');

    Route::get('/booking/{booking}/invoice', [BookingController::class, 'invoice'])
        ->name('booking.invoice');

    Route::post('/my-bookings/{booking}/testimonial', [UserTestimonialController::class, 'store'])->name('booking.testimonial.store');
    Route::put('/my-bookings/{booking}/testimonial', [UserTestimonialController::class, 'update'])->name('booking.testimonial.update');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', \App\Http\Controllers\Admin\AdminCategoryController::class)->except('show');
    Route::resource('packages', \App\Http\Controllers\Admin\AdminPackageController::class)->except('show');
    Route::resource('users', \App\Http\Controllers\Admin\AdminUserController::class)->only(['index','show']);
    Route::resource('admins', \App\Http\Controllers\Admin\AdminAdminController::class)->except('show');

    // Orders
    Route::get('/orders', [\App\Http\Controllers\Admin\AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{booking}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'show'])->name('orders.show');

    // AJAX actions
    Route::patch('/orders/{booking}/approve', [\App\Http\Controllers\Admin\AdminOrderController::class, 'approve'])->name('orders.approve');
    Route::patch('/orders/{booking}/reject', [\App\Http\Controllers\Admin\AdminOrderController::class, 'reject'])->name('orders.reject');
    Route::patch('/orders/{booking}/status', [\App\Http\Controllers\Admin\AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

require __DIR__.'/auth.php';
