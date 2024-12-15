<div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
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
                    <input type="hidden" id="editClientId" name="id" value="">

                    <div class="mb-3">
                        <label for="editName" class="form-label">Nom</label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="editName" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required>
                               <div class="invalid-feedback-name" style="color: red"></div>
                    </div>

                  
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="editEmail" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required>
                               <div class="invalid-feedback-email" style="color: red"></div>
                    </div>

                 
                    <div class="mb-3">
                        <label for="editPhone" class="form-label">Phone</label>
                        <input type="text" 
                               class="form-control @error('phone') is-invalid @enderror" 
                               id="editPhone" 
                               name="phone" 
                               value="{{ old('phone') }}" 
                               required>
                             <div class="invalid-feedback-phone" style="color: red"></div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Modifier Client</button>
                </form>
            </div>
        </div>
    </div>
</div>
