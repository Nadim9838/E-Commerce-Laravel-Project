<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $guarded = [];

    // Category model
    public function Category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Product model
    public function Products()
    {
        return $this->belongsToMany(Product::class);
    }
}
