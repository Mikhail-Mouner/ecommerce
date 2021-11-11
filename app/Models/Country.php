<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class Country extends Model
{
    use HasFactory, SearchableTrait;
    protected $fillable = [ 'name', 'status' ];
    public $timestamps = FALSE;

    protected $searchable = [
        'columns' => [
            'countries.name' => 10,
        ],
    ];

    public function states(): HasMany
    {
        return $this->hasMany( State::class );
    }

}
