
@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Clients List</h1>
  
            <button class="btn btn-primary" id="modClientModalLabel" data-bs-toggle="modal" data-bs-target="#addClientModal">Ajouter</button>
        </div>


        <table class="table table-striped datatable" >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Created_at</th>
                    <th>Actions</th>
                  
                </tr>
            </thead>
           
        </table>
    </div>



    <x-client-modal />

    <x-delete-modal/>
    <x-edit-modal />

@endsection


@section('scripts')

<script type="text/javascript">


    $(document).ready(function() {
        let table = $('.datatable').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: '{{ route('clients.index') }}',
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions' },
            ],
        });
    
        $('#editClientModal').on('show.bs.modal', function (e) {
        let button = $(e.relatedTarget); 
        let clientId = button.data('id'); 
        let clientName = button.data('name'); 
        let clientEmail = button.data('email'); 
        let clientPhone = button.data('phone'); 
    
        if (clientId) {
     
           
            $('#editClientId').val(clientId); 
            $('#editName').val(clientName); 
            $('#editEmail').val(clientEmail); 
            $('#editPhone').val(clientPhone); 
            
           
            $('#editClientForm').attr('action', '/clients/' + clientId);
        } 
    });
    
    
    // Form submission with AJAX for both editing and adding
    $('#editClientForm').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission
    
        let formData = $(this).serialize(); // Serialize the form data
    
        // Clear errors
        $('#editEmail-error').text('');
        $('#editPhone-error').text('');
        $('#editEmail').removeClass('is-invalid');
        $('#editPhone').removeClass('is-invalid');
    
        $.ajax({
            url: $(this).attr('action'), // Get the action URL from the form
            method: 'POST', // Always use POST as the form method (PUT is simulated via _method)
            data: formData,
            success: function (response) {
                if (response.success) {
                    // Close the modal
                    $('#editClientModal').modal('hide');
    
                    // Reset the form
                    $('#editClientForm')[0].reset();
                    table.ajax.reload(null, false);
                } else if (response.errors) {
                    // Show validation errors
                    if (response.errors.email) {
                        $('#editEmail').addClass('is-invalid');
                        $('#editEmail-error').text(response.errors.email);
                    }
                    if (response.errors.phone) {
                        $('#editPhone').addClass('is-invalid');
                        $('#editPhone-error').text(response.errors.phone);
                    }
                }
            },
            error: function (xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    });
    
        // Form submission with AJAX
        $('#addClientForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
    
            let formData = $(this).serialize(); // Serialize form data
    
            // Clear errors
            $('#email-error').text('');
            $('#phone-error').text('');
            $('#email').removeClass('is-invalid');
            $('#phone').removeClass('is-invalid');
    
            $.ajax({
                url: '{{ route('clients.store') }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#addClientModal').modal('hide'); // Hide the modal
                        $('#addClientForm')[0].reset(); // Reset the form
                        table.ajax.reload(null, false); // Reload DataTable without resetting pagination
                    } else if (response.errors) {
                        if (response.errors.email) {
                            $('#email').addClass('is-invalid');
                            $('#email-error').text(response.errors.email);
                        }
                        if (response.errors.phone) {
                            $('#phone').addClass('is-invalid');
                            $('#phone-error').text(response.errors.phone);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        });
    
        let clientIdToDelete = null;
    
    // Open the modal and store client ID
    $('#confirmDeleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        clientIdToDelete = button.data('id'); // Extract client ID from data-id attribute
    });
    
    // Handle delete confirmation
    $('#confirmDeleteBtn').on('click', function () {
        // Send AJAX request to delete client
        $.ajax({
            url: '/clients/destroy/' + clientIdToDelete, // Adjust the URL to your route
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}', // CSRF token for security
            },
            success: function (response) {
                // Close the modal
                $('#confirmDeleteModal').modal('hide');
    
                // Reload the DataTable to reflect the change
                table.ajax.reload(null, false); // This assumes your DataTable instance is stored in `table`
    
            },
            error: function (xhr, status, error) {
                alert('Erreur lors de la suppression du client');
            }
        });
    });
    });
    
    
        </script>
@endsection    