<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    // THIS IS THE PART YOU ARE MISSING OR NEED TO FIX
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'contact_number',
        'issue_type',
        'description',
        'image_path',
        'status',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
