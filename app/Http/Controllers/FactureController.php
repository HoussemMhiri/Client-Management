<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\Client;
use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use App\Services\InvoiceService;

class FactureController extends Controller
{
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }
    public function index(Request $request, $client_id)
    {


        if ($request->ajax()) {

            $factures = Facture::where('client_id', $client_id);


            return DataTables::eloquent($factures)
                ->addColumn('actions', function ($facture) {
                    return '
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-primary d-flex align-items-center" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editFactureModal" 
                            data-id="' . $facture->id . '" 
                            data-amount="' . $facture->amount . '" 
                            data-due_date="' . $facture->due_date . '" 
                            data-status="' . $facture->status->value . '">
                            <i class="fas fa-edit me-1"></i> Modifier
                        </button>
                
                        <button class="btn btn-sm btn-outline-danger d-flex align-items-center" 
                            data-bs-toggle="modal" 
                            data-bs-target="#confirmDeleteModal" 
                            data-id="' . $facture->id . '">
                            <i class="fas fa-trash-alt me-1"></i> Supprimer
                        </button>
                    </div>
                ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        $client = Client::findOrFail($client_id);

        $totalUnpaid = $this->invoiceService->getTotalUnpaidAmount($client_id);
        $overdueInvoices = $this->invoiceService->getOverdueUnpaidInvoices($client_id);


        return view('factures.index', compact('client_id', 'totalUnpaid', 'overdueInvoices', 'client'));
    }




    public function store(Request $request, $clientId)
    {
        $client = Client::findOrFail($clientId);

        try {
            $validated = $request->validate([
                'amount' => 'required|numeric|gt:0',
                'due_date' => 'required|date',
                'status' => ['required', 'string', Rule::enum(StatusEnum::class)],
            ]);


            $facture = $client->factures()->create($validated);


            return response()->json([
                'success' => true,
                'message' => 'Facture ajoutée avec succès!',
                'data' => $facture,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        $facture = Facture::findOrFail($id);
        $validated = $request->validate([
            'amount' => 'required|numeric|gt:0',
            'due_date' => 'required|date',
            'status' => ['required', 'string', Rule::enum(StatusEnum::class)],
        ]);

        $facture->update($validated);

        return response()->json(['success' => true]);
    }


    public function destroy($id)
    {
        $facture = Facture::findOrFail($id);
        $facture->delete();

        return response()->json(['success' => true]);
    }
}
