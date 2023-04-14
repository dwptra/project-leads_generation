<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadsHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'leads_id',
        'status',
        'history_date',
        'keterangan'
    ];
    public function leads()
    {
        return $this->belongsTo(Leads::class);
    }
}
