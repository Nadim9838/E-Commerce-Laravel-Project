<?php

namespace App\Models\Admin;

use App\Models\Admin\Brand;
use App\Models\Admin\Category;
use App\Models\Admin\SubCategory;
use App\Models\Admin\ProductPhoto;
use App\Models\Admin\ProductFeature;
use App\Models\Admin\ProductAttribute;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    // Product photos
    public function photos()
    {
        return $this->hasMany(ProductPhoto::class);
    }

    // Product attributes
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    // Product features
    public function features()
    {
        return $this->hasOne(ProductFeature::class);
    }

    // Product categories
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id')
                    ->withPivot('product_id', 'category_id');
    }

    // Product sub categories
    public function subCategories()
    {
        return $this->belongsToMany(SubCategory::class, 'product_subcategory', 'product_id', 'sub_category_id')
                    ->withPivot('product_id', 'sub_category_id');
    }

    // Product brands
    public function brands()
    {
        return $this->belongsTo(Brand::class, 'product_brand');
    }

    protected $touches = ['categories', 'subCategories', 'brands'];
}
