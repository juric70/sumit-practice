<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;
    protected $fillable=['name', 'description', 'available_seats', 'starting_date', 'ending_date', 'contact_mail'];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    public function discount():HasMany
    {
        return $this->hasMany(Discount::class);
    }
    public function company(){
        return $this->belongsToMany(Company::class);
    }
    public function schedule():HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
