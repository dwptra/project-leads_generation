<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use App\Models\Owner;
use App\Models\User;
use App\Models\LeadsHistory;
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
            'email' => 'required',
            'password' => 'required|min:3',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect('/dashboard');
        }
        return redirect('/')->with('fail', 'Periksa Email atau Password!');
    }

    public function logout(){
        Auth::logout();
        return redirect('/')->with('successLogout', 'Berhasil keluar akun.');
    }


    public function dashboard()
    {
        $userCount = User::count();
        $leadsCount = Leads::count();
        return view('dashboard', compact('userCount', 'leadsCount'));
    }

    // User
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
            'email' => 'required|email:dns',
        ]);

        // bikin data baru dengan isian dari request
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        
        // kalau berhasil, arahin ke halaman /user dengan pemberitahuan berhasil
        return redirect('/user')->with('createUser', 'Berhasil membuat user!');
    }
    public function userDelete($id)
    {
        User::where('id', '=', $id)->delete();
        return redirect('/user')->with('userDelete', 'Berhasil menghapus data!');
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
            'password' => 'required|min:3',
        ]);

        // mencari baris data yang punya value column id sama dengan id yang dikirim ke route
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();

        // kalau berhasil, arahkan ke halaman /user dengan pemberitahuan berhasil
        return redirect('/user')->with('userUpdate', 'User berhasil diperbaharui!');
    }



    public function leads()
    {
        $leads = Leads::all();
        return view('Leads.leads', compact('leads'));
    }

    public function leadsCreate()
    {
        $users = User::all();
        $leads = Leads::all();
        return view('Leads.leadsCreate', compact('users'));
    }

    public function leadsPost(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        // Create a new Leads object
        $leads = Leads::create([
            'name' => $request->name,
            'owner_id' => $request->owner_id,
            'brand' => $request->brand,
            'phone' => $request->phone,
            'email' => $request->email,
            'instagram' => $request->instagram,
            'tiktok' => $request->tiktok,
            'other' => $request->other,
        ]);

        // Create a new LeadsHistory object and set its attributes
        $history = new LeadsHistory;
        $history->leads_id = $leads->id;
        $history->history_date = now(); // Set the current date and time
        $history->save();

        // Redirect back to the leads page with a success message
        return redirect()->route('leads')->with('createLeads', 'Berhasil membuat data leads');

    }

    public function leadsEdit($id)
    {
        $owner = User::all();
        $user = Leads::findOrFail($id);
        return view('Leads.leadsEdit', compact('user', 'owner'));
    }

    public function leadsUpdate(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required'
        ]);

        // Ambil data leads yang akan diperbarui berdasarkan id
        $leads = Leads::find($id);

        if ($request->status != $leads->status) {
            // Update status leads
            $leads->status = $request->status;
            $leads->save();
        
            // Tambahkan catatan baru ke tabel leads_histories
            $history = new LeadsHistory;
            $history->leads_id = $leads->id;
            $history->status = $request->status;
            $history->history_date = now(); // Set tanggal dan waktu saat ini
            $history->save();
        
            // Redirect ke halaman leads dengan pesan sukses
            return redirect()->route('leads')->with('updateLeads', 'Berhasil memperbarui data leads dan menambahkan catatan baru');
        } else {
            // Jika status tidak berubah, hanya lakukan update pada data leads
            $leads->update($request->all());
        
            // Redirect ke halaman leads dengan pesan sukses
            return redirect()->route('leads')->with('updateLeads', 'Berhasil memperbarui data leads');
        }        
    }

    public function leadsDelete($id)
    {
        //
        Leads::where('id', '=', $id)->delete();
        return redirect('/leads')->with('deleteLeads', 'Berhasil menghapus data leads');
    }

    public function leadsHistories()
    {
        $histories = LeadsHistory::all();
        $leads = Leads::all();
        return view('Leads.leads_histories', compact('histories', 'leads'));
    }

    public function historiesDelete($id)
    {
        LeadsHistory::where('id', '=', $id)->delete();
        return redirect()->route('leadsHistories')->with('historiesDelete', 'Berhasil menghapus data Histories.');
    }

    // Owner
    public function owner()
    {
        return view('Owner.owner');
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
