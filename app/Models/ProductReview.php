<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nicolaslopezj\Searchable\SearchableTrait;

class ProductReview extends Model
{
    use HasFactory, SearchableTrait;

    protected $fillable = [
        'user_id',
        'product_id',
        'name',
        'email',
        'title',
        'message',
        'status',
        'rating',
    ];

    protected $searchable = [
        'columns' => [
            'product_reviews.name' => 10,
            'product_reviews.email' => 10,
            'product_reviews.title' => 10,
            'product_reviews.message' => 10,
        ],
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo( Product::class );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo( User::class );
    }

}
