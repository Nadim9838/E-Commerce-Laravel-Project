<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Branch;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class BranchController extends Controller
{
    /**
     * Display all branches.
     */
    public function all_branches()
    {
        $branches = Branch::orderBy('id', 'desc')->get();
        return view('admin.branch_management', compact('branches'));
    }

    /**
     * Add branch.
     */
    public function add_branch(Request $request)
    {
        $data = $request->validate([
            'branch_code' => 'required|unique:branches,branch_code',
            'name' => 'required',
            'number' => 'required',
            'email' => 'required',
            'password' => 'required',
            'branch_logo' => 'nullable|image|mimes:jpg,jpeg,png,ico|max:2048', //2MB
        ]);
        
        try {
            $data = $request->all();
            $data['status'] = 1;
            
            if ($request->hasFile('branch_logo')) {
                $file = $request->file('branch_logo');
                $path = Storage::disk('s3')->putFile('branch_logo', $file, 'public');
                $data['branch_logo'] = Storage::disk('s3')->url($path);
            }
            
            Branch::create($data);

            return redirect()->route('branch-management')->with('success', 'Branch added successfully.');

        } catch (QueryException $e) {
            Log::error('DB Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        
        } catch (\Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Update branch.
     */
    public function update_branch(Request $request, string $id)
    {
        $branch = Branch::find($id);

        if (!$branch) {
            return redirect()->route('client-management')->with('error', 'Branch not found.');
        }

        $request->validate([
            'branch_code' => 'required|unique:branches,branch_code,'. $branch->id,
            'name' => 'required',
            'email' => 'required',
            'number' => 'required',
            'password' => 'required',
            'branch_logo' => 'nullable|image|mimes:jpg,jpeg,png,ico|max:2048', //2MB
        ]);
        
        try {
            $data = $request->all();

            if ($request->hasFile('branch_logo')) {
                // Delete old image from S3 if exists
                if ($branch->branch_logo) {
                    $oldPath = parse_url($branch->branch_logo, PHP_URL_PATH);
                    $oldPath = ltrim($oldPath, '/');
                    Storage::disk('s3')->delete($oldPath);
                }

                // Upload new logo
                $file = $request->file('branch_logo');
                $path = Storage::disk('s3')->putFile('branch_logo', $file, 'public');
                $data['branch_logo'] = Storage::disk('s3')->url($path);
            }

            $branch->update($data);

            return redirect()->route('branch-management')->with('success', 'Branch updated successfully.');

        } catch (QueryException $e) {
            Log::error('DB Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete branch.
     */
    public function delete_branch(string $id)
    {
        $branch = Branch::find($id);

        if (!$branch) {
            return redirect()->route('branch-management')->with('error', 'Branch not found.');
        }

        try {
            // Delete logo from S3
            if ($branch->branch_logo) {
                $path = parse_url($branch->branch_logo, PHP_URL_PATH);
                $path = ltrim($path, '/');
                Storage::disk('s3')->delete($path);
            }

            $branch->delete();

            return redirect()->route('branch-management')->with('success', 'Branch deleted successfully.');

        } catch (QueryException $e) {
            Log::error('DB Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
