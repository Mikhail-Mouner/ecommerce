<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class ProductCoupon extends Model
{
    use HasFactory, SearchableTrait;
    protected $fillable = [
        'code',
        'type',
        'value',
        'description',
        'use_times',
        'used_times',
        'start_date',
        'expire_date',
        'greater_than',
        'status',
    ];
    protected $dates = [
        'start_date',
        'expire_date',
    ];
    protected $searchable = [
        'columns' => [
            'product_coupons.code' => 10,
            'product_coupons.description' => 10,
        ],
    ];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

}
