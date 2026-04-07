<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;

    // ONLY the columns that actually exist in your migration
    protected $fillable = [
        'user_id',
        'product_id',
        'design_json',
        'preview_image',
        'status',
    ];

    protected $casts = [
        'design_json' => 'array', // Automatically handles the JSON conversion
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}