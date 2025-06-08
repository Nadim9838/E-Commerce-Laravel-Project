<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SpecialOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class SpecialOfferController extends Controller
{
    /**
     * Display all banner images.
     */
    public function special_offer()
    {
        $settings = SpecialOffer::limit(1)->get();
        return view('admin.special_offer_settings', compact('settings'));
    }

    /**
     * Add banner.
     */
    public function add_setting(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'sub_title' => 'required',
            'description' => 'required',
            'offer_image' => 'required|image|mimes:jpg,jpeg,png|max:2048', //2MB
        ]);
        
        try {
            
            if ($request->hasFile('offer_image')) {
                $file = $request->file('offer_image');
                $path = Storage::disk('s3')->putFile('offer_image', $file, 'public');
                $data['offer_image'] = Storage::disk('s3')->url($path);
            }

            SpecialOffer::create($data);

            return redirect()->route('special-offer-settings')->with('success', 'Special offer added successfully.');

            } catch (QueryException $e) {
                Log::error('DB Error [Add Special Offer]: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', $e->getMessage());
            } catch (\Exception $e) {
                Log::error('General Error [Add Special Offer]: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', $e->getMessage());
            }
        }

    /**
     * Update banner.
     */
    public function update_setting(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'sub_title' => 'required',
            'description' => 'required',
            'offer_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', //2MB
        ]);
        
        $banner = SpecialOffer::find($id);
        
        if (!$banner) {
            return redirect()->route('special-offer-settings')->with('error', 'Id not found.');
        }

        try {            
            if ($request->hasFile('offer_image')) {
                // Delete old image from S3 if exists
                if ($banner->offer_image) {
                    $oldPath = parse_url($banner->offer_image, PHP_URL_PATH);
                    $oldPath = ltrim($oldPath, '/');
                    Storage::disk('s3')->delete($oldPath);
                }

                // Upload new logo
                $file = $request->file('offer_image');
                $path = Storage::disk('s3')->putFile('offer_image', $file, 'public');
                $data['offer_image'] = Storage::disk('s3')->url($path);
            }

            $banner->update($data);

            return redirect()->route('special-offer-settings')->with('success', 'Special offer updated successfully.');
            
        } catch (QueryException $e) {
            Log::error('DB Error [Update Special Offer]: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General Error [Update Special Offer]: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete banner.
     */
    public function delete_setting(string $id)
    {
        $offer = SpecialOffer::find($id);

        if (!$offer) {
            return redirect()->route('special-offer-settings')->with('error', 'Banner Image not found.');
        }
        
        try {
            // Delete banner from S3
            if ($offer->offer_image) {
                $path = parse_url($offer->offer_image, PHP_URL_PATH);
                $path = ltrim($path, '/');
                Storage::disk('s3')->delete($path);
            }

            $offer->delete();

            return redirect()->route('special-offer-settings')->with('success', 'Special offer deleted successfully.');
            
        } catch (QueryException $e) {
            Log::error('DB Error [Delete Special Offer]: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General Error [Delete Special Offer]: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
