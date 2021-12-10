<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
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

    public function scopeActive($query)
    {
        return $query->whereStatus( TRUE );
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper( $value );
    }

    public function discount($total)
    {
        if (!$this->checkExpiredDate() || !$this->checkUsedTimes()) {
            return 0;
        }

        return $this->checkGreaterThan( $total ) ? $this->doProcess( $total ) : 0;
    }

    protected function checkExpiredDate()
    {
        return
            $this->expire_date != '' ?
                Carbon::now()->between( $this->start_date, $this->expire_date, TRUE ) ?
                    TRUE : FALSE
                : TRUE;
    }

    protected function checkUsedTimes()
    {
        return
            $this->use_times != '' ?
                $this->use_times > $this->used_times ?
                    TRUE : FALSE
                : TRUE;
    }

    protected function checkGreaterThan($total)
    {
        return
            $this->greater_than != '' ?
                $total >= $this->greater_than ?
                    TRUE : FALSE
                : TRUE;
    }

    protected function doProcess($total)
    {
        switch ($this->type) {
            case "fixed":
                return $this->value;
                break;
            case "percentage":
                return ( $this->value / 100 ) * $total;
                break;
            default:
                return 0;
                break;
        }
    }

}
