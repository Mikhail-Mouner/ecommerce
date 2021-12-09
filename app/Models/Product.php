<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
    use HasFactory, Sluggable, SearchableTrait;

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

    protected $searchable = [
        'columns' => [
            'products.name' => 10,
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

    public function scopeActive($query)
    {
        return $query->whereStatus( TRUE );
    }

    public function scopeActiveCategory($query)
    {
        return $query->whereHas('category', function ($q){
            return $q->active();
        });
    }

    public function scopeFeatured($query)
    {
        return $query->whereFeatured( TRUE );
    }

    public function scopeHasQty($query)
    {
        return $query->where( 'qty', '>', 0 );
    }

    public function category()
    {
        return $this->belongsTo( ProductCategory::class, 'product_category_id', 'id' );
    }

    public function tags(): MorphToMany
    {
        return $this->MorphToMany( Tag::class, 'taggable' );
    }

    public function media(): MorphMany
    {
        return $this->MorphMany( Media::class, 'mediable' );
    }

    public function firstMedia(): MorphOne
    {
        return $this->MorphOne( Media::class, 'mediable' )->orderBy( 'file_sort' );
    }

    public function reviews(): HasMany
    {
        return $this->hasMany( ProductReview::class );
    }

}
