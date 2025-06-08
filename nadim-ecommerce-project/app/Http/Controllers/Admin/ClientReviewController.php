<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Client;
use App\Models\Admin\ClientReview;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use App\Models\Admin\ClientReviewBanner;

class ClientReviewController extends Controller
{
    /**
     * Display all banner images.
     */
    public function Client_review()
    {
        $banner = ClientReviewBanner::first();
        $reviews = ClientReview::with('client')->where('show_in_fron', 1);
        return view('admin.client_review_settings', compact('banner', 'reviews'));
    }

    /**
     * Add banner.
     */
    public function add_review_banner(Request $request)
    {
        $data = $request->validate([
            'review_banner' => 'required|image|mimes:jpg,jpeg,png|max:4096', //4MB
        ]);
        
        try {
            $data = $request->all();
            
            if ($request->hasFile('review_banner')) {
                $file = $request->file('review_banner');
                $path = Storage::disk('s3')->putFile('review_banner', $file, 'public');
                $data['review_banner'] = Storage::disk('s3')->url($path);
            }

            ClientReviewBanner::create($data);

            return redirect()->route('client-review-settings')->with('success', 'Client review banner image added successfully.');

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
    public function update_review_banner(Request $request, string $id)
    {
        $request->validate([
            'review_banner' => 'nullable|image|mimes:jpg,jpeg,png|max:4096', //4MB
        ]);
        
        $banner = ClientReviewBanner::find($id);
        
        if (!$banner) {
            return redirect()->route('client-review-settings')->with('error', 'Client review banner not found.');
        }

        try {
            $data = $request->all();
            
            if ($request->hasFile('review_banner')) {
                // Delete old image from S3 if exists
                if ($banner->review_banner) {
                    $oldPath = parse_url($banner->review_banner, PHP_URL_PATH);
                    $oldPath = ltrim($oldPath, '/');
                    Storage::disk('s3')->delete($oldPath);
                }

                // Upload new logo
                $file = $request->file('review_banner');
                $path = Storage::disk('s3')->putFile('review_banner', $file, 'public');
                $data['review_banner'] = Storage::disk('s3')->url($path);
            }

            $banner->update($data);

            return redirect()->route('client-review-settings')->with('success', 'Client review banner image updated successfully.');
            
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
    public function delete_review_banner(string $id)
    {
        $banner = ClientReviewBanner::find($id);

        if (!$banner) {
            return redirect()->route('client-review-settings')->with('error', 'Client review banner image not found.');
        }
        
        try {
            // Delete banner from S3
            if ($banner->review_banner) {
                $path = parse_url($banner->review_banner, PHP_URL_PATH);
                $path = ltrim($path, '/');
                Storage::disk('s3')->delete($path);
            }

            $banner->delete();

            return redirect()->route('client-review-settings')->with('success', 'Client review banner image deleted successfully.');
            
        } catch (QueryException $e) {
            Log::error('DB Error [Delete Banner]: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General Error [Delete Banner]: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
