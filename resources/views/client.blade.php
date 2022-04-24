@extends('layouts.app')

@include('product')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Productos a comprar</div>
                <div class="card-body">
                  <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
                    <div>
                      <table id="productsClient" class="table">
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
              <div class="card-header">Productos a comprar                      </div>
              <a type="button" href="{{ route('homecar') }}"  class="btn btn-secondary" title="Ver Productos" > <i class="bi bi-eye"></i></a>
              <div class="card-body">
                <table id="carrito" class="table">
                  <thead>
                    <tr>
                    
                      <th scope="col">Producto</th>                
                      <th scope="col">Precio</th>                    
                       <th scope="col">cantidad</th>
                   
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



@endsection
