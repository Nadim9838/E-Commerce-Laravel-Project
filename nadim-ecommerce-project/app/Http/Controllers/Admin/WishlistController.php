<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Wishlist;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class WishlistController extends Controller
{
    /**
     * Display all wishlists.
     */
    public function all_wishlists()
    {
        $wishlists = Wishlist::with(['client.addresses'])->get();

        // Add formatted date manually
        foreach ($wishlists as $wishlist) {
            $wishlist->formated_wishlist_date = \Carbon\Carbon::parse($wishlist->created_at)->format('d-m-Y H:i');
        }
        return view('admin.wishlist_management', compact('wishlists'));
    }

    /**
     * All wishlists data
     */
    public function wishlistsData()
    {
        $wishlists = Wishlist::with(['client.addresses'])->latest();

        return DataTables::of($wishlists)
        ->addIndexColumn()
        ->addColumn('formated_wishlist_date', function ($row) {
            return \Carbon\Carbon::parse($row->created_at)->format('d-m-Y H:i');
        })
        ->addColumn('client_name', function ($row) {
            return $row->name;
        })
        ->addColumn('client_number', function ($row) {
            return $row->number;
        })
        ->addColumn('client_address', function ($row) {
            return $row->address;
        })
        ->addColumn('client_city', function ($row) {
            return $row->city;
        })
        ->addColumn('client_state', function ($row) {
            return $row->state;
        })
        ->addColumn('action', function ($row) {
            $delete = "<form class='delete-confirmation d-inline' method='POST' action='" . route('delete_wishlist', $row->id) . "'>
                " . csrf_field() . method_field('DELETE') . "
                <button type='submit' class='btn btn-danger btn-sm btn-delete' title='Delete Wishlist'><i class='mdi mdi-delete'></i></button>
            </form>";

            return "<div class='d-flex gap-3 justify-content-center'>{$delete}</div>";
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    /**
     * Delete wishlist.
     */
    public function delete_wishlist(string $id)
    {
        $wishlist = Wishlist::find($id);
        if (!$wishlist) {
            return redirect()->route('wishlist-management')->with('error', 'Wishlist not found.');
        }

        try {
            $wishlist->delete();

            return redirect()->route('wishlist-management')->with('success', 'Wishlist deleted successfully.');

        } catch (QueryException $e) {
            Log::error('DB Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
