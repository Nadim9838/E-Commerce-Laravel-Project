<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Cart;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class CartController extends Controller
{
    /**
     * Display all carts.
     */
    public function all_carts()
    {
        $carts = Cart::orderBy('id', 'desc')->get();
        return view('admin.cart_management', compact('carts'));
    }

    /**
     * All carts data
     */
    public function cartsData()
    {
        $carts = Cart::orderBy('id', 'desc');

        return DataTables::of($carts)
        ->addIndexColumn()
        ->addColumn('formatted_cart_date', function ($row) {
            return \Carbon\Carbon::parse($row->created_at)->format('d-m-Y H:i');
        })
        ->addColumn('action', function ($row) {
            $url = route('delete_cart', $row->id);
            return "<div class='d-flex gap-3 justify-content-center'>
                        <a href='{$url}' class='btn btn-danger btn-sm cart-btn-delete' title='Delete Cart'>
                            <i class='mdi mdi-delete'></i>
                        </a>
                    </div>";
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    /**
     * Delete cart.
     */
    public function delete_cart(string $id)
    {
        $cart = Cart::find($id);

        if(!$cart) {
            return redirect()->route('cart-management')->with('success', 'Cart Not Found.');
        }

        try {
            $cart->delete();

            return redirect()->route('cart-management')->with('success', 'Cart deleted successfully.');

        } catch (QueryException $e) {
            Log::error('DB Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
