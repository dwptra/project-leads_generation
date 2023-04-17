<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use App\Models\Owner;
use App\Models\User;
use App\Models\LeadsHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $owners = Owner::all();
        return view('dashboard', compact('owners'));
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
        $histories = LeadsHistory::orderby('created_at', 'desc')->get();
        $owners = Leads::with('owner')->get();

        return view('Leads.leads', compact('leads', 'owners', 'histories'));
    }

    public function leadsPrint()
    {
        $leads = Leads::all();
        $histories = LeadsHistory::orderby('created_at', 'desc')->get();
        $owners = Leads::with('owner')->get();

        return redirect('Leads.leads', compact('leads', 'owners', 'histories'));
    }

    public function leadsReport(Request $request)
    {
        $owners = Owner::whereRaw('1=0');
        $leads = Leads::whereRaw('1=0');
        $historyDates = Leads::with('history')->get();
        return view('Leads.leads_report', compact('leads', 'owners', 'historyDates'));
    }

    public function generateReport(Request $request)
    {
        $owner = $request->input('owner');
        $status = $request->input('status');
        $owners = Owner::all();
        $historyDates = LeadsHistory::groupBy('leads_id')->selectRaw('leads_id, max(history_date) as last_history_date')->get();

        $leads = Leads::query();
        if ($owner != 'all') {
            $leads->where('owner_id', $owner);
        }
        if ($status != 'all') {
            $leads->where('status', $status);
        }
        $leads = $leads->get();

        return view('Leads.leads_report', compact('owners', 'leads', 'historyDates'));
    }

    public function exportLeadsToExcel()
    {
        $leads = Leads::with('history')->select('id', 'name', 'owner_id', 'brand', 'phone', 'email', 'instagram', 'tiktok', 'other', 'status')->get();

        $spreadsheet = new Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->setTitle('Leads');

        // Add table headers
        $worksheet->setCellValue('A1', 'ID');
        $worksheet->setCellValue('B1', 'Name');
        $worksheet->setCellValue('C1', 'Owner ID');
        $worksheet->setCellValue('D1', 'Brand');
        $worksheet->setCellValue('E1', 'Phone');
        $worksheet->setCellValue('F1', 'Email');
        $worksheet->setCellValue('G1', 'Instagram');
        $worksheet->setCellValue('H1', 'Tiktok');
        $worksheet->setCellValue('I1', 'Other');
        $worksheet->setCellValue('J1', 'History Date');
        $worksheet->setCellValue('K1', 'Status');

        // Add table data
        $row = 2;
        foreach ($leads as $lead) {
            $historyDate = $lead->history->isNotEmpty() ? $lead->history->sortByDesc('history_date')->first()->history_date : '';
            $worksheet->setCellValue('A' . $row, $lead->id);
            $worksheet->setCellValue('B' . $row, $lead->name);
            $worksheet->setCellValue('C' . $row, $lead->owner->name);
            $worksheet->setCellValue('D' . $row, $lead->brand);
            $worksheet->setCellValue('E' . $row, $lead->phone);
            $worksheet->setCellValue('F' . $row, $lead->email);
            $worksheet->setCellValue('G' . $row, $lead->instagram);
            $worksheet->setCellValue('H' . $row, $lead->tiktok);
            $worksheet->setCellValue('I' . $row, $lead->other);
            $worksheet->setCellValue('J' . $row, $historyDate);
            $worksheet->setCellValue('K' . $row, $lead->status);
            $row++;
        }

        // Set auto width for columns
        foreach (range('A', 'K') as $column) {
            $worksheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="leads.xlsx"');
        header('Cache-Control: max-age=0');

        // Output the file to the browser
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function leadPrintable()
    {
        $leads = Leads::all();
        $historyDates = LeadsHistory::groupBy('leads_id')->selectRaw('leads_id, max(history_date) as last_history_date')->get();
        return view('print.leadPrintable', compact('leads', 'historyDates'));
    }

    



    
    public function showHistories($id)
    {
        $lead = Leads::find($id);
        if (!$lead) {
            abort(404);
        }
        $histories = $lead->histories ?? [];

        return view('/leads', compact('histories'));
    }


    public function leadsCreate()
    {
        $owners = Owner::all();
        return view('Leads.leadsCreate', compact('owners'));
    }

    public function leadsPost(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        // Membuat leads baru
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

        // Membuat Leads History baru
        $history = new LeadsHistory;
        $history->leads_id = $leads->id;
        $history->history_date = now(); // Set waktu dan tanggal ke saat ini
        $history->keterangan = 'Membuat Leads';
        $history->save();

        return redirect()->route('leads')->with('createLeads', 'Berhasil membuat data leads');

    }

    public function leadsEdit($id)
    {
        $leads = Leads::findOrFail($id);
        $owners = Owner::all();

        return view('Leads.leadsEdit', compact('leads', 'owners'));
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
            $history->keterangan = 'Mengubah leads';
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
        $histories = LeadsHistory::orderby('created_at', 'desc')->get();
        return view('Leads.leads_histories', compact('histories'));
    }

    public function historiesDelete($id)
    {
        LeadsHistory::where('id', '=', $id)->delete();
        return redirect()->route('leadsHistories')->with('historiesDelete', 'Berhasil menghapus data Histories.');
    }

    // Owner
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
        return redirect('/owner')->with('createOwner', 'Berhasil membuat owner!');
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
        return redirect('/owner')->with('ownerUpdate', 'Owner berhasil diperbaharui!');
    }
    public function ownerDelete($id)
    {
        Owner::where('id', '=', $id)->delete();
        return redirect('/owner')->with('ownerDelete', 'Berhasil menghapus data!');
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
