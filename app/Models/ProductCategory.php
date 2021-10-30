<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = [];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
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
        return $this->hasMany( self::class, 'parent_id', 'id' )->whereStatus( TRUE );
    }

    public static function tree($level = 1)
    {
        return static::with( implode( '.', array_fill( 0, $level, 'children' ) ) )
            ->whereNull( 'parent_id' )
            ->whereStatus( TRUE )
            ->orderBy( 'id', 'asc' )
            ->get();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
