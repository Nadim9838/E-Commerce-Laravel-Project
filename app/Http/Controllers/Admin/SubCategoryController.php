<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SubCategory;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class SubCategoryController extends Controller
{
    /**
     * Display all sub categories.
     */
    public function all_sub_categories()
    {
        $mainCategories = Category::orderBy('category_name')->get();
        return view('admin.subcategory_management', compact('mainCategories'));
    }

    /**
     * Show all sub categories in table.
     */
    public function subcategoryData() {
        $subCategories = SubCategory::with('category')->orderBy('subcategory_name');

        return DataTables::of($subCategories)
        ->addIndexColumn()
        ->addColumn('subcategory_image', function ($row) {
            if ($row->subcategory_image) {
                return '<img src="' . $row->subcategory_image . '" class="img-thumbnail" style="max-width: 100px; max-height: 70px;">';
            }
            return '';
        })
        ->addColumn('category_name', function ($row) {
            return optional($row->category)->category_name;
        })
        ->addColumn('status', function ($row) {
            if ($row->status === 1) {
                return '<span class="badge rounded badge-soft-success font-size-12">Active</span>';
            } else {
                return '<span class="badge rounded badge-soft-danger font-size-12">Inactive</span>';
            }
        })
        ->addColumn('action', function ($row) {
            $subCategoryJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
            $edit = '<a href="#" class="btn btn-success btn-sm subcategory-btn-edit" title="Edit Sub Category" data-category=\'' . $subCategoryJson . '\'><i class="mdi mdi-pencil"></i></a>';
            $deleteUrl = route('delete_subcategory', $row->id);
            $delete = '<form class="delete-confirmation d-inline" action="' . $deleteUrl . '" method="POST">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Sub Category"><i class="mdi mdi-delete"></i></button>
                        </form>';
            return '<div class="d-flex gap-3 justify-content-center">' . $edit . $delete . '</div>';
        })
        ->rawColumns(['subcategory_image', 'status', 'action'])
        ->make(true);
    }

    /**
     * Add sub category.
     */
    public function add_subcategory(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required',
            'subcategory_name' => 'required',
            'subcategory_image' => 'nullable|image|mimes:jpg,jpeg,png,ico,gif|max:2048', //2MB
        ]);

        try {
            $data = $request->all();
            $data['status'] = 1;

            if ($request->hasFile('subcategory_image')) {
                $file = $request->file('subcategory_image');
                $path = Storage::disk('s3')->putFile('subcategory_image', $file, 'public');
                $data['subcategory_image'] = Storage::disk('s3')->url($path);
            }

            SubCategory::create($data);

            return redirect()->route('sub-category-management')->with('success', 'Sub Category added successfully.');
        
        } catch (QueryException $e) {
            Log::error('DB Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        
        } catch (\Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Update sub category.
     */
    public function update_subcategory(Request $request, string $id)
    {
        $category = SubCategory::find($id);
        
        if (!$category) {
            return redirect()->route('sub-category-management')->with('error', 'Sub Category not found.');
        }

        $request->validate([
            'category_id' => 'required',
            'subcategory_name' => 'required',
            'subcategory_image' => 'nullable|image|mimes:jpg,jpeg,png,ico,gif|max:2048', //2MB
        ]);


        try {
            $data = $request->all();
            
            if ($request->hasFile('subcategory_image')) {
                // Delete old image from S3 if exists
                if ($category->subcategory_image) {
                    $oldPath = parse_url($category->subcategory_image, PHP_URL_PATH);
                    $oldPath = ltrim($oldPath, '/');
                    Storage::disk('s3')->delete($oldPath);
                }

                // Upload new image
                $file = $request->file('subcategory_image');
                $path = Storage::disk('s3')->putFile('subcategory_image', $file, 'public');
                $data['subcategory_image'] = Storage::disk('s3')->url($path);
            }

            $category->update($data);
            
            return redirect()->route('sub-category-management')->with('success', 'Sub Category updated successfully.');
            
        } catch (QueryException $e) {
            Log::error('DB Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete sub category.
     */
    public function delete_subcategory(string $id)
    {
        $category = SubCategory::find($id);

        if (!$category) {
            return redirect()->route('sub-category-management')->with('error', 'Sub Category not found.');
        }

        try {
            // Delete sub category image from S3
            if ($category->subcategory_image) {
                $path = parse_url($category->subcategory_image, PHP_URL_PATH);
                $path = ltrim($path, '/');
                Storage::disk('s3')->delete($path);
            }

            $category->delete();
            
            return redirect()->route('sub-category-management')->with('success', 'Sub Category deleted successfully.');
    
        } catch (QueryException $e) {
            Log::error('DB Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
