<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use App\Models\Admin\Brand;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Observers\BrandObserver;
use App\Models\Admin\SubCategory;
use App\Observers\ProductObserver;
use App\Observers\CategoryObserver;
use App\Observers\SubCategoryObserver;
use App\Observers\ProductCategoryObserver;
use App\Observers\ProductSubcategoryObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Brand::observe(BrandObserver::class);
        Product::observe(ProductObserver::class);
        Category::observe(CategoryObserver::class);
        SubCategory::observe(SubCategoryObserver::class);
        Category::observe(ProductCategoryObserver::class);
        SubCategory::observe(ProductSubcategoryObserver::class);
        
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
