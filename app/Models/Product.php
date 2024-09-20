<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'images',
        'description',
        'price',
        'is_active',
        'is_featured',
        'in_stock',
        'on_sale'
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeisAFeatured($query)
    {
        $query->where('is_active',1);
    }

    public function scopeisActive($query)
    {
        $query->where('is_featured',1);
    }

    public function scopeinStock($query)
    {
        $query->where('in_stock',1);
    }

    public function scopeonSale($query)
    {
        $query->where('on_sale',1);
    }

    public function scopeSlug($query,$slug)
    {
        $query->where('slug',$slug);
    }
}
