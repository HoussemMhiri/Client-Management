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
        
        function handleAjaxValidationErrors(xhr, fieldSelectors) {
   
    let response = xhr.responseJSON;

    if (response && response.errors) {
        
        Object.keys(fieldSelectors).forEach(function (field) {
            const selector = fieldSelectors[field]; 

            if (response.errors[field]) {
                $(selector.input).addClass('is-invalid');
                $(selector.feedback).text(response.errors[field]);
            } else {
                $(selector.input).removeClass('is-invalid');
                $(selector.feedback).text('');
            }
        });
    } else {
        alert('An unexpected error occurred: ' + xhr.statusText);
    }
}

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
    
    
    //Edit
    $('#editClientForm').on('submit', function (e) {
        e.preventDefault(); 
    
        let formData = $(this).serialize();
    
        $('#editEmail-error').text('');
        $('#editPhone-error').text('');
        $('#editEmail').removeClass('is-invalid');
        $('#editPhone').removeClass('is-invalid'); 
    
        $.ajax({
            url: $(this).attr('action'), 
            method: 'POST', 
            data: formData,
            success: function (response) { 
                if (response.success) {
                    $('#editClientModal').modal('hide');
                    $('#editClientForm')[0].reset();
                    table.ajax.reload(null, false);
                }
            },
            error: function (xhr, status, error) {
            handleAjaxValidationErrors(xhr, {
            email: { input: '#editEmail', feedback: '.invalid-feedback-email' },
            phone: { input: '#editPhone', feedback: '.invalid-feedback-phone' },
            name: { input: '#editName', feedback: '.invalid-feedback-name' }
                });
            }
        });
    });
    
        // ADD
        $('#addClientForm').on('submit', function(e) {
            e.preventDefault(); 
    
            let formData = $(this).serialize(); 

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
                        $('#addClientModal').modal('hide'); 
                        $('#addClientForm')[0].reset(); 
                        table.ajax.reload(null, false); 
                    } 
                },
                error: function (xhr, status, error) {
            handleAjaxValidationErrors(xhr, {
            email: { input: '#email', feedback: '.invalid-feedback-email' },
            phone: { input: '#phone', feedback: '.invalid-feedback-phone' },
            name: { input: '#name', feedback: '.invalid-feedback-name' }
                });
            }       
            });
        });
    
        let clientIdToDelete = null;
    
    $('#confirmDeleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); 
        clientIdToDelete = button.data('id'); 
    });
    

    $('#confirmDeleteBtn').on('click', function () {
       
        $.ajax({
            url: '/clients/destroy/' + clientIdToDelete, 
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}', 
            },
            success: function (response) {
                $('#confirmDeleteModal').modal('hide');
    
                table.ajax.reload(null, false); 
    
            },
            error: function (xhr, status, error) {
                alert('Erreur lors de la suppression du client');
            }
        });
    });
    });
    
    
        </script>
@endsection    