<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class ProductCategory extends Model
{
    use HasFactory, Sluggable, SearchableTrait;

    protected $guarded = [];
    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'product_categories.name' => 10,
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

    public function parent()
    {
        return $this->hasOne( self::class, 'id', 'parent_id' );
    }

    public function children()
    {
        return $this->hasMany( self::class, 'parent_id', 'id' );
    }

    public function appearedChildren()
    {
        return $this->hasMany( self::class, 'parent_id', 'id' )->Active();
    }

    public static function tree($level = 1)
    {
        return static::with( implode( '.', array_fill( 0, $level, 'children' ) ) )
            ->whereNull( 'parent_id' )
            ->Active()
            ->orderBy( 'id', 'asc' )
            ->get();
    }

    public function products()
    {
        return $this->hasMany( Product::class );
    }

}
