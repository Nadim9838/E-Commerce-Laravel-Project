<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    protected $guarded = [];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
