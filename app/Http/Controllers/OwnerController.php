<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owner;

class OwnerController extends Controller
{
    public function owner()
    {
        $owners = Owner::all();
        return view('Owner.owner', compact('owners'));
    }

    public function ownerPost(Request $request)
    {
        // validasi
        $request->validate([
            'name' => 'required',
        ]);

        // bikin data baru dengan isian dari request
        Owner::create([
            'name' => $request->name,
        ]);
        
        // kalau berhasil, arahin ke halaman /usownerer dengan pemberitahuan berhasil
        return redirect()->route('owner')->with('createOwner', 'Berhasil membuat owner!');
    }

    public function ownerUpdate(Request $request, $id)
    {
        // validasi
        $request->validate([
            'name' => 'required|min:3',
        ]);

        // mencari baris data yang punya value column id sama dengan id yang dikirim ke route
        $owner = Owner::findOrFail($id);
        $owner->name = $request->name;
        $owner->save();

        // kalau berhasil, arahkan ke halaman /user dengan pemberitahuan berhasil
        return redirect()->route('owner')->with('ownerUpdate', 'Owner berhasil diperbaharui!');
    }
    public function ownerDelete($id)
    {
        Owner::where('id', '=', $id)->delete();
        return redirect()->route('owner')->with('ownerDelete', 'Berhasil menghapus data!');
    }
}
