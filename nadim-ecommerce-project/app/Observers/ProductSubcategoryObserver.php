<?php

namespace App\Observers;

use App\Models\Admin\SubCategory;

class ProductSubcategoryObserver
{
    public function pivotAttached(SubCategory $subCategory, $relationName, $pivotIds, $pivotIdsAttributes)
    {
        if ($relationName === 'products') {
            $subCategory->increment('total_products', count($pivotIds));
        }
    }

    public function pivotDetached(SubCategory $subCategory, $relationName, $pivotIds)
    {
        if ($relationName === 'products') {
            $subCategory->decrement('total_products', count($pivotIds));
        }
    }
}