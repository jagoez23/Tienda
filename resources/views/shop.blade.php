@extends('layouts.frontend')

@section('content')
    <div class="container" style="margin-top: 80px">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-7">
                        <h4>Productos</h4>
                    </div>
                </div>
                <hr>
                <div class="container">
                    <div class="col-8">
                           <div class="input-group">
                               <input type="text" class="form-control" id="texto" placeholder=" Ingrese nombre a buscar">
                           </div>
                           <br>
                           <div id="resultados"></div>
                   </div>
                </div>
                  <br>  
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-lg-3">
                            <div class="card" style="margin-bottom: 20px; height: auto;">
                                <img src="/img/tienda/{{$product->id}}/{{$product->image}}"
                                     class="card-img-top mx-auto"
                                     style="height: 150px; width: 150px;display: block;"
                                     alt="{{ $product->image_path }}">
                                <div class="card-body text-center">
                                    <p>{{ $product-> name}}</p>
                                    <p>{{$product->description}}</p>
                                    <p>${{$product->price}}</p>
                                    <form action="{{route('cart.store')}}"method="POST">
                                        {{csrf_field()}}    
                                        <input type="hidden" value="{{ $product->name }}" id="description" name="name">
                                        <input type="hidden" value="{{ $product->description }}" id="description" name="description">
                                        <input type="hidden" value="{{ $product->price }}" id="price" name="price">
                                        <div class="card-footer" style="background-color: white;">
                                              <div class="row">
                                                <button class="btn btn-secondary btn-sm" class="tooltip-test" title="add to cart">
                                                    <i class="fa fa-shopping-cart"></i> Agregar al carrito
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection