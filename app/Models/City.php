<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nicolaslopezj\Searchable\SearchableTrait;

class City extends Model
{
    use HasFactory, SearchableTrait;
    protected $fillable = [ 'name','state_id', 'status' ];
    public $timestamps = FALSE;

    protected $searchable = [
        'columns' => [
            'cities.name' => 10,
        ],
    ];
    public function states(): BelongsTo
    {
        return $this->belongsTo( State::class,'state_id' );
    }
}