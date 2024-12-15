<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;


class ClientController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $clients = Client::query();

            return DataTables::eloquent($clients)
                ->addColumn('actions', function ($client) {
                    return '
    <div class="d-flex gap-2">
        <button class="btn btn-sm btn-outline-primary d-flex align-items-center" 
            data-bs-toggle="modal" 
            data-bs-target="#editClientModal" 
            data-id="' . $client->id . '" 
            data-name="' . $client->name . '" 
            data-email="' . $client->email . '" 
            data-phone="' . $client->phone . '">
            <i class="fas fa-edit me-1"></i> Modifier
        </button>

        <button class="btn btn-sm btn-outline-danger d-flex align-items-center" 
            data-bs-toggle="modal" 
            data-bs-target="#confirmDeleteModal" 
            data-id="' . $client->id . '">
            <i class="fas fa-trash-alt me-1"></i> Supprimer
        </button>

        <a href="' . route('factures.index', ['client_id' => $client->id]) . '" 
            class="btn btn-sm btn-outline-success d-flex align-items-center">
            <i class="fas fa-info-circle me-1"></i> Détails
        </a>
    </div>
';
                })

                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('clients.index');
    }


    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'required|regex:/^\+?\d{8,15}$/',
        ]);

        $client = Client::create($validated);


        if ($client) {
            return response()->json(['success' => true, 'message' => 'Client ajouté avec succès!']);
        }

        return response()->json(['errors' => true, 'message' => 'Une erreur est survenue lors de l\'ajout du client.'], 422);
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('clients')->ignore($client->id)
            ],
            'phone' => 'required|string|max:14',
        ]);

        $client->update($validated);

        return response()->json(['success' => true]);
    }


    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return response()->json(['success' => true]);
    }
}
