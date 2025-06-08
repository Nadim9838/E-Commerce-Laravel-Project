<?php

namespace App\Observers;

use App\Models\Admin\Category;
use Illuminate\Support\Str;

class CategoryObserver
{
    /**
     * Handle the Category "creating" event.
     */
    public function creating(Category $category): void
    {
        // Generate slug
        $slug = Str::slug($category->category_name);
        $originalSlug = $slug;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        $category->slug = $slug;

        // Generate unique category_code
        if (empty($category->category_code)) {
            $prefix = 'CAT-' . now()->format('Ymd') . '-';
            $lastCategory = Category::where('category_code', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
            $nextNumber = $lastCategory
                ? (int) str_replace($prefix, '', $lastCategory->category_code) + 1
                : 1;

            $category->category_code = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }

        // Default status set
        if (empty($category->status)) {
            $category->status = 1;
        }
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}
