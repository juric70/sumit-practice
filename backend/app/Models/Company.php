<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    use HasFactory;
    protected $fillable=['name', 'about_company', 'mail', 'tel_number','address'];
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function event(){
        return $this->belongsToMany(Event::class);
    }
}
