<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table, th, td {
  border: 1px solid black;
}
    </style>
</head>
<body style="padding: 10px;">
    <h1 style="text-align: center">List Categories</h1>
    
    <div style="display: flex; justify-content: center;">
        <table>
        <thead style="margin-top: 10px;" border="1">
            <tr>
                <th>Name</th>
                <th>Contact Person</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($supplier as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->contact_person }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->address }}</td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
</body>
</html>