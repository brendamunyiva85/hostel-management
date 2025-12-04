<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'reg_number', 'hostel_id'
    ];

    // Relationship with Hostel
    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    // Relationship with Bed
    public function bed()
    {
        return $this->hasOne(Bed::class);
    }
}