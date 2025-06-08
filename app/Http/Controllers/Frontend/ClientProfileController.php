<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClientProfileController extends Controller
{
    /**
     * Add client details
     */
    public function addClient(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients',
            'mobile' => 'required|string|max:20',
            'dob' => 'required|date',
            'gender' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
            'profileImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $clientImagePath = null;
        if ($request->hasFile('profileImage')) {
            $file = $request->file('profileImage');
            $path = Storage::disk('s3')->putFile('client_images', $file, 'public');
            $clientImagePath = Storage::disk('s3')->url($path);
        }

        $client = Client::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'dob' => $validated['dob'],
            'gender' => $validated['gender'],
            'password' => $validated['password'],
            'profile_image' => $clientImagePath,
        ]);

        // Login the client
        Auth::guard('client')->login($client);

        return response()->json([
            'success' => true,
            'message' => 'Welcome! Your registration is complete.',
            'redirect' => route('home')
        ]);
    }

    /**
     * Update client details
     */
    public function updateClient(Request $request)
    {
        // Get the authenticated client
        $client = Auth::guard('client')->user();
        
        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients,email,'.$client->id,
            'mobile' => 'required|string|max:20',
            'dob' => 'required|date',
            'gender' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'zip_code' => 'nullable|string',
        ]);

        // Update client details
        $client->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'dob' => $validated['dob'],
            'gender' => $validated['gender'],
        ]);

        // Update or create address
        $addressData = [
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'country' => $validated['country'] ?? null,
            'zip_code' => $validated['zip_code'] ?? null,
            'address_type' => 'Shipping',
        ];

        // Assuming you have a hasOne relationship defined in Client model
        if ($client->address) {
            $client->address()->update($addressData);
        } else {
            $client->address()->create($addressData);
        }

        $client->load('address');
        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!',
            'user' => [
                'name' => $client->name,
                'email' => $client->email,
                'phone' => $client->mobile,
                'dob' => $client->dob,
                'address' => $client->address ? $client->address->address : null,
                'city' => $client->address ? $client->address->city : null,
                'state' => $client->address ? $client->address->state : null,
                'zip_code' => $client->address ? $client->address->zip_code : null,
                'country' => $client->address ? $client->address->country : null,
            ]
        ]);
    }

    /**
     * Update client image
     */
    public function updateClientImage(Request $request) {
        // Validate the request
        $data = $request->validate([
            'id' => 'required',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $client = Client::find($data['id']);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'User profile not found.'
            ]);
        }

        if ($request->hasFile('profile_image')) {
            // Delete old image from S3 if exists
            if ($client->profile_image) {
                $oldPath = parse_url($client->profile_image, PHP_URL_PATH);
                $oldPath = ltrim($oldPath, '/');
                Storage::disk('s3')->delete($oldPath);
            }

            // Upload image
            $file = $request->file('profile_image');
            $path = Storage::disk('s3')->putFile('client_images', $file, 'public');
            $imagePath['profile_image'] = Storage::disk('s3')->url($path);
            
            $client->update($imagePath);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function loginClient(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('client')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
                'redirect' => route('home')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'The provided credentials do not match our records.',
            'errors' => [
                'email' => ['These credentials do not match our records.']
            ]
        ], 422);

        return back()->with('error', 'The provided credentials do not match our records.');
    }

    public function logoutClient(Request $request)
    {
        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')->with('success', 'Logout successful!');
    }
}