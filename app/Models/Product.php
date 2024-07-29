<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'image',
        'description',
        'price',
        'quantity'
    ];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'orders', 'product_id', 'user_id');
    }

    public function Category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
