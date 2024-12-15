<div class="container mt-5">
    <!-- Title Section -->
    <div class="mb-4">
        <h1 class="text-center text-primary mb-3">Factures Impayées en Retard</h1>
        <h4 class="text-center text-muted">Client: <strong>{{ $client->name }}</strong></h4>
    </div>

    <!-- Total Unpaid Amount Section -->
    <div class="mb-4 p-3 border rounded shadow-sm">
        <h3 class="text-success">Montant Total des Factures Impayées:</h3>
        <p class="fs-4 fw-bold">{{ number_format($totalUnpaid, 0) }} TND</p>
    </div>

    <!-- Overdue Invoices Table Section -->
    <div class="mb-5">
        <h3 class="text-danger mb-3">Liste des Factures Impayées en Retard</h3>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Montant</th>
                    <th>Date d'Échéance</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($overdueInvoices as $invoice)
                    <tr>
                        <td>{{ $invoice->id }}</td>
                        <td>{{ number_format($invoice->amount, 0) }} TND</td>
                        <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d-m-Y') }}</td>
                        <td>
                            <span class="badge 
                                @if($invoice->status === 'payée') bg-success 
                                @elseif($invoice->status === 'en attente') bg-warning 
                                @else bg-danger 
                                @endif">
                               {{ ucfirst($invoice->status->value) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add spacing below the table to avoid overlap with other content -->
<style>
    .container {
        padding-bottom: 50px;
    }
</style>
