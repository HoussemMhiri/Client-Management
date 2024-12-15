
@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Factures List</h1>
   
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" onclick="openAddFactureModal({{ $client_id }})" data-bs-target="#addFactureModal">
                Ajouter Facture
            </button>
        </div>

       
        <table class="table table-striped datatable" >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>amout</th>
                    <th>due_date</th>
                    <th>status</th>
                    <th>Created_at</th>
                    <th>Actions</th>
                  
                </tr>
            </thead>
            <tbody>
             
            </tbody>
        </table>
    </div>

    <x-facture-table  :totalUnpaid="$totalUnpaid" :overdueInvoices="$overdueInvoices" :client="$client" />
    <x-facture-modal />

    <x-delete-modal/>
    <x-edit-facture-modal />

@endsection



@section('scripts')
<script>
   
    function openAddFactureModal(clientId) {
     
        $('#addFactureModal').data('id', clientId); 
        $('#addFactureModal').modal('show'); 
    }
</script>


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
        let clientId = {{ $client_id }}; 

        let table = $('.datatable').DataTable({
           
            serverSide: true,
            processing: true,
            ajax: {
            url: `/factures/${clientId}`, 
            type: 'GET'
        },
        
            columns: [
                { data: 'id', name: 'id' },
                { data: 'amount', name: 'amount' },
                { data: 'due_date', name: 'due_date' },
                { data: 'status', name: 'status' },
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions' },
            ],
        });
    
  $('#editFactureModal').on('show.bs.modal', function (e) {
        let button = $(e.relatedTarget); 
        let factureId = button.data('id'); 
        let factureAmount = button.data('amount'); 
        let factureDue_date = button.data('due_date'); 
        let factureStatus = button.data('status'); 
    
        if (factureId) {
     
            let date = new Date(factureDue_date);

let formattedDate = date.toLocaleDateString('en-CA'); 
            $('#editFactureId').val(factureId); 
            $('#editAmount').val(factureAmount); 
            $('#editDueDate').val(formattedDate); 
            $('#editStatus').val(factureStatus); 
            
           
            $('#editFactureForm').attr('action', '/factures/' + factureId);
        } 
    });
    
    
    // edit
    $('#editFactureForm').on('submit', function (e) {
        e.preventDefault(); 
    
        let formData = $(this).serialize(); 
    
       
        $('#editAmount-error').text('');
        $('#editDueDate-error').text('');
        $('#editAmount').removeClass('is-invalid');
        $('#editDueDate').removeClass('is-invalid');
    
        $.ajax({
            url: $(this).attr('action'), 
            method: 'POST',
            data: formData,
            success: function (response) {
                if (response.success) {
                    $('#editFactureModal').modal('hide');
    
                    $('#editFactureForm')[0].reset();
                    table.ajax.reload(null, false);
                }
            },
            error: function (xhr, status, error) {
            handleAjaxValidationErrors(xhr, {
            email: { input: '#editAmount', feedback: '.invalid-feedback-amount' },
            phone: { input: '#editDueDate', feedback: '.invalid-feedback-date' },
            name: { input: '#editStatus', feedback: '.invalid-feedback-status' }
                });
            }
        });
    });
    

    // add

    $('#addFactureForm').on('submit', function(e) {
    e.preventDefault(); 

    let clientId = $('#addFactureModal').data('id');     
    let formData = $(this).serialize(); 

    $.ajax({
        url: '{{ url('factures') }}/' + clientId + '/store', 
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.success) {
                $('#addFactureModal').modal('hide'); 
                $('#addFactureForm')[0].reset(); 
                table.ajax.reload(null, false); 
            }
        },
        error: function (xhr, status, error) {
            handleAjaxValidationErrors(xhr, {
            email: { input: '#amount', feedback: '.invalid-feedback-amount' },
            phone: { input: '#due_date', feedback: '.invalid-feedback-date' },
            name: { input: '#status', feedback: '.invalid-feedback-status' }
                });
            }
    });
});

let factureIdToDelete = null;
    
   
    $('#confirmDeleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); 
        factureIdToDelete = button.data('id'); 
    });
    
   
    $('#confirmDeleteBtn').on('click', function () {
        
        $.ajax({
            url: '/factures/destroy/' + factureIdToDelete, 
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