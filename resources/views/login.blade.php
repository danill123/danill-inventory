<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initialscale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS CDN -->
    {{-- docker run -d --name postgrest-db -e POSTGRES_USER=myuser -e POSTGRES_PASSWORD=mypassword -e POSTGRES_DB=mydatabase -p 5432:5432 postgres:latest --}}
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container mt-5">
        <form method="POST" action="{{ route('actionlogin') }}">
            @csrf
            @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{-- <strong>Holy guacamole!</strong> You should check in on some of those fields below. --}}
                {{ Session::get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                {{-- <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p> --}}
            @endif
            <div style="display: flex; justify-content:center;">
            <div style="width: 300px;">
                <h1 class="text-center">Login Form</h1>
                <div class="form-group" style="margin-top: 100px;">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </div>
        </form>
    </div>
    <!-- Bootstrap JS & jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
</body> 
</html>