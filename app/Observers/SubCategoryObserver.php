<?php

namespace App\Observers;

use App\Models\Admin\SubCategory;
use Illuminate\Support\Str;

class SubCategoryObserver
{
    /**
     * Handle the SubCategory "creating" event.
     */
    public function creating(SubCategory $category): void
    {
        // Generate slug
        $slug = Str::slug($category->subcategory_name);
        $originalSlug = $slug;
        $counter = 1;
        while (SubCategory::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        $category->slug = $slug;

        // Generate unique subcategory_code
        if (empty($category->subcategory_code)) {
            $prefix = 'SUB-' . now()->format('Ymd') . '-';
            $lastSubCategory = SubCategory::where('subcategory_code', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
            $nextNumber = $lastSubCategory
                ? (int) str_replace($prefix, '', $lastSubCategory->subcategory_code) + 1
                : 1;

            $category->subcategory_code = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }

        // Default status set
        if (empty($category->status)) {
            $category->status = 1;
        }
    }

    /**
     * Handle the SubCategory "updated" event.
     */
    public function updated(SubCategory $category): void
    {
        //
    }

    /**
     * Handle the SubCategory "deleted" event.
     */
    public function deleted(SubCategory $category): void
    {
        //
    }

    /**
     * Handle the SubCategory "restored" event.
     */
    public function restored(SubCategory $category): void
    {
        //
    }

    /**
     * Handle the SubCategory "force deleted" event.
     */
    public function forceDeleted(SubCategory $category): void
    {
        //
    }
}
