<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class ShippingCompany extends Model
{
    use HasFactory, SearchableTrait;

    protected $fillable = [
        'name',
        'code',
        'description',
        'fast',
        'cost',
        'status',
    ];

    protected $appends = [ 'fast_type' ];

    protected $searchable = [
        'columns' => [
            'shipping_companies.name' => 10,
            'shipping_companies.code' => 10,
            'shipping_companies.description' => 10,
        ],
    ];

    public function getFastTypeAttribute()
    {
        return $this->fast ? 'Fast Delivery' : 'Normal Delivery';
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany( Country::class, 'shipping_company_country' );
    }

}
