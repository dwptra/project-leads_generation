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
        return redirect('/')->with('fail', 'Periksa Email atau Password!');
    }

    public function logout(){
        Auth::logout();
        return redirect('/')->with('successLogout', 'berhasil keluar akun');
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
        $request->validate([
            'name' => 'required',
            'password' => 'required|min:3',
        ]);
        Owner::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);
        return redirect('/user')->with('createUser', 'Berhasil membuat user!');
    }
    public function userDelete($id)
    {
        Owner::where('id', '=', $id)->delete();
        return redirect('/user')->with('userDelete', 'Berhasil menghapus data!');
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
            'name' => 'required',
            'owner_id' => '',
            'brand' => '',
            'phone' => '',
            'email' => '',
            'instagram' => '',
            'tiktok' => '',
            'other' => '',
        ]);

        Leads::create([
            'name' => $request->name,
            'owner_id' => $request->owner_id,
            'brand' => $request->brand,
            'phone' => $request->phone,
            'email' => $request->email,
            'instagram' => $request->instagram,
            'tiktok' => $request->required,
            'other' => $request->other,
        ]);

        return redirect()->route('leads')->with('createLeads', 'Berhasil membuat data leads');
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
