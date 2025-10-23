<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $admins = User::query()
            ->where('role', 'admin')
            ->when($q, function ($qq) use ($q) {
                $qq->where(function($w) use ($q){
                    $w->where('name','like',"%{$q}%")
                      ->orWhere('email','like',"%{$q}%")
                      ->orWhere('phone','like',"%{$q}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.admins.index', compact('admins','q'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required','string','max:120'],
            'email'    => ['required','email','max:190','unique:users,email'],
            'phone'    => ['nullable','string','max:30'],
            'password' => ['required','confirmed','min:8'],
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'role'     => 'admin',
        ]);

        return redirect()->route('admin.admins.index')->with('success','Admin berhasil dibuat.');
    }

    public function edit(User $admin)
    {
        abort_unless($admin->role === 'admin', 404);
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        abort_unless($admin->role === 'admin', 404);

        $data = $request->validate([
            'name'     => ['required','string','max:120'],
            'email'    => ['required','email','max:190', Rule::unique('users','email')->ignore($admin->id)],
            'phone'    => ['nullable','string','max:30'],
            'password' => ['nullable','confirmed','min:8'],
        ]);

        $admin->name  = $data['name'];
        $admin->email = $data['email'];
        $admin->phone = $data['phone'] ?? null;
        if (!empty($data['password'])) {
            $admin->password = Hash::make($data['password']);
        }
        $admin->role = 'admin'; // pastikan tetap admin
        $admin->save();

        return redirect()->route('admin.admins.index')->with('success','Admin diupdate.');
    }

    public function destroy(User $admin)
    {
        abort_unless($admin->role === 'admin', 404);

        // proteksi: tidak boleh hapus diri sendiri
        if (auth()->id() === $admin->id) {
            return back()->with('error','Tidak bisa menghapus akun sendiri.');
        }

        // proteksi: jangan hapus admin terakhir
        $countAdmins = User::where('role','admin')->count();
        if ($countAdmins <= 1) {
            return back()->with('error','Tidak bisa menghapus admin terakhir.');
        }

        $admin->delete();
        return back()->with('success','Admin dihapus.');
    }
}
