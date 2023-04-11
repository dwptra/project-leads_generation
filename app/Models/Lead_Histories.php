<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead_Histories extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id',
        'status',
        'history_date'
    ];
}
