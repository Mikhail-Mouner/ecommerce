<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class Order extends Model
{
    use HasFactory, SearchableTrait;
    /*protected $fillable = [
        'ref_id',
        'user_id',
        'user_address_id',
        'shipping_company_id',
        'payment_method_id',
        'sub_total',
        'discount_code',
        'discount',
        'shipping',
        'tax',
        'total',
        'currency',
        'order_status',
    ];*/
    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'orders.ref_id' => 10,
            'users.first_name' => 10,
            'users.last_name' => 10,
            'users.username' => 10,
            'users.email' => 10,
            'users.mobile' => 10,
            'user_addresses.address_title' => 10,
            'user_addresses.first_name' => 10,
            'user_addresses.last_name' => 10,
            'user_addresses.email' => 10,
            'user_addresses.mobile' => 10,
            'user_addresses.address' => 10,
            'user_addresses.address2' => 10,
            'user_addresses.zip_code' => 10,
            'user_addresses.po_box' => 10,
            'shipping_companies.name' => 10,
            'shipping_companies.code' => 10,
        ],
        'join' => [
            'users' => [ 'users.id', 'orders.user_id' ],
            'user_addresses' => [ 'user_addresses.id', 'orders.user_addresses_id' ],
            'shipping_companies' => [ 'shipping_companies.id', 'orders.shipping_company_id' ],
        ],
    ];

    const NEW_ORDER = 0;
    const PAYMENT_COMPLETED = 1;
    const UNDER_PROCESS = 2;
    const FINISHED = 3;
    const REJECTED = 4;
    const CANCELED = 5;
    const REFUNDED_REQUEST = 6;
    const REFUNDED = 7;
    const RETURNED = 8;

    public function status()
    {
        switch ($this->order_status) {
            case self::NEW_ORDER:
                $result = 'NEW ORDER';
                break;
            case self::PAYMENT_COMPLETED:
                $result = 'PAYMENT COMPLETED';
                break;
            case self::UNDER_PROCESS:
                $result = 'UNDER PROCESS';
                break;
            case self::FINISHED:
                $result = 'FINISHED';
                break;
            case self::REJECTED:
                $result = 'REJECTED';
                break;
            case self::CANCELED:
                $result = 'CANCELED';
                break;
            case self::REFUNDED_REQUEST:
                $result = 'REFUNDED REQUEST';
                break;
            case self::REFUNDED:
                $result = 'REFUNDED';
                break;
            case self::RETURNED:
                $result = 'RETURNED';
                break;
            default:
                $result = '';
                break;
        }

        return $result;
    }

    public function statusWithLabel()
    {
        switch ($this->order_status) {
            case self::NEW_ORDER:
                $result = '<span class="badge badge-success"> NEW ORDER</span>';
                break;
            case self::PAYMENT_COMPLETED:
                $result = '<span class="badge badge-warning"> PAYMENT COMPLETED</span>';
                break;
            case self::UNDER_PROCESS:
                $result = '<span class="badge badge-warning-light"> UNDER PROCESS</span>';
                break;
            case self::FINISHED:
                $result = '<span class="badge badge-primary"> FINISHED </span>';
                break;
            case self::REJECTED:
                $result = '<span class="badge badge-danger"> REJECTED </span>';
                break;
            case self::CANCELED:
                $result = '<span class="badge badge-danger-light"> CANCELED </span>';
                break;
            case self::REFUNDED_REQUEST:
                $result = '<span class="badge badge-dark-light"> REFUNDED REQUEST</span>';
                break;
            case self::REFUNDED:
                $result = '<span class="badge badge-dark"> REFUNDED </span>';
                break;
            case self::RETURNED:
                $result = '<span class="badge badge-success-light"> RETURNED </span>';
                break;
            default:
                $result = '';
                break;
        }

        return $result;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo( User::class );
    }

    public function user_address(): BelongsTo
    {
        return $this->belongsTo( UserAddress::class );
    }

    public function shipping_company(): BelongsTo
    {
        return $this->belongsTo( ShippingCompany::class );
    }

    public function payment_method(): BelongsTo
    {
        return $this->belongsTo( PaymentMethod::class );
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany( Product::class )->withPivot( 'qty' );
    }

    public function transactions(): HasMany
    {
        return $this->hasMany( OrderTransaction::class );
    }


}
