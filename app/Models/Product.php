<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $appends = ['brand_name', 'category_name'];

    protected $fillable = [
        'name',
        'description',
        'price',
        'discount',
        'discount_price',
        'image',
        'stock',
        'star',
        'remark',
        'user_id',
        'brand_id',
        'category_id',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getBrandNameAttribute()
    {
        $data = Brand::where('id', $this->brand_id)->first();
        return $data->name;
    }

    public function getCategoryNameAttribute()
    {
        $data = Category::where('id', $this->category_id)->first();
        return $data->name;

    }

}
