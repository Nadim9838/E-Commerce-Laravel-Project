<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ProductFeature;
use App\Models\Admin\ProductPhoto;
use App\Models\Admin\SubCategory;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\Admin\TaxSlab;
use App\Models\Admin\Brand;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    /**
     * Show product management view with related data.
     */
    public function all_products()
    {
        return view('admin.product_management', [
            'products' => Product::with(['categories', 'subCategories', 'brands'])->orderByDesc('id')->get(),
            'categories' => Category::orderBy('category_name')->get(),
            'subCategories' => SubCategory::orderBy('subcategory_name')->get(),
            'brands' => Brand::orderBy('brand_name')->get(),
            'taxSlabs' => TaxSlab::orderBy('tax')->get(),
        ]);
    }

    /**
     * Provide product data for DataTables.
     */
    public function productsData()
    {
        $products = Product::with(['categories', 'subCategories', 'brands', 'photos', 'features'])->orderByDesc('id');

        return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('feature_photo', fn($row) =>
                $row->feature_photo ? '<img src="' . $row->feature_photo . '" class="img-thumbnail" style="max-width: 100px;">' : ''
            )
            ->addColumn('other_images', fn($row) =>
                $row->photos->count() > 0
                    ? '<a href="#" class="btn btn-sm btn-primary view-photos-btn" data-product-id="' . $row->id . '" data-toggle="modal" data-target="#photosModal"><i class="fa-solid fa-images"></i> (' . $row->photos->count() . ')</a>'
                    : 'No Other photos'
            )
            ->addColumn('product_attribute', fn($row) =>
                '<a href="javascript:void(0);" class="btn btn-primary btn-sm product-attributes-btn" data-product-id="' . $row->id . '"><i class="mdi mdi-tune"></i> Attributes</a>'
            )
            ->addColumn('brand_name', fn($row) => $row->brands->brand_name ?? '-')
            ->addColumn('category_name', fn($row) => $row->categories->pluck('category_name')->join(', ') ?: '-')
            ->addColumn('subcategory_name', fn($row) => $row->subCategories->pluck('subcategory_name')->join(', ') ?: '-')
            ->addColumn('features', fn($row) => $row->features->features ?? 'N/A')
            ->addColumn('movement', fn($row) => $row->features->movement ?? 'N/A')
            ->addColumn('calibre', fn($row) => $row->features->calibre ?? 'N/A')
            ->addColumn('series', fn($row) => $row->features->series ?? 'N/A')
            ->addColumn('case_size', fn($row) => $row->features->case_size ?? 'N/A')
            ->addColumn('case_shape', fn($row) => $row->features->case_shape ?? 'N/A')
            ->addColumn('case_material', fn($row) => $row->features->case_material ?? 'N/A')
            ->addColumn('dial_color', fn($row) => $row->features->dial_color ?? 'N/A')
            ->addColumn('strap_type', fn($row) => $row->features->strap_type ?? 'N/A')
            ->addColumn('strap_color', fn($row) => $row->features->strap_color ?? 'N/A')
            ->addColumn('status', fn($row) =>
                $row->status === 1
                    ? '<span class="badge rounded badge-soft-success font-size-12">Active</span>'
                    : '<span class="badge rounded badge-soft-danger font-size-12">Inactive</span>'
            )
            ->addColumn('action', function ($row) {
                $productJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                $featuresJson = htmlspecialchars(json_encode($row->features), ENT_QUOTES, 'UTF-8');
                return '<div class="d-flex gap-3 justify-content-center">'
                    . '<a href="#" class="btn btn-success btn-sm product-btn-edit mr-2" title="Edit Product" data-product=\'' . $productJson . '\' data-features=\'' . $featuresJson . '\'><i class="mdi mdi-pencil"></i></a>'
                    . '<form class="delete-confirmation d-inline" action="' . route('delete_product', $row->id) . '" method="POST">'
                    . csrf_field() . method_field('DELETE')
                    . '<button type="submit" class="btn btn-danger btn-sm" title="Delete Product"><i class="mdi mdi-delete"></i></button>'
                    . '</form></div>';
            })
            ->rawColumns(['feature_photo', 'other_images', 'product_attribute', 'status', 'action'])
            ->make(true);
    }

    /**
     * Add a new product.
     */
    public function add_product(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required',
            'product_brand' => 'required',
            'category_id' => 'required|array',
            'category_id.*' => 'exists:categories,id',
            'subcategory_id' => 'nullable|array',
            'subcategory_id.*' => 'exists:sub_categories,id',
            'feature_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'other_photos.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'stock' => 'required',
            'sort_desc' => 'required',
            'detail_desc' => 'nullable',
            'price' => 'required',
            'discount_price' => 'nullable',
            'model_no' => 'nullable',
            'sku' => 'nullable',
            'tax' => 'nullable',
            // product features
            'features' => 'nullable',
            'movement' => 'nullable',
            'calibre' => 'nullable',
            'series' => 'nullable',
            'case_size' => 'nullable',
            'case_shape' => 'nullable',
            'case_material' => 'nullable',
            'dial_color' => 'nullable',
            'strap_type' => 'nullable',
            'strap_color' => 'nullable',
        ]);

        try {
            $data = $request->except(['category_id', 'subcategory_id', 'other_photos']);
            $data = $request->except(['category_id', 'subcategory_id', 'other_photos', 'features', 'movement', 'calibre', 'series', 'case_size', 'case_shape', 'case_material', 'dial_color', 'strap_type', 'strap_color']);

            $data['status'] = 1;

            if ($request->hasFile('feature_photo')) {
                $path = Storage::disk('s3')->putFile('product_feature_photos', $request->file('feature_photo'), 'public');
                $data['feature_photo'] = Storage::disk('s3')->url($path);
            }

            $product = Product::create($data);

            // Create product features record
            $featureData = $request->only([
                'features', 'movement', 'calibre', 'series', 'case_size',
                'case_shape', 'case_material', 'dial_color', 'strap_type', 'strap_color'
            ]);

            $featureData['product_id'] = $product->id;
            $product->features()->create($featureData);

            $product->categories()->attach($request->category_id);
            $product->subCategories()->attach($request->subcategory_id ?? []);

            if ($request->hasFile('other_photos')) {
                foreach ($request->file('other_photos') as $photo) {
                    $url = Storage::disk('s3')->url(Storage::disk('s3')->putFile('product_other_photos', $photo, 'public'));
                    $product->photos()->create(['photo' => $url]);
                }
            }

            return redirect()->route('product-management')->with('success', 'Product added successfully.');

        } catch (QueryException $e) {
            Log::error('DB Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        
        } catch (\Throwable $e) {
            Log::error('Product Add Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Update an existing product.
     */
    public function update_product(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'product_name' => 'required',
            'product_brand' => 'required',
            'category_id' => 'required|array',
            'category_id.*' => 'exists:categories,id',
            'subcategory_id' => 'nullable|array',
            'subcategory_id.*' => 'exists:sub_categories,id',
            'feature_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'other_photos.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'stock' => 'required',
            'sort_desc' => 'required',
            'detail_desc' => 'nullable',
            'price' => 'required',
            'discount_price' => 'nullable',
            'model_no' => 'nullable',
            'sku' => 'nullable',
            'tax' => 'nullable',
            'status' => 'nullable',
            // product features
            'features' => 'nullable',
            'movement' => 'nullable',
            'calibre' => 'nullable',
            'series' => 'nullable',
            'case_size' => 'nullable',
            'case_shape' => 'nullable',
            'case_material' => 'nullable',
            'dial_color' => 'nullable',
            'strap_type' => 'nullable',
            'strap_color' => 'nullable',
        ]);

        try {
            $data = $request->except([
                'category_id', 'subcategory_id', 'other_photos',
                'features', 'movement', 'calibre', 'series', 'case_size',
                'case_shape', 'case_material', 'dial_color', 'strap_type', 'strap_color'
            ]);

            if ($request->hasFile('feature_photo')) {
                if ($product->feature_photo) {
                    $oldPath = parse_url($product->feature_photo, PHP_URL_PATH);
                    Storage::disk('s3')->delete(ltrim($oldPath, '/'));
                }
                $path = Storage::disk('s3')->putFile('product_feature_photos', $request->file('feature_photo'), 'public');
                $data['feature_photo'] = Storage::disk('s3')->url($path);
            }
            
            $product->update($data);
            
            // Update or create product features
            $featureData = $request->only([
                'features', 'movement', 'calibre', 'series', 'case_size',
                'case_shape', 'case_material', 'dial_color', 'strap_type', 'strap_color'
            ]);

            if ($product->features) {
                $product->features->update($featureData);
            } else {
                $featureData['product_id'] = $product->id;
                ProductFeature::create($featureData);
            }

            // Get current relationships for comparison
            $currentCategories = $product->categories->pluck('id')->toArray();
            $currentSubCategories = $product->subCategories->pluck('id')->toArray();
            
            // Sync relationships
            $product->categories()->sync($request->category_id ?? []);
            $product->subCategories()->sync($request->subcategory_id ?? []);
            
            if ($request->hasFile('other_photos')) {
                foreach ($request->file('other_photos') as $photo) {
                    $url = Storage::disk('s3')->url(Storage::disk('s3')->putFile('product_other_photos', $photo, 'public'));
                    $product->photos()->create(['photo' => $url]);
                }
            }

            return redirect()->route('product-management')->with('success', 'Product updated successfully.');

        } catch (QueryException $e) {
            Log::error('DB Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());

        } catch (\Throwable $e) {
            Log::error('Product Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete a product and related data.
     */
    public function delete_product(string $id)
    {
        $product = Product::find($id);
        if (!$product) return redirect()->route('product-management')->with('error', 'Product not found.');

        try {
            if ($product->feature_photo) {
                $path = parse_url($product->feature_photo, PHP_URL_PATH);
                Storage::disk('s3')->delete(ltrim($path, '/'));
            }

            foreach ($product->photos as $photo) {
                $path = parse_url($photo->photo, PHP_URL_PATH);
                Storage::disk('s3')->delete(ltrim($path, '/'));
            }

            // Detach relationships (observer will handle counts)
            $product->categories()->detach();
            $product->subCategories()->detach();
            $product->delete();

            return redirect()->route('product-management')->with('success', 'Product deleted successfully.');

        } catch (QueryException $e) {
            Log::error('DB Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());

        } catch (\Throwable $e) {
            Log::error('Product Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove product other images
     */
    public function removePhoto(ProductPhoto $photo)
    {
        try {
            $path = parse_url($photo->photo, PHP_URL_PATH);
            Storage::disk('s3')->delete(ltrim($path, '/'));
            
            // Delete record
            $photo->delete();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get all photos of a product.
     */
    public function getPhotos(Product $product)
    {
        return response()->json($product->photos);
    }

    /**
     * Delete a product's other photo.
     */
    public function deletePhoto(ProductPhoto $photo)
    {
        $path = parse_url($photo->photo, PHP_URL_PATH);
        Storage::disk('s3')->delete(ltrim($path, '/'));
        $photo->delete();

        return response()->json(['success' => true]);
    }
}
