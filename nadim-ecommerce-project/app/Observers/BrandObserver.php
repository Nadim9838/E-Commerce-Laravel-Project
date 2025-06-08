<?php

namespace App\Observers;

use App\Models\Admin\Brand;
use Illuminate\Support\Str;

class BrandObserver
{
    /**
     * Handle the Brand "creating" event.
     */
    public function creating(Brand $brand): void
    {
        // Generate slug
        $slug = Str::slug($brand->brand_name);
        $originalSlug = $slug;
        $counter = 1;
        while (Brand::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        $brand->slug = $slug;

        // Generate unique brand_code
        if (empty($brand->brand_code)) {
            $prefix = 'BRD-' . now()->format('Ymd') . '-';
            $lastBrand = Brand::where('brand_code', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
            $nextNumber = $lastBrand
                ? (int) str_replace($prefix, '', $lastBrand->brand_code) + 1
                : 1;

            $brand->brand_code = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }

        // Default status set
        if (empty($brand->status)) {
            $brand->status = 1;
        }
    }

    /**
     * Handle the Brand "updated" event.
     */
    public function updated(Brand $brand): void
    {
        //
    }

    /**
     * Handle the Brand "deleted" event.
     */
    public function deleted(Brand $brand): void
    {
        //
    }

    /**
     * Handle the Brand "restored" event.
     */
    public function restored(Brand $brand): void
    {
        //
    }

    /**
     * Handle the Brand "force deleted" event.
     */
    public function forceDeleted(Brand $brand): void
    {
        //
    }
}
