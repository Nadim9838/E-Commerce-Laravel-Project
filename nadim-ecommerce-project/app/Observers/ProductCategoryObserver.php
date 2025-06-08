<?php

namespace App\Observers;

use App\Models\Admin\Category;

class ProductCategoryObserver
{
    public function pivotAttached(Category $category, $relationName, $pivotIds, $pivotIdsAttributes)
    {
        if ($relationName === 'products') {
            $category->increment('total_products', count($pivotIds));
        }
    }

    public function pivotDetached(Category $category, $relationName, $pivotIds)
    {
        if ($relationName === 'products') {
            $category->decrement('total_products', count($pivotIds));
        }
    }
}