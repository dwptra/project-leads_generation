<?php

namespace App\Exports;

use App\Models\Leads;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeadsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $leads = Leads::select('leads.id', 'leads.name', 'leads.owner_id', 'leads.brand', 'leads.phone', 'leads.email', 'leads.instagram', 'leads.tiktok', 'leads.other', 'leads.status', 'leads_history.history_date')
            ->leftJoin('leads_history', 'leads_history.leads_id', '=', 'leads.id')
            ->orderBy('leads.id')
            ->get();

        return $leads;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Owner ID',
            'Brand',
            'Phone',
            'Email',
            'Instagram',
            'Tiktok',
            'Other',
            'Status',
            'History Date'
        ];
    }
}
