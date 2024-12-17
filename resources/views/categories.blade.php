@extends('template')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

{{-- <div class="container my-4"> --}}
    <button class="btn btn-warning btn-sm mb-3" onclick="showAddCategoryForm()">Add Category</button>
    <a href="{{ url('/categories_pdf') }}" class="btn btn-primary btn-sm mb-3">
        Category PDF
    </a>

    <table id="categories-table" class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <div class="modal fade" id="categoryAddModal" tabindex="-1" aria-labelledby="categoryAddModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryAddModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm">
                        <div class="mb-3">
                            <label for="addCategoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="addCategoryName" required>
                        </div>
                        <div class="mb-3">
                            <label for="addCategoryDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="addCategoryDescription" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="categoryEditModal" tabindex="-1" aria-labelledby="categoryEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryEditModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm">
                        <input type="hidden" id="editCategoryId">
                        <div class="mb-3">
                            <label for="editCategoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="editCategoryName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCategoryDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editCategoryDescription" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this category?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
{{-- </div> --}}

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#categories-table').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: '/api/categories',
                dataSrc: '' // API returns raw array
            },
            columns: [
                { data: 'name' },
                { data: 'description' },
                {
                    data: null,
                    render: function(data) {
                        return `
                            <button class="btn btn-warning btn-sm" onclick="showEditCategory(${data.id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteCategory(${data.id})">Delete</button>
                        `;
                    }
                }
            ]
        });

        // Add Category
        $('#addCategoryForm').on('submit', function(e) {
            e.preventDefault();
            $.post('/api/categories', {
                name: $('#addCategoryName').val(),
                description: $('#addCategoryDescription').val()
            }).done(function() {
                alert('Category added successfully!');
                $('#categoryAddModal').modal('hide');
                table.ajax.reload();
            }).fail(function() {
                alert('Error adding category.');
            });
        });

        // Show Add Category Modal
        window.showAddCategoryForm = function() {
            // Clear existing input fields in the form
            $('#addCategoryName').val('');
            $('#addCategoryDescription').val('');

            // Show the Add Category Modal
            $('#categoryAddModal').modal('show');
        }

        // Show Edit Category Form
        window.showEditCategory = function(id) {
            $.get('/api/categories/' + id, function(category) {
                $('#editCategoryId').val(category.id);
                $('#editCategoryName').val(category.name);
                $('#editCategoryDescription').val(category.description);
                $('#categoryEditModal').modal('show');
            });
        };

        // Edit Category
        $('#editCategoryForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editCategoryId').val();
            $.ajax({
                url: '/api/categories/' + id,
                method: 'PUT',
                data: {
                    name: $('#editCategoryName').val(),
                    description: $('#editCategoryDescription').val()
                }
            }).done(function() {
                alert('Category updated successfully!');
                $('#categoryEditModal').modal('hide');
                table.ajax.reload();
            }).fail(function() {
                alert('Error updating category.');
            });
        });

        // Delete Category
        window.deleteCategory = function(id) {
            if (confirm('Are you sure you want to delete this category?')) {
                $.ajax({
                    url: '/api/categories/' + id,
                    method: 'DELETE'
                }).done(function() {
                    alert('Category deleted successfully!');
                    table.ajax.reload();
                }).fail(function() {
                    alert('Error deleting category.');
                });
            }
        };
    });
</script>
@endsection
