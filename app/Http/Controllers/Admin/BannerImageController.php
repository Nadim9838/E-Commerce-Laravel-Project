<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\BannerImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class BannerImageController extends Controller
{
    /**
     * Display all banner images.
     */
    public function all_banner_image()
    {
        $banners = BannerImage::orderBy('id', 'desc')->get();
        return view('admin.banner_image_settings', compact('banners'));
    }

    /**
     * Add banner.
     */
    public function add_banner(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'banner_image' => 'required|image|mimes:jpg,jpeg,png|max:4096', //4MB
        ]);
        
        try {
            $data = $request->all();
            
            if ($request->hasFile('banner_image')) {
                $file = $request->file('banner_image');
                $path = Storage::disk('s3')->putFile('banner_image', $file, 'public');
                $data['banner_image'] = Storage::disk('s3')->url($path);
            }

            BannerImage::create($data);

            return redirect()->route('banner-image-settings')->with('success', 'Banner Image added successfully.');

            } catch (QueryException $e) {
                Log::error('DB Error [Add Banner]: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', $e->getMessage());
            } catch (\Exception $e) {
                Log::error('General Error [Add Banner]: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', $e->getMessage());
            }
        }

    /**
     * Update banner.
     */
    public function update_banner(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096', //4MB
        ]);
        
        $banner = BannerImage::find($id);
        
        if (!$banner) {
            return redirect()->route('banner-image-settings')->with('error', 'Banner Image not found.');
        }

        try {
            $data = $request->all();
            
            if ($request->hasFile('banner_image')) {
                // Delete old image from S3 if exists
                if ($banner->banner_image) {
                    $oldPath = parse_url($banner->banner_image, PHP_URL_PATH);
                    $oldPath = ltrim($oldPath, '/');
                    Storage::disk('s3')->delete($oldPath);
                }

                // Upload new logo
                $file = $request->file('banner_image');
                $path = Storage::disk('s3')->putFile('banner_image', $file, 'public');
                $data['banner_image'] = Storage::disk('s3')->url($path);
            }

            $banner->update($data);

            return redirect()->route('banner-image-settings')->with('success', 'Banner Image updated successfully.');
            
        } catch (QueryException $e) {
            Log::error('DB Error [Update Banner]: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General Error [Update Banner]: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete banner.
     */
    public function delete_banner(string $id)
    {
        $banner = BannerImage::find($id);

        if (!$banner) {
            return redirect()->route('banner-image-settings')->with('error', 'Banner Image not found.');
        }
        
        try {
            // Delete banner from S3
            if ($banner->banner_image) {
                $path = parse_url($banner->banner_image, PHP_URL_PATH);
                $path = ltrim($path, '/');
                Storage::disk('s3')->delete($path);
            }

            $banner->delete();

            return redirect()->route('banner-image-settings')->with('success', 'Banner Image deleted successfully.');
            
        } catch (QueryException $e) {
            Log::error('DB Error [Delete Banner]: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General Error [Delete Banner]: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
