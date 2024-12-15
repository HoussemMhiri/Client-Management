<div class="row">

    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Clients</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalClients }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                        <i class="fas fa-file-invoice fa-2x text-success"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Factures</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalInvoices }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                        <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Factures Impayées</h6>
                        <h2 class="mb-0 fw-bold">{{ number_format($totalUnpaid, 0) }} <small class="fs-6">TND</small></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
