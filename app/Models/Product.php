<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'qty',
        'product_category_id',
        'featured',
        'status',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function category()
    {
        return $this->belongsTo( ProductCategory::class, 'product_category_id', 'id' );
    }

    public function tags(): MorphToMany
    {
        return $this->MorphToMany( Tag::class, 'taggable');
    }

    public function media(): MorphMany
    {
        return $this->MorphMany( Media::class, 'mediable' );
    }

}
