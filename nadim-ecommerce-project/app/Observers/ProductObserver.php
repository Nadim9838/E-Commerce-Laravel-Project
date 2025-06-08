<?php

namespace App\Observers;

use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\SubCategory;
use App\Models\Admin\Brand;
use Illuminate\Support\Str;

class ProductObserver
{
    /**
     * Handle the Product "creating" event.
     */
    public function creating(Product $product): void
    {
        // Generate slug
        $slug = Str::slug($product->product_name);
        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        $product->slug = $slug;

        // Generate unique product_code
        if (empty($product->product_code)) {
            $prefix = 'PROD-' . now()->format('Ymd') . '-';
            $lastProduct = Product::where('product_code', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
            $nextNumber = $lastProduct
                ? (int) str_replace($prefix, '', $lastProduct->product_code) + 1
                : 1;

            $product->product_code = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }

        // Default status set
        if (empty($product->status)) {
            $product->status = 1;
        }
    }

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product)
    {
        // Brand count
        if ($product->product_brand) {
            Brand::where('id', $product->product_brand)->increment('total_products');
        }

        // Categories count
        foreach ($product->categories as $category) {
            $category->increment('total_products');
        }

        // SubCategories count
        foreach ($product->subCategories as $subcategory) {
            $subcategory->increment('total_products');
        }
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product)
    {
        // Brand changed
        if ($product->isDirty('product_brand')) {
            $originalBrand = $product->getOriginal('product_brand');
            $newBrand = $product->product_brand;

            if ($originalBrand) {
                Brand::where('id', $originalBrand)->decrement('total_products');
            }

            if ($newBrand) {
                Brand::where('id', $newBrand)->increment('total_products');
            }
        }

        // Categories sync (manually update count)
        $originalCategories = $product->categories()->pluck('categories.id')->toArray();
        $currentCategories = $product->categories()->pluck('categories.id')->toArray();

        $removedCategories = array_diff($originalCategories, $currentCategories);
        $addedCategories = array_diff($currentCategories, $originalCategories);

        if ($removedCategories) {
            Category::whereIn('id', $removedCategories)->decrement('total_products');
        }

        if ($addedCategories) {
            Category::whereIn('id', $addedCategories)->increment('total_products');
        }

        // SubCategories sync
        $originalSubCategories = $product->subCategories()->pluck('sub_categories.id')->toArray();
        $currentSubCategories = $product->subCategories()->pluck('sub_categories.id')->toArray();

        $removedSubCategories = array_diff($originalSubCategories, $currentSubCategories);
        $addedSubCategories = array_diff($currentSubCategories, $originalSubCategories);

        if ($removedSubCategories) {
            SubCategory::whereIn('id', $removedSubCategories)->decrement('total_products');
        }

        if ($addedSubCategories) {
            SubCategory::whereIn('id', $addedSubCategories)->increment('total_products');
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product)
    {
        // Brand count
        if ($product->product_brand) {
            Brand::where('id', $product->product_brand)->decrement('total_products');
        }

        // Categories count
        foreach ($product->categories as $category) {
            $category->decrement('total_products');
        }

        // SubCategories count
        foreach ($product->subCategories as $subcategory) {
            $subcategory->decrement('total_products');
        }
    }
}