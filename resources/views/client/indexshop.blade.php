@extends('layouts.app')

@include('product')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Compras Facturadas</div>

                <div class="card-body">             
                   
                      <table id="shopClient" class="table">
                        <thead>
                          <tr>
                          
                            <th scope="col">IdCompra</th>
                            <th scope="col">Status</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Productos</th>
                            <th scope="col">IdFactura</th>
                            <th scope="col">accion</th>
                          </tr>
                        </thead>
                        
                      </table>
                    </div>
                </div>
            </div>
        </div>



     
</div>
{{--     modal --}}
<div class="modal fade" id="invoiceDataModal" tabindex="-1" aria-labelledby="invoiceDataModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" width="100%" autoWidth="true">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="invoiceDataModalLabel">Detalle de  Factura de la compra</h5>  
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
 
        <table id="tableInvoiceClient" class="table table-striped table-bordered">
            <thead>
              <tr>              
                <th scope="col">IdCompra</th>
                <th scope="col">IdProducto</th>
                <th scope="col">Producto</th>
                <th scope="col">Precio total</th>              
                <th scope="col">Precio impuesto</th>
                <th scope="col">Cantidad</th>
              </tr>
            </thead>            
          </table>
          <div class="row">   
            <div class="col-md-4 ms-auto">
              
             </div>         
            <div class="col-md-2 ms-auto">
               <label for="totalPrice"  class="col-form-label">Precio Total:</label>
              <input type="text" class="form-control" readonly name="totalPrice" step='0.01'  id="totalPrice">
            </div>
            <div class="col-md-2 ms-auto">
                <label for="totalLevy"  class="col-form-label">Impuesto Total:</label>
               <input type="text" class="form-control" readonly name="totalLevy" step='0.01'  id="totalLevy">
             </div>
             <div class="col-md-2 ms-auto">
                <label for="totalShop"   class="col-form-label">Precio Con Impuestos:</label>
               <input type="text" class="form-control" readonly name="totalShop" step='0.01'  id="totalShop">
             </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      
      </div>
    </div>
  </div>
</div>


@endsection
