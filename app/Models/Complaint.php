<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

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

    public function deleteComplaint()
    {
        return $this->status === 'Pending';
    }
}
