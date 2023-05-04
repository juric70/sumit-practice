<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 */
class State extends Model
{
    use HasFactory;
    protected $fillable=[
        'name'
    ];
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
