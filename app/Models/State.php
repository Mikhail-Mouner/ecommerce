<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class State extends Model
{
    use HasFactory, SearchableTrait;
    protected $fillable = [ 'name', 'country_id', 'status' ];
    public $timestamps = FALSE;

    protected $searchable = [
        'columns' => [
            'states.name' => 10,
        ],
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo( Country::class );
    }

    public function cities(): HasMany
    {
        return $this->hasMany( City::class );
    }

    public function addresses(): HasMany
    {
        return $this->hasMany( UserAddress::class );
    }

}
