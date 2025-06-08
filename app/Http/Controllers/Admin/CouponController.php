<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Coupon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class CouponController extends Controller
{
    /**
     * Display all coupons.
     */
    public function all_coupons()
    {
        $coupons = Coupon::orderBy('id', 'desc')->get();
        return view('admin.coupon_management', compact('coupons'));
    }

    /**
     * All coupon data
     */
    public function couponsData()
    {
        $coupons = Coupon::orderBy('id', 'desc')->get();

        return DataTables::of($coupons)
        ->addIndexColumn()
        ->editColumn('created_at', function ($row) {
            return $row->formatted_creation_date;
        })
        ->editColumn('validity', function ($row) {
            return $row->formatted_validity_date;
        })
        ->editColumn('offer', function ($row) {
            return $row->offer.'%';
        })
        ->editColumn('status', function ($row) {
            return $row->status === 1
                ? '<span class="badge rounded badge-soft-success font-size-12">Active</span>'
                : '<span class="badge rounded badge-soft-danger font-size-12">Inactive</span>';
        })
        ->addColumn('action', function ($row) {
            $couponJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
            $edit = "<a href='#' class='btn btn-success btn-sm coupon-btn-edit' title='Edit Coupon' data-coupon='" . $couponJson . "'><i class='mdi mdi-pencil'></i></a>";

            $delete = "<form class='delete-confirmation d-inline' method='POST' action='" . route('delete_coupon', $row->id) . "'>
                            " . csrf_field() . method_field('DELETE') . "
                            <button type='submit' class='btn btn-danger btn-sm btn-delete' title='Delete Coupon'><i class='mdi mdi-delete'></i></button>
                        </form>";

            return "<div class='d-flex gap-3 justify-content-center'>{$edit}{$delete}</div>";
        })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    /**
     * Add coupon.
     */
    public function add_coupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|unique:coupons,coupon_code',
            'coupon_name' => 'required',
            'offer' => 'required',
            'validity' => 'required'
        ]);

        try {
            $data = $request->all();
            $data['status'] = 1;
            
            Coupon::create($data);

            return redirect()->route('coupon-management')->with('success', 'Coupon added successfully.');

        } catch (QueryException $e) {
            Log::error('DB Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        
        } catch (\Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Update coupon.
     */
    public function update_coupon(Request $request, string $id)
    {
        $coupon = Coupon::find($id);
        
        if (!$coupon) {
            return redirect()->route('coupon-management')->with('error', 'Coupon not found.');
        }

        $request->validate([
            'coupon_code' => 'required|unique:coupons,coupon_code,'.$coupon->id,
            'coupon_name' => 'required',
            'offer' => 'required',
            'validity' => 'required'
        ]);

        try {
            $result = $coupon->update($request->all());

            return redirect()->route('coupon-management')->with('success', 'Coupon updated successfully.');

        } catch (QueryException $e) {
            Log::error('DB Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete coupon.
     */
    public function delete_coupon(string $id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return redirect()->route('coupon-management')->with('error', 'Coupon not found.');
        }
        
        try {
            $coupon->delete();

            return redirect()->route('coupon-management')->with('success', 'Coupon deleted successfully.');
            
        } catch (QueryException $e) {
            Log::error('DB Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
