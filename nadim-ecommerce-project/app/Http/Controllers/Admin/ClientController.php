<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Admin\Client;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display clients data.
     */
    public function clientManagement()
    {
        $clients = Client::with('address')->orderBy('id', 'desc')->get();
        return view('admin.client_management', compact('clients'));
    }

    /**
     * Show all clients in table.
     */
    public function clientsData()
    {
        $clients = Client::with('address');

        return DataTables::of($clients)
        ->addIndexColumn()
        ->addColumn('address', function ($client) {
            return '<button class="btn btn-primary btn-sm view-address-btn" data-id="'.$client->id.'" title="View Address"><i class="fa fa-eye"></i></button>';
        })
        ->editColumn('status', function ($client) {
            return $client->status == 1
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';
        })
        ->addColumn('actions', function ($client) {
            return '<a href="#" class="btn btn-success btn-sm client-btn-edit" title="Edit Client" data-id="'.$client->id.'"><i class="mdi mdi-pencil"></i></a>
                    <form style="display:inline;" method="POST" title="Delete Client" action="'.route('delete_client', $client->id).'">
                        '.csrf_field().method_field('DELETE').'
                        <button class="btn btn-danger btn-sm"><i class="mdi mdi-delete"></i></button>
                    </form>';
        })
        ->rawColumns(['address', 'status', 'actions'])
        ->make(true);
    }

    /**
     * Show user edit information.
     */
    public function showClient($id)
    {
        $client = Client::with('address')->findOrFail($id);
        return response()->json($client);
    }

    /**
     * All client addresses.
     */
    public function clientAddresses($id)
    {
        $client = Client::with('address')->findOrFail($id);

        return response()->json([
            'client_name' => $client->name,
            'addresses' => $client->address,
        ]);
    }

    /**
     * Add client.
     */
    public function add_client(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:clients,email',
            'mobile' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required'
        ]);

        $data = $request->all();
        $data['status'] = 1;
        
        $result = Client::create($data);

        if($result) {
            return redirect()->route('client-management')->with('success', 'Client added successfully.');
        } else {
            return redirect()->route('client-management')->with('error', 'Client could not be added. Please try again.');
        }
    }

    /**
     * Update client.
     */
    public function update_client(Request $request, string $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return redirect()->route('client-management')->with('error', 'Account not found.');
        }

         $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:clients,email,'. $client->id,
            'mobile' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required'
        ]);
        $data['status'] = $request->status;
        if ($client) {
            $result = $client->update($data);
            if($result) {
                return redirect()->route('client-management')->with('success', 'Client updated successfully.');
            } else {
                return redirect()->route('client-management')->with('error', 'Client could not be updated. Please try again.');
            }
        } else {
            return redirect()->route('client-management')->with('error', 'Client not found.');
        }
    }

    /**
     * Delete client.
     */
    public function delete_client(string $id)
    {
        $result = Client::find($id)->delete();

        if($result) {
            return redirect()->route('client-management')->with('success', 'Client deleted successfully.');
        } else {
            return redirect()->route('client-management')->with('error', 'Client could not be deleted. Please try again.');
        }
    }
}
