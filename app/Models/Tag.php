<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class Tag extends Model
{
    use HasFactory, Sluggable, SearchableTrait;

    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    protected $searchable = [
        'columns' => [
            'tags.name' => 10,
        ],
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function products(): MorphToMany
    {
        return $this->morphedByMany( Product::class, 'taggable' );
    }

}
