@php
    use App\Enums\StatusEnum;
@endphp

<div class="modal fade" id="addFactureModal" tabindex="-1" aria-labelledby="addFactureModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFactureModalLabel">Ajouter Facture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addFactureForm" method="POST" action="">
                    @csrf
                    <input type="hidden" id="client_id" name="client_id">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Montant</label>
                        <input type="number" class="form-control" id="amount" name="amount" required min="1" step="1">
                        <div id="amount-error" class="invalid-feedback-amount" style="color: red"></div>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Date d'échéance</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" required>
                        <div id="due_date-error" class="invalid-feedback-date" style="color: red"></div>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Statut</label>
                        <select class="form-control" id="status" name="status" required>
                            @foreach (StatusEnum::values() as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                        <div id="status-error" class="invalid-feedback-status" style="color: red"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter Facture</button>
                </form>
            </div>
        </div>
    </div>
</div>
