@php
    use App\Enums\StatusEnum;
@endphp

<!-- Edit Facture Modal -->
<div class="modal fade" id="editFactureModal" tabindex="-1" aria-labelledby="editFactureModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFactureModalLabel">Modifier Facture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editFactureForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="facture_id" name="facture_id">
                    <div class="mb-3">
                        <label for="editAmount" class="form-label">Montant</label>
                        <input type="number" class="form-control" id="editAmount" name="amount" required min="1" step="1">
                        <div id="editAmount-error" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editDueDate" class="form-label">Date d'échéance</label>
                        <input type="date" class="form-control" id="editDueDate" name="due_date" required>
                        <div id="editDueDate-error" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Statut</label>
                        <select class="form-control" id="editStatus" name="status" required>
                            @foreach (StatusEnum::values() as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                        <div id="editStatus-error" class="invalid-feedback"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Modifier Facture</button>
                </form>
            </div>
        </div>
    </div>
</div>
