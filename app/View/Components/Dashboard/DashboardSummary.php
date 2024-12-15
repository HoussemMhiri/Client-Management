<?php

namespace App\View\Components\Dashboard;

use App\Models\Client;
use App\Models\Facture;
use Illuminate\View\Component;

class DashboardSummary extends Component
{
    public $totalClients;
    public $totalInvoices;
    public $totalUnpaid;

    public function __construct()
    {

        $this->totalClients = Client::count();

        $this->totalInvoices = Facture::count();

        $this->totalUnpaid = Facture::where('status', 'impayée')->sum('amount');
    }

    public function render()
    {
        return view('components.dashboard.dashboard-summary');
    }
}
