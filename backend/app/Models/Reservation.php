<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = ['is_paid', 'is_present', 'date_of_reservation'];
    public function discount():BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function schedule():BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

}
