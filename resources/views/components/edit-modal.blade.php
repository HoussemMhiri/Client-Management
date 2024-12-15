<!-- Edit Client Modal -->
<div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editClientModalLabel">Modifier Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editClientForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editClientId" name="id">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                        <div id="editEmail-error" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="editPhone" name="phone" required>
                        <div id="editPhone-error" class="invalid-feedback"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Modifier Client</button>
                </form>
            </div>
        </div>
    </div>
</div>
