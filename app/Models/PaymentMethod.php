<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class PaymentMethod extends Model
{
    use HasFactory, SearchableTrait;
    protected $fillable = [
        'name',
        'code',
        'driver_name',
        'merchant_email',
        'username',
        'password',
        'secret',
        'sandbox_username',
        'sandbox_password',
        'sandbox_secret',
        'sandbox',
        'status',
    ];


    protected $searchable = [
        'columns' => [
            'payment_methods.name' => 10,
            'payment_methods.code' => 10,
            'payment_methods.merchant_email' => 10,
        ],
    ];

    public function scopeActive($query)
    {
        return $query->whereStatus( TRUE );
    }

}
