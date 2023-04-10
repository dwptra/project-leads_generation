<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;
    protected $fillable = [
        'owner_id',
        'brand',
        'name',
        'phone',
        'email',
        'instagram',
        'tiktok',
        'other',
        'status',
    ];
}
