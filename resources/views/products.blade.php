@extends('template')
@section('content')

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTable CSS -->
<link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<div class="container my-4">

  <!-- Table to display products -->
  <table id="products-table" class="table table-striped">
      <thead>
          <tr>
              <th>Product Name</th>
              <th>Category</th>
              <th>Supplier</th>
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

</div>

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
          serverSide: true,
          ajax: {
              url: '/api/products', // Backend API route to fetch data
              dataSrc: 'data'  // Ensure the data is accessed from the 'data' key
          },
          columns: [
              { data: 'name' },  // Product Name
              { data: 'category_name' },  // Category Name
              { data: 'supplier_name' },  // Supplier Name
              { data: 'price' },           // Product Price
              {
                  data: null,
                  render: function(data, type, row) {
                      return `
                          <button class="btn btn-info btn-sm" onclick="showDetails(${row.id})">Details</button>
                          <button class="btn btn-warning btn-sm" onclick="showUpdateForm(${row.id})">Edit</button>
                      `;
                  }
              }
          ]
      });

      // Show Product Details
      window.showDetails = function(productId) {
          $.get('/api/products/' + productId, function(data) {
              $('#product-details').html(`
                  <strong>Name:</strong> ${data.name} <br>
                  <strong>Category:</strong> ${data.category_name} <br>
                  <strong>Supplier:</strong> ${data.supplier_name} <br>
                  <strong>Price:</strong> $${data.price} <br>
                  <strong>Description:</strong> ${data.description}
              `);
              $('#productDetailsModal').modal('show');
          });
      }

      // Show Product Update Form
      window.showUpdateForm = function(productId) {
          $.get('/api/products/' + productId, function(data) {
              $('#productId').val(data.id);
              $('#productName').val(data.name);
              $('#productPrice').val(data.price);
              $('#productUpdateModal').modal('show');
          });
      }

      // Handle Product Update Form Submit
      $('#updateProductForm').on('submit', function(e) {
          e.preventDefault();

          var productId = $('#productId').val();
          var productData = {
              name: $('#productName').val(),
              price: $('#productPrice').val(),
              _token: $('input[name="_token"]').val(),
          };

          $.ajax({
              url: '/api/products/' + productId,
              method: 'PUT',
              data: productData,
              success: function(response) {
                  $('#productUpdateModal').modal('hide');
                  table.ajax.reload(); // Reload DataTable
                  alert('Product updated successfully!');
              }
          });
      });
  });
</script>