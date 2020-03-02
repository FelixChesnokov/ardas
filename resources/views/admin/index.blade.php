<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Ardas admin panel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- JS -->
        <script src="{{ asset('js/app.js')}}"></script>
        <script src="{{ asset('js/main.js')}}"></script>

    </head>
    <body>

        <div class="row col-md-12 header">
            <p class="offset-md-2 col-md-2 offset-sm-2 col-sm-2 product-list">List of products</p>

            <div class="col-md-3 col-sm-3 form-group form-inline product-list">
                <label for="search">Search</label>
                <input id="search" type="text" class="form-control search" data-url="{{url('/product/search')}}"
                    @if(isset($searchValue))value="{{$searchValue}}"@endif>
                <input id="search-btn" type="button" class="form-control btn btn-success search"
                       value="Find" data-url="{{url('/product/search')}}">
            </div>

            <div class="offset-md-2 col-md-2 offset-sm-2 col-sm-2 product-list">
                <a href="{{ route('product.create') }}">
                    <button type="button" class="btn btn-success">Create product</button>
                </a>
            </div>
        </div>

        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th class="th-width" scope="col">Name</th>
                <th class="th-width" scope="col">Price</th>
                <th class="th-width" scope="col">Created</th>
                <th class="th-width" scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{$product->name}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->created_at}}</td>
                    <td>
                        <a href="{{ route('product.edit', $product->id) }}" class="edit-link">
                            <button type="button" class="btn btn-primary">Edit product</button>
                        </a>
                        <button type="button" class="btn btn-danger delete-btn-modal" data-toggle="modal"
                                data-target="#exampleModalCenter" data-product_id="{{$product->id}}">
                            Delete product
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Do you really want to delete this product?
                    </div>
                    <div class="modal-footer">
                        <a id="delete-link" href="{{ url('/product/delete') }}">
                            <button type="button" class="btn btn-danger">Delete product</button>
                        </a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
