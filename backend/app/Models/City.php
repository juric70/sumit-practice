<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'zip_code',
        'state_id'
    ];
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function company(): HasMany
    {
        return $this->hasMany(Company::class);
    }
    public function event():HasMany
    {
        return $this->hasMany(Event::class);
    }

}
