@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <form id="form" class="row g-3">
                        <div class="col-auto">
                          <label >Productos</label>  
                          <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />                       
                        </div>
                        <div class="col-auto">
                          <label for="product_id" class="visually-hidden">Producto</label>
                          <select class="form-select" name="product_id" aria-label="Default select example">
                            <option selected>Selecciona el producto</option>
                           @foreach ($products as $product )
                              <option value="{{$product->id}}">{{$product->name}} - Precio: {{ $product->price }} + Impuesto: {{ $product->levy  }}</option>
                           @endforeach
                          </select>
                        </div>
                        <div class="col-auto">                        
                          <button id="saveShopButton" class="btn btn-primary mb-3">Agregar producto</button>
                          
                        </div>
                      </form>                   
                    <div>
                      <table id="car" class="table">
                        <thead>
                          <tr>
                          
                            <th scope="col">producto</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">precio</th>
                            <th scope="col">impuesto</th>
                            <th scope="col">accion</th>
                          </tr>
                        </thead>
                        
                      </table>
                    </div>                    
                </div>
            </div>
        </div>



        <div class="col-md-4">
          <div class="card">
              <div class="card-header">Productos a comprar                      

              <div class="card-body">
                <table id="carrito" class="table">
                  <thead>
                    <tr>
                    
                      <th scope="col">Producto</th>                
                      <th scope="col">Precio</th>
                    
                       <th scope="col">cantidad</th>
                      {{-- <th scope="col">accion</th> --}}
                    </tr>
                  </thead>
                  
                </table>
                <div class="row"> 
                  
                  <div class="col-md-6 ms-auto">
                    <button onclick="buyshop()" type="button" id="" class="btn btn-primary">Comprar</button>
                </div>
                    <div class="col-md-6 ms-auto">
  
                     </div>
               
                    <label for="totals" class="col-form-label">Precio Total:</label>
                   <input type="text" class="form-control totals" id="totals" readonly  step='0.01'  name="totals" value="{{ $total->total_sales }}" >
                  </div>
                </div>
                
                
          
               </div>

          </div>
        </div>
</div>
{{--     modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formProduct">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />    
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Nombre:</label>
            <input type="text" class="form-control" name="name" id="recipient-name">
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Descripción:</label>
            <textarea class="form-control" id="message-text" name="description"></textarea>
          </div>
          <div class="row">            
            <div class="col-md-6 ms-auto">
               <label for="recipient-name" class="col-form-label">Precio:</label>
              <input type="text" class="form-control" name="price"  id="recipient-name">
            </div>
            <div class="col-md-6 ms-auto">
               <label for="recipient-name" class="col-form-label">Impuesto:</label>
              <input type="text" class="form-control" name="levy" id="recipient-name">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="addProductButton" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>


@endsection
