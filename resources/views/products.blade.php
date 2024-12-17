@extends('template')
@section('content')

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTable CSS -->
<link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
{{-- <div class="container my-4"> --}}

  <button class="btn btn-warning btn-sm mb-3" onclick="showAddProductForm()">Add Products</button>
  <!-- Create Button -->
  <button class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#createStockModal">
    Create New Stock Transaction
  </button>

  <a href="{{ url('/products_pdf') }}" class="btn btn-primary btn-sm mb-3">
    Products PDF
  </a>
  
  <div class="modal fade" id="createStockModal" tabindex="-1" aria-labelledby="createStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createStockModalLabel">Create New Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form -->
                <form id="createStockForm">
                    @csrf
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product</label>
                        <select class="form-control" name="product_id" id="product_id">
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="quantity" id="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-control" name="type" id="type" required>
                            <option value="add">Add</option>
                            <option value="subtract">Subtract</option>
                        </select>
                    </div>                    
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control" name="remarks" id="remarks"></textarea>
                    </div>
                    <button type="button" class="btn btn-primary" id="saveStockBtn">Save</button>
                </form>
            </div>
        </div>
    </div>
  </div>


  <!-- Table to display products -->
  <table id="products-table" class="table table-striped">
      <thead>
          <tr>
              <th>Product Name</th>
              <th>Category</th>
              <th>Supplier</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Actions</th>
          </tr>
      </thead>
      <tbody></tbody>
  </table>

   <!-- Modal for Product Details -->
   <div class="modal fade" id="productDetailsModal" tabindex="-1" aria-labelledby="productDetailsModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="productDetailsModalLabel">Product Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div id="product-details"></div>
              </div>
          </div>
      </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Update Product Modal -->
    <div class="modal fade" id="productUpdateModal" tabindex="-1" aria-labelledby="productUpdateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productUpdateModalLabel">Update Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateProductForm">
                        <input type="hidden" id="productId">

                        <div class="mb-3">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="productName" required>
                        </div>

                        <div class="mb-3">
                            <label for="productSku" class="form-label">SKU</label>
                            <input type="text" class="form-control" id="productSku" required>
                        </div>

                        <div class="mb-3">
                            <label for="categoryId" class="form-label">Category</label>
                            <select class="form-select" id="categoryId" required></select>
                        </div>

                        <div class="mb-3">
                            <label for="supplierId" class="form-label">Supplier</label>
                            <select class="form-select" id="supplierId" required></select>
                        </div>

                        <div class="mb-3">
                            <label for="productQuantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="productQuantity" required>
                        </div>

                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="productPrice" required>
                        </div>

                        <div class="mb-3">
                            <label for="productCost" class="form-label">Cost</label>
                            <input type="number" class="form-control" id="productCost" required>
                        </div>

                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="productDescription" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="productAddModal" tabindex="-1" aria-labelledby="productAddModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productAddModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm">
                    <div class="mb-3">
                        <label for="addProductName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="addProductName" required>
                    </div>

                    <div class="mb-3">
                        <label for="addProductSku" class="form-label">SKU</label>
                        <input type="text" class="form-control" id="addProductSku" required>
                    </div>

                    <div class="mb-3">
                        <label for="addCategoryId" class="form-label">Category</label>
                        <select class="form-select" id="addCategoryId" required></select>
                    </div>

                    <div class="mb-3">
                        <label for="addSupplierId" class="form-label">Supplier</label>
                        <select class="form-select" id="addSupplierId" required></select>
                    </div>

                    <div class="mb-3">
                        <label for="addProductQuantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="addProductQuantity" required>
                    </div>

                    <div class="mb-3">
                        <label for="addProductPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="addProductPrice" required>
                    </div>

                    <div class="mb-3">
                        <label for="addProductCost" class="form-label">Cost</label>
                        <input type="number" class="form-control" id="addProductCost" required>
                    </div>

                    <div class="mb-3">
                        <label for="addProductDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="addProductDescription" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal for Product Update -->
    <div class="modal fade" id="productUpdateModal" tabindex="-1" aria-labelledby="productUpdateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productUpdateModalLabel">Update Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateProductForm">
                        @csrf
                        <input type="hidden" id="productId">
                        <div class="mb-3">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="productName">
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="productPrice">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

{{-- </div> --}}

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<!-- Custom JS for API Integration -->

<script>
  $(document).ready(function() {
      // Initialize DataTable
      // Initialize DataTable
      var table = $('#products-table').DataTable({
          processing: true,
          serverSide: false,
          ajax: {
              url: '/api/products', // Backend API route to fetch data
              dataSrc: 'data'  // Ensure the data is accessed from the 'data' key
          },
          columns: [
              { data: 'name' },  // Product Name
              { data: 'category_name' },  // Category Name
              { data: 'supplier_name' },  // Supplier Name
              { data: 'quantity' },  // Supplier Name
              { data: 'price' },           // Product Price
              {
                  data: null,
                  render: function(data, type, row) {
                      return `
                          <button class="btn btn-info btn-sm" onclick="showDetails(${row.id})">Details</button>
                          <button class="btn btn-warning btn-sm" onclick="showUpdateForm(${row.id})">Edit</button>
                          <button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                              Delete
                          </button>
                          <a href="{{ url('/transaction_pdf/${row?.id}/${row?.name}') }}" class="btn btn-danger btn-sm mt-2 delete-btn">
                              Report Transaction
                          </a>
                      `;
                  }
              }
          ]
      });

      // "category_name": "assumenda",
      // "supplier_name": "Gerhold LLC",

      // Show Product Details
      window.showDetails = function(productId) {
          $.get('/api/products/' + productId, function(data) {
              $('#product-details').html(`
                  <strong>Name:</strong> ${data.name} <br>
                  <strong>SKU:</strong> ${data?.sku} <br>
                  <strong>Quantity:</strong> ${data?.quantity} <br>
                  <strong>Category:</strong> ${data?.category?.name} <br>
                  <strong>Supplier:</strong> ${data?.supplier?.name} <br>
                  <strong>Supplier Contact Person:</strong> ${data?.supplier?.contact_person} <br>
                  <strong>Supplier Contact Phone:</strong> ${data?.supplier?.phone} <br>
                  <strong>Supplier Address:</strong> ${data?.supplier?.address} <br>
                  <strong>Price:</strong> $${data.price} <br>
                  <strong>Description:</strong> ${data.description}
              `);
              $('#productDetailsModal').modal('show');
          });
      }

      window.showUpdateForm = function(productId) {
        $.get('/api/products/' + productId, function(data) {
            // Populate the form fields with existing product data
            $('#productId').val(data.id);
            $('#productName').val(data.name);
            $('#productSku').val(data.sku);
            $('#productQuantity').val(data.quantity);
            $('#productPrice').val(data.price);
            $('#productCost').val(data.cost);
            $('#productDescription').val(data.description);

            // Populate Category Dropdown
            $.get('/api/categories', function(categories) {
                $('#categoryId').empty();  // Clear existing options
                categories.forEach(function(category) {
                    // Create an option for each category
                    var selected = category.id == data.category_id ? 'selected' : '';  // Mark selected category
                    $('#categoryId').append(`<option value="${category.id}" ${selected}>${category.name}</option>`);
                });
            });

            // Populate Supplier Dropdown
            $.get('/api/suppliers', function(suppliers) {
                $('#supplierId').empty();  // Clear existing options
                suppliers.forEach(function(supplier) {
                    var selected = supplier.id == data.supplier_id ? 'selected' : '';  // Mark selected supplier
                    $('#supplierId').append(`<option value="${supplier.id}" ${selected}>${supplier.name}</option>`);
                });
            });

            // Show the Update Modal
            $('#productUpdateModal').modal('show');
        });
    }

    // Update Product on Submit
    $('#updateProductForm').on('submit', function(e) {
        e.preventDefault();

        var productId = $('#productId').val();
        var formData = {
            name: $('#productName').val(),
            sku: $('#productSku').val(),
            category_id: $('#categoryId').val(),
            supplier_id: $('#supplierId').val(),
            quantity: $('#productQuantity').val(),
            price: $('#productPrice').val(),
            cost: $('#productCost').val(),
            description: $('#productDescription').val(),
        };

        $.ajax({
            url: '/api/products/' + productId,
            method: 'PUT',
            data: formData,
            success: function(response) {
                alert('Product updated successfully!');
                // $('#products-table').DataTable().ajax.reload();
                // table.ajax.reload();
                location.reload()
                $('#productUpdateModal').modal('hide');
                // Refresh the DataTable (or reload the page)
            },
            error: function(err) {
                console.log(err);
                alert('Error updating product');
            }
        });
    });

    // Show Add Product Modal
    window.showAddProductForm = function() {
        // Fetch Categories and Populate Category Dropdown
        $.get('/api/categories', function(categories) {
            $('#addCategoryId').empty(); // Clear existing options
            categories.forEach(function(category) {
                $('#addCategoryId').append(`<option value="${category.id}">${category.name}</option>`);
            });
        });

        // Fetch Suppliers and Populate Supplier Dropdown
        $.get('/api/suppliers', function(suppliers) {
            $('#addSupplierId').empty(); // Clear existing options
            suppliers.forEach(function(supplier) {
                $('#addSupplierId').append(`<option value="${supplier.id}">${supplier.name}</option>`);
            });
        });

        // Show the Add Product Modal
        $('#productAddModal').modal('show');
    }

    // Add Product on Form Submit
    $('#addProductForm').on('submit', function(e) {
        e.preventDefault();

        var formData = {
            name: $('#addProductName').val(),
            sku: $('#addProductSku').val(),
            category_id: $('#addCategoryId').val(),
            supplier_id: $('#addSupplierId').val(),
            quantity: $('#addProductQuantity').val(),
            price: $('#addProductPrice').val(),
            cost: $('#addProductCost').val(),
            description: $('#addProductDescription').val(),
        };

        // Send POST request to add a new product
        $.ajax({
            url: '/api/products',
            method: 'POST',
            data: formData,
            success: function(response) {
                alert('Product added successfully!');
                // $('#products-table').DataTable().ajax.reload();
                // table.ajax.reload();
                $('#productAddModal').modal('hide');
                location.reload()
                // Refresh the DataTable (or reload the page)
            },
            error: function(err) {
                console.log(err);
                alert('Error adding product');
            }
        });
    });

    var productIdToDelete = null;

    // Handle Delete Button Click (Open Delete Confirmation Modal)
    $('#products-table').on('click', '.delete-btn', function() {
        productIdToDelete = $(this).data('id');
    });

    // Handle Confirm Delete Button Click
    $('#confirmDeleteBtn').on('click', function() {
        if (productIdToDelete !== null) {
            // Send AJAX request to delete the product
            $.ajax({
                url: '/api/products/' + productIdToDelete,
                method: 'DELETE',
                success: function(response) {
                    // Close the modal
                    $('#confirmDeleteModal').modal('hide');

                    // Manually remove the modal backdrop (this is important for Bootstrap modal backdrop issue)
                    // $('#products-table').DataTable().ajax.reload();
                    // table.ajax.reload();
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    location.reload()

                    // Reload the DataTable to reflect the changes
                    alert('Product deleted successfully!');
                },
                error: function(err) {
                    alert('Error deleting product');
                }
            });
        }
    });
  });
</script>



<!-- JavaScript for AJAX -->
<script>
    $(document).ready(function() {
    $('#saveStockBtn').click(function(e) {
        e.preventDefault();

        let formData = {
            product_id: $('#product_id').val(),
            quantity: $('#quantity').val(),
            type: $('#type').val(),
            remarks: $('#remarks').val(),
            _token: "{{ csrf_token() }}"
        };

        $.ajax({
            url: "{{ route('stocks.store') }}", // Route to store data
            method: "POST",
            data: formData,
            success: function(response) {
                // Do nothing on success
                $('#createStockModal').modal('hide');

                // Manually remove the modal backdrop (this is important for Bootstrap modal backdrop issue)
                $('#products-table').DataTable().ajax.reload();
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            },
            error: function(xhr) {
                console.log('Error occurred');
            }
        });
    });
});
</script>
@endsection