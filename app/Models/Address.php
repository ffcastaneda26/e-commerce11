<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'first_name',
        'last_name',
        'phone',
        'street_address',
        'city',
        'state',
        'country',
        'zip_code'
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name .' ' . $this->last_name;

    }
    public function order(): BelongsTo
    {
        return $this->belogsTo(Order::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(Order::class);
    }





}
