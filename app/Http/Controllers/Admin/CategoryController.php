<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    /**
     * Display all categories.
     */
    public function all_categories()
    {
        $categories = Category::orderBy('category_name')->get();
        return view('admin.category_management', compact('categories'));
    }

    /**
     * Show all categories in table.
     */
    public function categoryData() {
        $categories = Category::orderBy('id');
        
        return DataTables::of($categories)
        ->addIndexColumn()
        ->addColumn('category_image', function ($row) {
            if ($row->category_image) {
                return '<img src="' . $row->category_image . '" class="img-thumbnail" style="max-width: 100px; max-height: 70px;">';
            }
            return '';
        })
        ->addColumn('status', function ($row) {
            return $row->status == 1
            ? '<span class="badge rounded badge-soft-success font-size-12">Active</span>'
            : '<span class="badge rounded badge-soft-danger font-size-12">Inactive</span>';
        })
        ->addColumn('action', function ($row) {
            $categoryJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
            $editBtn = '<a href="#" class="btn btn-success btn-sm category-btn-edit" title="Edit Category" data-category=\'' .$categoryJson . '\'><i class="mdi mdi-pencil"></i></a>';

            $deleteForm = '<form class="delete-confirmation d-inline" action="' . route('delete_category', $row->id) . '" method="POST">'
                        . csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm" title="Delete Category"><i class="mdi mdi-delete"></i></button>
                        </form>';

            return '<div class="d-flex gap-3 justify-content-center">' . $editBtn . $deleteForm . '</div>';
        })
        ->rawColumns(['category_image', 'status', 'action'])
        ->make(true);
    }

    /**
     * Add category.
     */
    public function add_category(Request $request)
    {
        $data = $request->validate([
            'category_name' => 'required',
            'category_image' => 'nullable|image|mimes:jpg,jpeg,png,ico,gif|max:2048', //2MB
        ]);
        
        try {
            $data = $request->all();
            
            if ($request->hasFile('category_image')) {
                $file = $request->file('category_image');
                $path = Storage::disk('s3')->putFile('category_image', $file, 'public');
                $data['category_image'] = Storage::disk('s3')->url($path);
            }

            Category::create($data);

            return redirect()->route('category-management')->with('success', 'Category added successfully.');

        } catch (QueryException $e) {
            Log::error('DB Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        
        } catch (\Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Update category.
     */
    public function update_category(Request $request, string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('category-management')->with('error', 'Category not found.');
        }

        $request->validate([
            'category_name' => 'required',
        ]);

        
        try {
            $data = $request->all();
            
            if ($request->hasFile('category_image')) {
                // Delete old image from S3 if exists
                if ($category->category_image) {
                    $oldPath = parse_url($category->category_image, PHP_URL_PATH);
                    $oldPath = ltrim($oldPath, '/');
                    Storage::disk('s3')->delete($oldPath);
                }

                // Upload new logo
                $file = $request->file('category_image');
                $path = Storage::disk('s3')->putFile('category_image', $file, 'public');
                $data['category_image'] = Storage::disk('s3')->url($path);
            }

            $category->update($data);

            return redirect()->route('category-management')->with('success', 'Category updated successfully.');
            
        } catch (QueryException $e) {
            Log::error('DB Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete category.
     */
    public function delete_category(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('category-management')->with('error', 'Category not found.');
        }

        try {
            // Delete category image from S3
            if ($category->category_image) {
                $path = parse_url($category->category_image, PHP_URL_PATH);
                $path = ltrim($path, '/');
                Storage::disk('s3')->delete($path);
            }

            $category->delete();
            
            return redirect()->route('category-management')->with('success', 'Category deleted successfully.');

        } catch (QueryException $e) {
            Log::error('DB Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
