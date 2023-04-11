<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use App\Models\Owner;
use App\Models\Lead_Histories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  Login
    public function index()
    {
        return view('index'); //Login Form
    }
    public function Auth(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required|min:3',
        ]);

        $owner = Owner::where('name', $request->name)->first();
        if ($owner && Hash::check($request->password, $owner->password)) {
            Auth::login($owner);
            return redirect('/dashboard');
        }
        return redirect('/')->with('fail', 'Periksa Name atau Password!');
    }

    public function logout(){
        Auth::logout();
        return redirect('/')->with('successLogout', 'Berhasil keluar akun.');
    }


    public function dashboard()
    {
        return view('dashboard');
    }

    // User
    public function user()
    {
        $users = Owner::all();
        return view('user', compact('users'));
    }
    public function userCreate()
    {
        return view('user_create');
    }
    public function userPost(Request $request)
    {
        // validasi
        $request->validate([
            'name' => 'required',
            'password' => 'required|min:3',
        ]);

        // bikin data baru dengan isian dari request
        Owner::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        
        // kalau berhasil, arahin ke halaman /user dengan pemberitahuan berhasil
        return redirect('/user')->with('createUser', 'Berhasil membuat user!');
    }
    public function userDelete($id)
    {
        Owner::where('id', '=', $id)->delete();
        return redirect('/user')->with('userDelete', 'Berhasil menghapus data!');
    }
    public function userEdit($id)
    {
        $users = Owner::findOrFail($id);
        return view('user_edit', compact('users'));
    }

    public function userUpdate(Request $request, $id)
    {
        // validasi
        $request->validate([
            'name' => 'required|min:3',
            'password' => 'required|min:3',
        ]);

        // mencari baris data yang punya value column id sama dengan id yang dikirim ke route
        $owner = Owner::findOrFail($id);
        $owner->name = $request->name;
        $owner->password = Hash::make($request->password);
        $owner->role = $request->role;
        $owner->save();

        // kalau berhasil, arahkan ke halaman /user dengan pemberitahuan berhasil
        return redirect('/user')->with('userUpdate', 'User berhasil diperbaharui!');
    }



    public function leads()
    {
        $leads = Leads::all();
        return view('leads', compact('leads'));
    }

    public function leadsCreate()
    {
        $users = Owner::all();
        return view('leadsCreate', compact('users'));
    }

    public function leadsPost(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Leads::create([
            'name' => $request->name,
            'owner_id' => $request->owner_id,
            'brand' => $request->brand,
            'phone' => $request->phone,
            'email' => $request->email,
            'instagram' => $request->instagram,
            'tiktok' => $request->tiktok,
            'other' => $request->other,
        ]);

        return redirect()->route('leads')->with('createLeads', 'Berhasil membuat data leads');
    }

    public function leadsEdit($id)
    {
        $owner = Owner::all();
        $user = Leads::findOrFail($id);
        return view('leadsEdit', compact('user', 'owner'));
    }

    public function leadsUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Leads::where('id', $id)->update([
            'name' => $request->name,
            'owner_id' => $request->owner_id,
            'brand' => $request->brand,
            'phone' => $request->phone,
            'email' => $request->email,
            'instagram' => $request->instagram,
            'tiktok' => $request->tiktok,
            'other' => $request->other,
            'status' => $request->status
        ]);

        return redirect()->route('leads')->with('updateLeads', 'Berhasil membuat data leads');
    }

    public function leadsDelete($id)
    {
        //
        Leads::where('id', '=', $id)->delete();
        return redirect()->route('leads')->with('deleteLeads', 'Berhasil menghapus data leads');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Leads  $leads
     * @return \Illuminate\Http\Response
     */
    public function show(Leads $leads)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Leads  $leads
     * @return \Illuminate\Http\Response
     */
    public function edit(Leads $leads)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Leads  $leads
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Leads $leads)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Leads  $leads
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leads $leads)
    {
        //
    }
}
