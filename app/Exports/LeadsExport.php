<?php

namespace App\Exports;

use App\Models\Leads;
use App\Models\LeadsHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LeadsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $leads;

    public function __construct($leads)
    {
        $this->leads = $leads;
    }

    public function collection()
    {
        return $this->leads;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Owner',
            'Brand',
            'Phone',
            'Email',
            'instagram', 
            'tiktok', 
            'other',
            'history_date', 
            'status'
        ];
    }

    public function map($lead): array
    {
        $lastHistory = LeadsHistory::where('leads_id', $lead->id)->orderByDesc('created_at')->first();

        $historyDate = $lastHistory ? $lastHistory->history_date : '';
    
        return [
            $lead->id,
            $lead->name,
            $lead->owner->name,
            $lead->brand,
            $lead->phone,
            $lead->email,
            $lead->instagram,
            $lead->tiktok,
            $lead->other,
            $historyDate,
            $lead->status,
        ];
    }
    
}
