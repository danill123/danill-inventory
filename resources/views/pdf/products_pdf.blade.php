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
    <h1 style="text-align: center">List Products</h1>
    <table>
    <thead style="margin-top: 10px;" border="1">
        <tr>
            <th>Product Name</th>
            <th>Category</th>
            <th>Supplier</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->category ? $item->category->name : 'No Category' }}</td>
                <td>{{ $item->supplier ? $item->supplier->name : 'No Supplier' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->price }}</td>
            </tr>
        @endforeach
    </tbody>
    </table>
</body>
</html>