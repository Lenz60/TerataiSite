<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <title>asd</title>
    @routes
    @vite(['resources/js/app.js'])
    @vite(['resources/css/app.css'])
</head>
<body>
    <h1 class="text-xl text-green-400">
        Title:  TItle
    </h1>
    <div class="overflow-x-auto">
    <table class="table">
        <!-- head -->
        <thead>
        <tr>
            <th>Id</th>
            <th>code</th>
            <th>Desc</th>
            <th>Category</th>
            <th>Wood_type</th>
            <th>Width</th>
            <th>Length</th>
            <th>Height</th>
            <th>Stock</th>
            <th>Color</th>
            <th>Price</th>
        </tr>
        </thead>
        <tbody>
        <!-- row 1 -->
        @foreach ($furnitures as $furniture )
            <tr>
                <td>{{$furniture->id}}</td>
                <td>{{$furniture->code}}</td>
                <td>{{$furniture->description}}</td>
                <td>{{$furniture->category}}</td>
                <td>{{$furniture->wood_type}}</td>
                <td>{{$furniture->width}}</td>
                <td>{{$furniture->length}}</td>
                <td>{{$furniture->height}}</td>
                <td>{{$furniture->stock}}</td>
                <td>{{$furniture->color}}</td>
                <td>{{$furniture->price}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
