<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable=['event_day', 'starting_time', 'ending_time', 'address', 'event_room', 'description', 'price'];
    public function event_category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
    public function reservation():HasMany
    {
        return $this->hasMany(Reservation::class);
    }

}
