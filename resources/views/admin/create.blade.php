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
            <div class="offset-md-6 col-md-2 offset-sm-6 col-sm-2 product-list">
                <a href="{{ route('product.index') }}">
                    <button type="button" class="btn btn-success">Go back</button>
                </a>
            </div>
        </div>

        <div class="col-md-6 col-xs-6 offset-md-3 offset-xs-3">

            @if(isset($product->id))
                <form method="POST" action="{{route('product.store', $product->id)}}">
            @else
                <form method="POST" action="{{route('product.store')}}">
            @endif
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('product.name') is-invalid @enderror" id="name"
                           name="product[name]" value="@if(isset($product->name)){{$product->name}}
                           @elseif(old('product.name')){{old('product.name')}}@endif">
                    @error('product.name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control @error('product.price') is-invalid @enderror" id="price"
                           name="product[price]"
                            @if(isset($product->price))
                                value="{{$product->price}}"
                            @elseif(old('product.price'))
                                value="{{old('product.price')}}"
                            @endif step="0.01">
                    @error('product.price')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="area">Area</label>
                    <input type="number" class="form-control @error('product.area') is-invalid @enderror" id="area"
                           name="product[area]"
                           @if(isset($product->area))
                                value="{{$product->area}}"
                           @elseif(old('product.area'))
                                value="{{old('product.area')}}"
                           @endif step="0.01">
                    @error('product.area')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="text" class="form-control @error('product.color') is-invalid @enderror" id="color"
                           name="product[color]" value="@if(isset($product->color)){{$product->color}}
                           @elseif(old('product.color')){{old('product.color')}}@endif">
                    @error('product.color')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <hr>

                @if(isset($product->id) && $product->properties)
                    @foreach($product->properties as $key => $property)
                        <div class="form-group input-group">

                            <input type="text" class="form-control @error('property.{{$key}}.name') is-invalid @enderror" id="{{$key}}"
                                   name="property[{{$key}}][name]" value="@if(isset($property->name)){{$property->name}}
                            @elseif(old('property.name')){{old('property.name')}}@endif">
                            @error('property.{{$key}}.name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror


                            <input type="text" class="form-control @error('property.{{$key}}.value') is-invalid @enderror" id="{{$key}}"
                                   name="property[{{$key}}][value]" value="@if(isset($property->value)){{$property->value}}
                                   @elseif(old('property.value')){{old('property.value')}}@endif">
                            @error('property.{{$key}}.value')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <input type="button" value="X" class="btn btn-danger delete-property">
                        </div>
                    @endforeach
                @endif

                @if(old('property'))
                    @foreach(old('property') as $keyOld => $property)

                        @if(isset($product->id) && $keyOld <= $product->properties->count())
                            <?php continue; ?>
                        @endif
                        <div class="form-group input-group">
                            <input type="text" class="form-control" id="{{$keyOld}}"
                                   name="property[{{$keyOld}}][name]" value="@if($property['name']){{$property['name']}}@endif">
                            @if($errors->has('property.' . $keyOld . '.name'))
                            <div class="alert alert-danger">{{ $errors->first('property.' . $keyOld . '.name') }}</div>
                            @endif


                            <input type="text" class="form-control" id="{{$keyOld}}"
                                   name="property[{{$keyOld}}][value]" value="@if($property['value']){{$property['value']}}@endif">
                            @if($errors->has('property.' . $keyOld . '.value'))
                                <div class="alert alert-danger">{{ $errors->first('property.' . $keyOld . '.value') }}</div>
                            @endif


                            <input type="button" value="X" class="btn btn-danger delete-property">
                        </div>
                    @endforeach
                @endif

                    <div class="new-properties"></div>
                    <input type="button" class="btn btn-success add-property" value="Add property">

                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

    </body>
</html>
