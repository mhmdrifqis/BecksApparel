<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedDesign extends Model
{
    use HasFactory;

    // 1. Tell Laravel these columns are safe to be mass-assigned
    protected $fillable = [
        'user_id',
        'status',
        'design_data',
        'roster_data',
        'thumbnail_path'
    ];

    // 2. Automatically cast the JSON columns back and forth to PHP arrays
    protected $casts = [
        'design_data' => 'array',
        'roster_data' => 'array',
    ];
}