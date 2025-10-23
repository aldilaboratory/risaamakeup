<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->get('q', ''));
        $users = User::query()
            ->where('role', 'user')                       // hanya customer
            ->when($search, function ($q) use ($search) { // cari nama/email/phone
                $q->where(function($qq) use ($search){
                    $qq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%")
                       ->orWhere('phone', 'like', "%{$search}%"); // abaikan jika kolom tidak ada
                });
            })
            ->withCount('bookings')                       // hitung total booking
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.users.index', compact('users','search'));
    }

    public function show(User $user)
    {
        abort_unless($user->role === 'user', 404);
        $user->loadCount('bookings')->load(['bookings' => function($q){
            $q->latest()->limit(20);
        }]);

        return view('admin.users.show', compact('user'));
    }
}
