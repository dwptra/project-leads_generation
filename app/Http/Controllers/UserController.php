<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user()
    {
        $users = User::all();
        return view('User.user', compact('users'));
    }
    public function userCreate()
    {
        $users = User::all();
        return view('User.user_create', compact('users'));
    }
    public function userPost(Request $request)
    {
        // validasi
        $request->validate([
            'name' => 'required',
            'password' => 'required|min:3',
            'email' => 'required',
        ]);

        // bikin data baru dengan isian dari request
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        
        // kalau berhasil, arahin ke halaman /user dengan pemberitahuan berhasil
        return redirect()->route('user.index')->with('createUser', 'Berhasil membuat user!');
    }
    public function userDelete($id)
    {
        User::where('id', '=', $id)->delete();
        return redirect()->route('user.index')->with('userDelete', 'Berhasil menghapus data!');
    }
    public function userEdit($id)
    {
        $users = User::findOrFail($id);
        return view('User.user_edit', compact('users'));
    }

    public function userUpdate(Request $request, $id)
    {
        // validasi
        $request->validate([
            'name' => 'required|min:3',
        ]);

        // mencari baris data yang punya value column id sama dengan id yang dikirim ke route
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // kalau berhasil, arahkan ke halaman /user dengan pemberitahuan berhasil
        return redirect()->route('user.index')->with('userUpdate', 'User berhasil diperbaharui!');
    }
}
