<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = FALSE;
    public $incrementing = FALSE;
    protected $table = 'order_product';
}
