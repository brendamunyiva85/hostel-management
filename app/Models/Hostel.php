<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Hostel extends Model
{
    protected $fillable = [
        'name','type','floors','warden_id',
        'location','rooms_count','price_per_night','total_beds','address'
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function warden(): BelongsTo
    {
        return $this->belongsTo(User::class, 'warden_id');
    }
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
