<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use App\Models\Owner;
use App\Models\LeadsHistory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LeadsExport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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
        $owners = Owner::all();
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

    public function exportLeadsToExcel(Request $request)
    {
        // Dapatkan nilai dari kolom pemilik dan status yang dipilih
        $ownerValue = $request->input('owner');
        $statusValue = $request->input('status');

        // Query untuk mendapatkan data yang sesuai dengan filter
        $leads = Leads::when($ownerValue != 'all', function ($query) use ($ownerValue) {
                return $query->where('owner_id', $ownerValue);
            })
            ->when($statusValue != 'all', function ($query) use ($statusValue) {
                return $query->where('status', $statusValue);
            })
            ->select('id', 'name', 'owner_id', 'brand', 'phone', 'email', 'instagram', 'tiktok', 'other', 'status')
            ->get();

        // Nama file Excel yang akan dihasilkan
        $fileName = 'leads_report.xlsx';

        // Ekspor data ke dalam file Excel
        return Excel::download(new LeadsExport($leads), $fileName);
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
        return redirect()->route('leads.histories')->with('historiesDelete', 'Berhasil menghapus data Histories.');
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
