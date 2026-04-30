<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function editRole($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit-role', compact('user'));
    }

    public function updateRole(Request $request, $id)
{
    $request->validate([
        'role' => 'required|in:admin,dokter,kasir'
    ]);

    $user = \App\Models\User::findOrFail($id);

    // 🔒 TARO DI SINI
    if ($user->id == auth()->id()) {
        return back()->with('error', 'Tidak bisa ubah role sendiri');
    }

    // UPDATE ROLE
    $user->update([
        'role' => $request->role
    ]);

    return redirect('/user')->with('success', 'Role berhasil diupdate');
}
}
