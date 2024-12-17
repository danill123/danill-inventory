<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
    <style>
      /* Sidebar Styling */
      .sidebar {
          height: 100vh; /* Full viewport height */
          color: white;
          padding: 15px;
          /* position: fixed;  Keep sidebar fixed */
          /* top: 0;
          left: 0; */
          width: 250px; /* Fixed width */
      }

      .sidebar a {
          color: black;
          text-decoration: none;
          display: block;
          padding: 10px;
          border-radius: 5px;
      }

      .sidebar a:hover {
          background-color: #495057;
          color: white;
      }

      .sidebar .nav-item .active {
          background-color: #495057;
          color: white;
      }

      /* Content Area */
      .content {
      }
  </style>
  </head>
  <body>
    {{-- <h1>Hello, world!</h1> --}}
    {{-- <div class="container-fluid">
    </div> --}}
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-2 sidebar">
            <h4 class="text-center" style="color: black;">Inventory</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                  <a href="{{ url('/products') }}" class="nav-link {{ Request::is('products') ? 'active' : '' }}">
                    Products
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('/categories') }}" class="nav-link {{ Request::is('categories') ? 'active' : '' }}">
                      Category
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('/supplier') }}" class="nav-link {{ Request::is('supplier') ? 'active' : '' }}">
                    Supplier
                  </a>
                </li>
            </ul>
        </div>

        <!-- Content Area -->
        <div class="col-lg-8 content mt-3">
          @yield('content')
        </div>
    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>