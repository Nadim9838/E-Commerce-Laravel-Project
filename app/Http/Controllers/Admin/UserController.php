<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Admin Dashboard.
     */
    public function index()
    {
        if (!session('user_permissions.dashboard.view')) {
            return view('admin.no_permission');
        } else {
            return view('admin.dashboard');
        }
    }

    /**
     * Display all users.
     */
    public function all_users()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.user_management', compact('users'));
    }

    /**
     * Add user.
     */
    public function add_user(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required',
            'role' => 'required',
            'password' => 'required',
            'user_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        try {
            $data = $request->all();
            $data['status'] = 1;

            if ($request->hasFile('user_image')) {
                $data['user_image'] = $request->file('user_image')->store('user_image', 'public');
            }

            User::create($data);

            return redirect()->route('user-management')->with('success', 'User added successfully.');

        } catch (QueryException $e) {
            Log::error('DB Error [Add Banner]: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General Error [Add Banner]: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Update user.
     */
    public function update_user(Request $request, string $id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return redirect()->route('user-management')->with('error', 'User not found.');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'. $user->id,
            'mobile' => 'required',
            'role' => 'required',
            'password' => 'required',
            'user_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', //2MB
        ]);

        try {
            $data = $request->all();

            if ($request->hasFile('user_image')) {
                // Delete old user image
                if ($user->user_image && Storage::disk('public')->exists($user->user_image)) {
                    Storage::disk('public')->delete($user->user_image);
                }
        
                $data['user_image'] = $request->file('user_image')->store('user_image', 'public');
            }

            $user->update($data);

            return redirect()->route('user-management')->with('success', 'User updated successfully.');

        } catch (QueryException $e) {
            Log::error('DB Error [Update Banner]: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General Error [Update Banner]: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        if($result) {
            return redirect()->route('user-management')->with('success', 'User updated successfully.');
        } else {
            return redirect()->route('user-management')->with('error', 'User could not be updated. Please try again.');
        }
    }

    /**
     * Delete user.
     */
    public function delete_user(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('banner-image-settings')->with('error', 'User not found.');
        }

        if ($user->user_image && Storage::disk('public')->exists($user->user_image)) {
            Storage::disk('public')->delete($user->user_image);
        }

        try {
            $user->delete();

            return redirect()->route('user-management')->with('success', 'User deleted successfully.');

        } catch (QueryException $e) {
            Log::error('DB Error [Delete Banner]: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General Error [Delete Banner]: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show user permissions.
     */
    public function getUserPermissions($id)
    {
        try {
            $user = User::findOrFail($id);

            $modules = [
                ['name' => 'Dashboard', 'key' => 'dashboard'],
                ['name' => 'Order Management', 'key' => 'order'],
                ['name' => 'Product Management', 'key' => 'product'],
                ['name' => 'Category Management', 'key' => 'category'],
                ['name' => 'Brand Management', 'key' => 'brand'],
                ['name' => 'Cart Management', 'key' => 'cart'],
                ['name' => 'Wishlist Management', 'key' => 'wishlist'],
                ['name' => 'Coupon Management', 'key' => 'coupon'],
                ['name' => 'Branch Management', 'key' => 'branch'],
                ['name' => 'Client Management', 'key' => 'client'],
                ['name' => 'User Management', 'key' => 'user'],
                ['name' => 'Website Management', 'key' => 'website'],
            ];

            // Fetch permissions and build structure for Blade
            $permissions = DB::table('user_permissions')
                ->where('user_id', $user->id)
                ->get();

            $userPermissions = [];

            foreach ($permissions as $perm) {
                $userPermissions[$perm->permission] = [];

                foreach (['view', 'add', 'edit', 'delete', 'export'] as $action) {
                    if ($perm->$action) {
                        $userPermissions[$perm->permission][] = $action;
                    }
                }
            }

            return view('admin.user_permissions', compact('user', 'modules', 'userPermissions'));
    
        } catch (QueryException $e) {
            Log::error('DB Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Database error occurred while fetching permissions.');
        } catch (\Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred.');
        }
    }

    /**
     * Save user permissions.
     */
    public function saveUserPermission(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Clear old permissions
            DB::table('user_permissions')->where('user_id', $user->id)->delete();

            // Save submitted permissions
            if ($request->has('permissions')) {
                foreach ($request->permissions as $module => $actions) {
                    DB::table('user_permissions')->insert([
                        'user_id' => $user->id,
                        'permission' => $module,
                        'view'   => in_array('view', $actions),
                        'add'    => in_array('add', $actions),
                        'edit'   => in_array('edit', $actions),
                        'delete' => in_array('delete', $actions),
                        'export' => in_array('export', $actions),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }   
            return redirect()->back()->with('success', 'Permissions updated successfully!');
        
        } catch (QueryException $e) {
            Log::error('DB Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Database error occurred while saving permissions.');
        } catch (\Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred.');
        }
    }

}
