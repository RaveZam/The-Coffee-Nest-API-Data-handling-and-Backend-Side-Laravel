<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <h1>Input Sales History: (Mini Pos System)</h1>
        <div>
            @if (session()->has('success'))
            <div>
                {{session('success')}}
            </div>
            @endif
        </div>
        <form action="{{route('sales.addTransaction')}}" method="post">
            @csrf
            @method('post')
            <div>
                <label for="product_id">Product Id</label>
                <input type="text" name="product_id" placeholder="Product ID">
            </div>
            <div>
                <label for="quantity">Quantity</label>
                <input type="text" name="quantity" placeholder="Quantity">
            </div>
            <div>
                <label for="product_id">Sale Date</label>
                <input type="date" id="sale_date" name="sale_date">
            </div>
            <button type="submit">Store</button>
        </form>
    </div>
    <div>
        <table border="1">
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
            </tr>
            @foreach ($products as $product )
            <tr>
                <td>{{$product->id}}</td>
                <td>{{$product->product_name}}</td>
                <td>{{$product->product_price}}</td>
                <td>{{$product->category}}</td>
            </tr>
            @endforeach
        </table>
    </div>
</body>

</html>