<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSlider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'short_description',
        'price',
        'image',
        'product_id'
    ];
}
