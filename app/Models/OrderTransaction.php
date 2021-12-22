<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderTransaction extends Model
{
    use HasFactory;
    protected $guarded = [];

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
        switch ($this->transaction) {
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
    public function canReturnOrder()
    {
        return Carbon::now()->addDays(config('general.return_days'))->diffInDays($this->created_at->format('Y-m-d')) != 0;
    }
    public function isTransactionFinished()
    {
        return $this->transaction == self::FINISHED;
    }

    public function orders(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
