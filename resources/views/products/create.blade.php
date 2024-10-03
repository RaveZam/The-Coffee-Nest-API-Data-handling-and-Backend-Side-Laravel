<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <h1>Errors: </h1>
        @if($errors->any())
        <ul>
            @foreach ($errors as $error )
            <li>{{$error}}</li>
            @endforeach
        </ul>
        @endif
    </div>
    <div>
        <form action="{{route('product.store')}}" method="post">
            @csrf
            @method('post')
            <div>
                <label>Product Name</label>
                <input type="text" name="product_name" placeholder="Input Name">
            </div>
            <div>
                <label>Product Price</label>
                <input type="text" name="product_price" placeholder="Input Price">
            </div>
            <button type="submit">Add Item</button>
        </form>
</body>
</div>

</html>