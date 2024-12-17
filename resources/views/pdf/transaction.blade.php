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
    <h1 style="text-align: center">List Transaction {{ $nama_product }}</h1>
    
    <div style="display: flex; justify-content: center;">
        <table>
        <thead style="margin-top: 10px;" border="1">
            <tr>
                <th>quantity</th>
                <th>type</th>
                <th>remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction as $item)
                <tr>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->remarks }}</td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
</body>
</html>