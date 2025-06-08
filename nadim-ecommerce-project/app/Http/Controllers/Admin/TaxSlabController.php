<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\TaxSlab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class TaxSlabController extends Controller
{
    /**
     * Display all text slabs.
     */
    public function all_tax_slabs()
    {
        $taxes = TaxSlab::orderBy('tax')->get();
        return view('admin.tax_slab_settings', compact('taxes'));
    }

    /**
     * Add tax slab.
     */
    public function add_tax(Request $request)
    {
        $data = $request->validate([
            'tax' => 'required',
        ]);
        
        try {
            TaxSlab::create($data);
            return redirect()->route('tax-slab-settings')->with('success', 'Tax slab added successfully.');
        } catch (QueryException $e) {
            Log::error('DB Error [Add Banner]: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General Error [Add Banner]: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Update tax slab.
     */
    public function update_tax(Request $request, string $id)
    {
        $request->validate([
            'tax' => 'required',
        ]);

        $tax = TaxSlab::find($id);
        
        if (!$tax) {
            return redirect()->route('tax-slab-settings')->with('error', 'Tax not found.');
        }

        try {
            $data = $request->all();

            $tax->update($data);

            return redirect()->route('tax-slab-settings')->with('success', 'Tax slab updated successfully.');

        } catch (QueryException $e) {
            Log::error('DB Error [Update Banner]: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General Error [Update Banner]: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete tax.
     */
    public function delete_tax(string $id)
    {
        $tax = TaxSlab::find($id);

        if (!$tax) {
            return redirect()->route('tax-slab-settings')->with('error', 'Tax not found.');
        }

        try {
            $tax->delete();

            return redirect()->route('tax-slab-settings')->with('success', 'Tax slab deleted successfully.');

        } catch (QueryException $e) {
            Log::error('DB Error [Delete Banner]: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General Error [Delete Banner]: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
