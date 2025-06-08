<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductSubcategory extends Pivot
{
    protected $table = 'product_subcategory';
}