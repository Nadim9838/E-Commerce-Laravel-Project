<?php

// Admin Routes
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\WishlistController;
use App\Http\Controllers\Admin\BannerImageController;
use App\Http\Controllers\Admin\TaxSlabController;
use App\Http\Controllers\Admin\SpecialOfferController;
use App\Http\Controllers\Admin\ClientReviewController;

// Frontend routes
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ClientProfileController;

use Illuminate\Support\Facades\Route;

/**
 * Middleware group to check user login or not
 */
Route::group(['middleware' => 'client.auth'], function() {
    Route::controller(HomeController::class)->group(function() {
        Route::get('/user-profile', 'userProfile')->name('user-profile');
        Route::get('/cart', 'cartPage')->name('cart');
    });
});

/**
 * Middleware group to check user already login
 */
Route::group(['middleware' => 'client.logged'], function() {
    Route::controller(HomeController::class)->group(function() {
        Route::get('/user-login', 'userLogin')->name('user-login');
        Route::get('/user-register', 'userRegister')->name('user-register');
    });
});

/**
 * Home page routes
 */
Route::controller(HomeController::class)->group(function() {
    Route::get('/', 'index')->name('home');
    Route::get('/privacy-policy', 'privacyPolicy')->name('privacy-policy');
    Route::get('/category/{slug}/filter', 'filteredProducts')->name('category.filter');
    Route::get('/terms-conditions', 'termsConditions')->name('terms-conditions');
    Route::get('/collections/category/{slug}', 'categoryCollection')->name('category.collection');
    Route::get('/collections/brand/{slug}', 'brandCollection')->name('brand.collection');
    Route::get('/product/show/{slug}', 'showProdutDetails')->name('product.show');
    Route::get('/filter', 'filterPage')->name('filter');
});

/**
 * Home page routes
 */
Route::controller(ClientProfileController::class)->group(function() {
    Route::post('/client/register', 'addClient')->name('client.register');
    Route::post('/client/login', 'loginClient')->name('client.login');
    Route::post('/profile/update', 'updateClient')->name('client.profile');
    Route::post('/client/profile_image', 'updateClientImage')->name('client.profile_image');
    Route::post('/client/logout', 'logoutClient')->name('client.logout');
});

/**
 * Redirect to home page
 */
Route::fallback(function () {
    return redirect('/');
});

/**
 * Dashboard Page Middleware Routes.
 */
Route::get('/dashboard', [UserController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

/**
 * Middleware authentication group.
 */
Route::middleware('auth')->group(function () {  
    
    /**
     * Profile Management Routes.
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /**
     * Order Management Routes.
     */
    Route::controller(OrderController::class)->group(function() {
        Route::get('/order-management', 'all_orders')->name('order-management');
        Route::get('/orders_data', 'ordersData')->name('orders.data');
        Route::post('/add_order', 'add_order');
        Route::post('/update_order/{id}', 'update_order');
        Route::delete('/delete_order/{id}', 'delete_order')->name('delete_order');
    });

    /**
     * Product Management Routes.
     */
    Route::controller(ProductController::class)->group(function() {
        Route::get('/product-management', 'all_products')->name('product-management');
        Route::get('/products_data', 'productsData')->name('products.data');
        Route::post('/add_product', 'add_product');
        Route::post('/update_product/{id}', 'update_product');
        Route::delete('/delete_product/{id}', 'delete_product')->name('delete_product');

        Route::get('/products/{product}/photos', 'getPhotos')->name('products.photos');
        Route::delete('/product_other_photo/{photo}', 'deletePhoto')->name('product_other_photo.destroy');
        Route::delete('/remove-product-photo/{photo}', 'removePhoto');
    });

    /**
     * Product Attribute Routes.
     */
    Route::controller(ProductAttributeController::class)->group(function() {
        Route::get('/products/{product}/attributes', 'index');
        Route::post('/products/{product}/attributes', 'store');
        Route::put('/product-attributes/{attribute}', 'update');
        Route::delete('/product-attributes/{attribute}', 'destroy');
    });

    /**
     * Brand Management Routes.
     */
    Route::controller(BrandController::class)->group(function() {
        Route::get('/brand-management', 'all_brands')->name('brand-management');
        Route::get('/brands_data', 'brandsData')->name('brands.data');
        Route::post('/add_brand', 'add_brand');
        Route::post('/update_brand/{id}', 'update_brand');
        Route::delete('/delete_brand/{id}', 'delete_brand')->name('delete_brand');
    });

    /**
     * Category Management Routes.
     */
    Route::controller(CategoryController::class)->group(function() {
        Route::get('/category-management', 'all_categories')->name('category-management');
        Route::get('/category_data', 'categoryData')->name('category.data');
        Route::post('/add_category', 'add_category');
        Route::post('/update_category/{id}', 'update_category');
        Route::delete('/delete_category/{id}', 'delete_category')->name('delete_category');
    });

    /**
     * Sub Category Management Routes.
     */
    Route::controller(SubCategoryController::class)->group(function() {
        Route::get('/sub-category-management', 'all_sub_categories')->name('sub-category-management');
        Route::get('/subcategory_data', 'subcategoryData')->name('subcategory.data');
        Route::post('/add_subcategory', 'add_subcategory');
        Route::post('/update_subcategory/{id}', 'update_subcategory');
        Route::delete('/delete_subcategory/{id}', 'delete_subcategory')->name('delete_subcategory');
    });

    /**
     * Cart Management Routes.
     */
    Route::controller(CartController::class)->group(function() {
        Route::get('/cart-management', 'all_carts')->name('cart-management');
        Route::get('/carts_data', 'cartsData')->name('carts.data');
        Route::post('/add_cart', 'add_cart');
        Route::post('/update_cart/{id}', 'update_cart');
        Route::delete('/delete_cart/{id}', 'delete_cart')->name('delete_cart');
    });

    /**
     * Wishlist Management Routes.
     */
    Route::controller(WishlistController::class)->group(function() {
        Route::get('/wishlist-management', 'all_wishlists')->name('wishlist-management');
        Route::get('/wishlists_data', 'wishlistsData')->name('wishlists.data');
        Route::post('/add_wishlist', 'add_wishlist');
        Route::post('/update_wishlist/{id}', 'update_wishlist');
        Route::delete('/delete_wishlist/{id}', 'delete_wishlist')->name('delete_wishlist');
    });

    /**
     * Client Management Routes.
     */
    Route::controller(ClientController::class)->group(function() {
        Route::get('/client-management', 'clientManagement')->name('client-management');
        Route::get('/clients/data', 'clientsData')->name('clients.data');
        Route::get('/clients/{id}/show', 'showClient')->name('clients.show');
        Route::get('/clients/{id}/addresses', 'clientAddresses')->name('clients.addresses');
        Route::post('/add_client', 'add_client');
        Route::post('/update_client/{id}', 'update_client');
        Route::delete('/delete_client/{id}', 'delete_client')->name('delete_client');
    });

    /**
     * Coupon Management Routes.
     */
    Route::controller(CouponController::class)->group(function() {
        Route::get('/coupon-management', 'all_coupons')->name('coupon-management');
        Route::get('/coupons_data', 'couponsData')->name('coupons.data');
        Route::post('/add_coupon', 'add_coupon');
        Route::post('/update_coupon/{id}', 'update_coupon');
        Route::delete('/delete_coupon/{id}', 'delete_coupon')->name('delete_coupon');
    });

    /**
     * Branch Management Routes.
     */
    Route::controller(BranchController::class)->group(function() {
        Route::get('/branch-management', 'all_branches')->name('branch-management');
        Route::post('/add_branch', 'add_branch');
        Route::post('/update_branch/{id}', 'update_branch');
        Route::delete('/delete_branch/{id}', 'delete_branch')->name('delete_branch');
    });

    /**
     * User Management Routes.
     */
    Route::controller(UserController::class)->group(function() {
        Route::get('/user-management', 'all_users')->name('user-management');
        Route::post('/add_user', 'add_user');
        Route::post('/update_user/{id}', 'update_user');
        Route::delete('/delete_user/{id}', 'delete_user')->name('delete_user');
        Route::get('/get_user_permission/{id}', 'getUserPermissions')->name('get_user_permission');
        Route::post('/save_user_permission/{id}', 'saveUserPermission')->name('save_user_permission');
    });

    /**
     * Tax Slab Routes.
     */
    Route::controller(TaxSlabController::class)->group(function() {
        Route::get('/tax-slab-settings', 'all_tax_slabs')->name('tax-slab-settings');
        Route::post('/add_tax', 'add_tax');
        Route::post('/update_tax/{id}', 'update_tax');
        Route::delete('/delete_tax/{id}', 'delete_tax')->name('delete_tax');
    });

    /**
     * Banner Image Routes.
     */
    Route::controller(BannerImageController::class)->group(function() {
        Route::get('/banner-image-settings', 'all_banner_image')->name('banner-image-settings');
        Route::post('/add_banner', 'add_banner');
        Route::post('/update_banner/{id}', 'update_banner');
        Route::delete('/delete_banner/{id}', 'delete_banner')->name('delete_banner');
    });

    /**
     * Special Offer Routes.
     */
    Route::controller(SpecialOfferController::class)->group(function() {
        Route::get('/special-offer-settings', 'special_offer')->name('special-offer-settings');
        Route::post('/add_setting', 'add_setting');
        Route::post('/update_setting/{id}', 'update_setting');
        Route::delete('/delete_setting/{id}', 'delete_setting')->name('delete_setting');
    });

    /**
     * Client Review Routes.
     */
    Route::controller(ClientReviewController::class)->group(function() {
        Route::get('/client-review-settings', 'client_review')->name('client-review-settings');
        Route::post('/add_review_banner', 'add_review_banner');
        Route::post('/update_review_banner/{id}', 'update_review_banner');
        Route::delete('/delete_review_banner/{id}', 'delete_review_banner')->name('delete_review_banner');
    });
});

require __DIR__.'/auth.php';
