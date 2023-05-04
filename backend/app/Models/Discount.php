<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discount extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'code', 'amount'];

    public function event():BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
    public function reservation():HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
