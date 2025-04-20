<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gadget extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'price',
        'cpu_model',
        'cpu_score',
        'battery_life',
        'weight',
        'display_size',
        'review_score',
        'retail_link'
    ];

    // Accessor untuk portability score
    public function getPortabilityAttribute()
    {
        return 100 - (($this->weight * 10) + $this->display_size);
    }

    // Scope untuk filter
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['brand'] ?? false, function ($query, $brand) {
         return $query->whereIn('brand', explode(',', $brand));
        });

        $query->when($filters['min_price'] ?? false, function($query, $price) {
            return$query->where('price', '>=', $price)
        });

        $query->when($filters['ram'] ?? false, function($query, $ram){
            return $query->where('ram', '>=', $ram)
        });
    }
}