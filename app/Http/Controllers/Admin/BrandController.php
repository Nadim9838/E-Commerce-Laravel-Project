<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Admin\Brand;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class BrandController extends Controller
{
    /**
     * Display all brands.
     */
    public function all_brands()
    {
        $brands = Brand::orderBy('brand_name')->get();
        return view('admin.brand_management', compact('brands'));
    }

    /**
     * Show all brands in table.
     */
    public function brandsData() {
        $brands = Brand::orderBy('brand_name')->get();

        return DataTables::of($brands)
        ->addIndexColumn()
        ->addColumn('brand_image', function ($row) {
            if ($row->brand_image) {
                return '<img src="' . $row->brand_image . '" class="img-thumbnail" style="max-width: 100px;">';
            }
            return '';
        })
        ->addColumn('status', function ($row) {
            return $row->status === 1
                ? '<span class="badge rounded badge-soft-success font-size-12">Active</span>'
                : '<span class="badge rounded badge-soft-danger font-size-12">Inactive</span>';
        })
        ->addColumn('action', function ($row) {
            $brandJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
            $edit = '<a href="#" class="btn btn-success btn-sm brand-btn-edit" data-brand=\'' . $brandJson . '\'><i class="mdi mdi-pencil"></i></a>';
            $delete = '<form class="delete-confirmation d-inline" action="' . route('delete_brand', $row->id) . '" method="POST">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm"><i class="mdi mdi-delete"></i></button>
                    </form>';
            return '<div class="d-flex gap-3 justify-content-center">' . $edit . $delete . '</div>';
        })
        ->rawColumns(['brand_image', 'status', 'action'])
        ->make(true);
    }
    /**
     * Add brand.
     */
    public function add_brand(Request $request)
    {
        $data = $request->validate([
            'brand_name'     => 'required|string|max:255',
            'brand_image'    => 'nullable|image|mimes:jpg,jpeg,png,ico,gif|max:2048', //2MB
            'meta_title'     => 'nullable|string|max:255',
            'meta_tags'      => 'nullable|string',
            'meta_keywords'  => 'nullable|string',
            'status'         => 'nullable',
        ]);

        try {
            // Upload image into s3 buket
            if ($request->hasFile('brand_image')) {
                $file = $request->file('brand_image');
                $path = Storage::disk('s3')->putFile('brand_image', $file, 'public');
                $data['brand_image'] = Storage::disk('s3')->url($path);
            }

            $result = Brand::create($data);

            return redirect()->route('brand-management')->with('success', 'Brand added successfully.');

        } catch (QueryException $e) {
            Log::error('DB Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Update brand.
     */
    public function update_brand(Request $request, string $id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return redirect()->route('brand-management')->with('error', 'Brand not found.');
        }

        $data = $request->validate([
            'brand_name'     => 'required|string|max:255',
            'brand_image'    => 'nullable|image|mimes:jpg,jpeg,png,ico,gif|max:2048', //2MB
            'meta_title'     => 'nullable|string|max:255',
            'meta_tags'      => 'nullable|string',
            'meta_keywords'  => 'nullable|string',
            'status'         => 'nullable',
        ]);

        
        try {
            $data = $request->all();
            
            if ($request->hasFile('brand_image')) {
                // Delete old image from S3 if exists
                if ($brand->brand_image) {
                    $oldPath = parse_url($brand->brand_image, PHP_URL_PATH);
                    $oldPath = ltrim($oldPath, '/');
                    Storage::disk('s3')->delete($oldPath);
                }

                // Upload image
                $file = $request->file('brand_image');
                $path = Storage::disk('s3')->putFile('brand_image', $file, 'public');
                $data['brand_image'] = Storage::disk('s3')->url($path);
            }

            $brand->update($data);

            return redirect()->route('brand-management')->with('success', 'Brand updated successfully.');

        } catch (QueryException $e) {
            Log::error('DB Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete brand.
     */
    public function delete_brand(string $id)
    {
        $brand = Brand::find($id);

        if(!$brand) {
            return redirect()->route('brand-management')->with('error', 'Brand Not Found.');
        }

        try {
            // Delete brand from S3
            if ($brand->brand_image) {
                $path = parse_url($brand->brand_image, PHP_URL_PATH);
                $path = ltrim($path, '/');
                Storage::disk('s3')->delete($path);
            }

            $brand->delete();
            
            return redirect()->route('brand-management')->with('success', 'Brand deleted successfully.');

        } catch (QueryException $e) {
            Log::error('DB Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
