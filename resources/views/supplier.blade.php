@extends('template')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<div class="container my-4">
    <button class="btn btn-primary btn-sm mb-3" onclick="showAddSupplierForm()">Add Supplier</button>

    <table id="suppliers-table" class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Contact Person</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <!-- Add Supplier Modal -->
    <div class="modal fade" id="supplierAddModal" tabindex="-1" aria-labelledby="supplierAddModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierAddModalLabel">Add Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSupplierForm">
                        <div class="mb-3">
                            <label for="addSupplierName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="addSupplierName" required>
                        </div>
                        <div class="mb-3">
                            <label for="addSupplierContactPerson" class="form-label">Contact Person</label>
                            <input type="text" class="form-control" id="addSupplierContactPerson" required>
                        </div>
                        <div class="mb-3">
                            <label for="addSupplierPhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="addSupplierPhone" required>
                        </div>
                        <div class="mb-3">
                            <label for="addSupplierEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="addSupplierEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="addSupplierAddress" class="form-label">Address</label>
                            <textarea class="form-control" id="addSupplierAddress" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Supplier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Supplier Modal -->
    <div class="modal fade" id="supplierEditModal" tabindex="-1" aria-labelledby="supplierEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierEditModalLabel">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSupplierForm">
                        <input type="hidden" id="editSupplierId">
                        <div class="mb-3">
                            <label for="editSupplierName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editSupplierName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSupplierContactPerson" class="form-label">Contact Person</label>
                            <input type="text" class="form-control" id="editSupplierContactPerson" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSupplierPhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="editSupplierPhone" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSupplierEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editSupplierEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSupplierAddress" class="form-label">Address</label>
                            <textarea class="form-control" id="editSupplierAddress" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#suppliers-table').DataTable({
            ajax: {
                url: 'http://localhost:8000/api/suppliers',
                dataSrc: ''
            },
            columns: [
                { data: 'name' },
                { data: 'contact_person' },
                { data: 'phone' },
                { data: 'email' },
                { data: 'address' },
                {
                    data: null,
                    render: function(data) {
                        return `
                            <button class="btn btn-warning btn-sm" onclick="showEditSupplier(${data.id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteSupplier(${data.id})">Delete</button>
                        `;
                    }
                }
            ]
        });

        // Show Add Supplier Modal
        window.showAddSupplierForm = function() {
            $('#addSupplierForm')[0].reset();
            $('#supplierAddModal').modal('show');
        };

        // Add Supplier
        $('#addSupplierForm').on('submit', function(e) {
            e.preventDefault();
            $.post('http://localhost:8000/api/suppliers', {
                name: $('#addSupplierName').val(),
                contact_person: $('#addSupplierContactPerson').val(),
                phone: $('#addSupplierPhone').val(),
                email: $('#addSupplierEmail').val(),
                address: $('#addSupplierAddress').val()
            }).done(function() {
                alert('Supplier added successfully!');
                $('#supplierAddModal').modal('hide');
                table.ajax.reload();
            }).fail(() => alert('Error adding supplier.'));
        });

        // Show Edit Supplier Modal
        window.showEditSupplier = function(id) {
            $.get(`http://localhost:8000/api/suppliers/${id}`, function(data) {
                $('#editSupplierId').val(data.id);
                $('#editSupplierName').val(data.name);
                $('#editSupplierContactPerson').val(data.contact_person);
                $('#editSupplierPhone').val(data.phone);
                $('#editSupplierEmail').val(data.email);
                $('#editSupplierAddress').val(data.address);
                $('#supplierEditModal').modal('show');
            });
        };

        // Edit Supplier
        $('#editSupplierForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editSupplierId').val();
            $.ajax({
                url: `http://localhost:8000/api/suppliers/${id}`,
                method: 'PUT',
                data: {
                    name: $('#editSupplierName').val(),
                    contact_person: $('#editSupplierContactPerson').val(),
                    phone: $('#editSupplierPhone').val(),
                    email: $('#editSupplierEmail').val(),
                    address: $('#editSupplierAddress').val()
                }
            }).done(function() {
                alert('Supplier updated successfully!');
                $('#supplierEditModal').modal('hide');
                table.ajax.reload();
            }).fail(() => alert('Error updating supplier.'));
        });

        // Delete Supplier
        window.deleteSupplier = function(id) {
            if (confirm('Are you sure you want to delete this supplier?')) {
                $.ajax({
                    url: `http://localhost:8000/api/suppliers/${id}`,
                    method: 'DELETE'
                }).done(function() {
                    alert('Supplier deleted successfully!');
                    table.ajax.reload();
                }).fail(() => alert('Error deleting supplier.'));
            }
        };
    });
</script>

@endsection
