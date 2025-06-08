<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class OrderController extends Controller
{
    /**
     * Display all orders.
     */
    public function all_orders()
    {
        $orders = Order::orderBy('id', 'desc')->get();
        return view('admin.order_management', compact('orders'));
    }
    
    /**
     * Show all orders in table.
     */
    public function ordersData() {
        $orders = Order::orderBy('id', 'desc')->get();

        return DataTables::of($orders)
        ->addIndexColumn()
        ->addColumn('status', function ($row) {
            return !$row->status
                ? '<span class="badge rounded badge-soft-success font-size-12">Received</span>'
                : '<span class="badge rounded badge-soft-danger font-size-12">Inactive</span>';
        })
        ->addColumn('action', function ($row) {
            $edit = '<a href="#" class="btn btn-success btn-sm order-btn-edit" data-order=\'' . json_encode($row) . '\'><i class="mdi mdi-pencil"></i></a>';
            $delete = '<form class="delete-confirmation d-inline" action="' . route('delete_order', $row->id) . '" method="POST">'
                . csrf_field() . method_field('DELETE') .
                '<button type="submit" class="btn btn-danger btn-sm"><i class="mdi mdi-delete"></i></button>
                </form>';
            return '<div class="d-flex gap-3 justify-content-center">' . $edit . $delete . '</div>';
        })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    /**
     * Update order.
     */
    public function update_order(Request $request, string $id)
    {
        $order = Order::find($id);
        
        if(!$order) {
            return redirect()->route('order-management')->with('error', 'Order not found.');
        }

        try {
            $data = $request->all();
            $order->update($data);

            return redirect()->route('order-management')->with('success', 'Order updated successfully.');

        } catch (QueryException $e) {
            Log::error('DB Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete order.
     */
    public function delete_order(string $id)
    {
        $order = Order::find($id);

        if(!$order) {
            return redirect()->route('order-management')->with('error', 'Order not found.');
        }

        try {
            $order->delete();
        
            return redirect()->route('order-management')->with('success', 'Order deleted successfully.');

        } catch (QueryException $e) {
            Log::error('DB Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
