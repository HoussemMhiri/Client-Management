<?php

namespace App\Services;

use App\Models\Facture;
use Carbon\Carbon;

class InvoiceService
{

    public function getTotalUnpaidAmount($clientId)
    {

        $factures = Facture::where('client_id', $clientId)
            ->where('status', '!=', 'payée')
            ->get();


        $totalUnpaid = $factures->sum('amount');

        return $totalUnpaid;
    }


    public function getOverdueUnpaidInvoices($clientId)
    {

        $today = Carbon::now();

        $overdueFactures = Facture::where('client_id', $clientId)
            ->where('status', '!=', 'payée')
            ->where('due_date', '<', $today)
            ->get();

        return $overdueFactures;
    }
}
