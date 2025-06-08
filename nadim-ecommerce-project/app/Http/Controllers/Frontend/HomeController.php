<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin\ClientReviewBanner;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Admin\SpecialOffer;
use App\Models\Admin\ClientAddress;
use App\Models\Admin\ClientReview;
use App\Models\Admin\BannerImage;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use App\Models\Admin\Brand;

class HomeController extends Controller
{
    public function index() {
        $banners = BannerImage::all();

        $categories = Category::where('status', 1)->get();

        $brands = Brand::where('status', 1)->get();
        
        $newArrivalProducts = Product::with(['brands', 'photos'])->whereHas('attributes', function($query) {
            $query->where('key', 'is_popular')->where('value', '1');
        })->orderByDesc('id')->take(4)->get();
        
        $popularProducts = Product::with(['brands', 'photos'])->whereHas('attributes', function($query) {
            $query->where('key', 'is_new_arrival')->where('value', '1');
        })->orderByDesc('id')->take(4)->get();

        $reviewBanner = ClientReviewBanner::first();

        $clientReviews = ClientReview::with('clients')->where('show_in_front', 1)->get();

        $specialOffer = SpecialOffer::first();
        return view('frontend.home', compact(
            'banners', 'categories', 'brands', 'specialOffer', 'newArrivalProducts', 'popularProducts', 'reviewBanner', 'clientReviews'
        ));
    }

    /**
     * Brand wise product collections
     */ 
    public function brandCollection($slug = "")
    {
        $brand = Brand::where('slug', $slug)->firstOrFail();
        $products = $brand->products()->where('status', 1)->get();

        return view('frontend.brand_collections', compact('brand', 'products'));
    }

    /**
     * Category wise product collections
     */ 
    public function categoryCollection($slug = "")
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $brands = Brand::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();
        $products = Product::whereHas('categories', function($query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->where('status', 1)->with(['categories'])->paginate(12);
        
        return view('frontend.category_collections', compact('category', 'products', 'brands', 'categories'));
    }

    public function userLogin() {
        return view('frontend.login');
    }

    public function userRegister() {
        if (Auth::guard('client')->check()) {
            return redirect()->route('home')->with('error', 'You are already logged in. Please logout first to register a new account.');
        }
        return view('frontend.register');
    }
    public function privacyPolicy() {
        return view('frontend.privacy_policy');
    }
    public function termsConditions() {
        return view('frontend.terms_conditions');
    }
    public function filterPage() {
        return view('frontend.filter');
    }

    public function cartPage() {
        return view('frontend.cart');
    }

    public function userProfile()
    {
        $client = Auth::guard('client')->user();
        
        if ($client) {
            return view('frontend.profile', compact('client'));
        }
        
        return redirect()->route('client.login')->with('error', 'Please login to view your profile');
    }

    public function showProdutDetails($productSlug = "") {
        if(!empty($productSlug)) {
            $popularProducts = Product::with(['brands', 'photos'])->whereHas('attributes', function($query) {
                $query->where('key', 'is_new_arrival')->where('value', '1');
            })->orderByDesc('id')->take(4)->get();
            $product = Product::with(['brands', 'photos', 'features'])->where('slug', $productSlug)->first();
            return view('frontend.show_product', compact('product', 'popularProducts'));
        } else {
            return redirect()->route('home')->with('error', 'This product not exists.');
        }
    }
}
