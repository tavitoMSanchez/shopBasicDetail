@extends('layouts.app')

{{-- @include('product') --}}
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">FACTURACIÓN</div>

                <div class="card-body">                 
                   
                    <div class="pcss3t pcss3t-effect-scale pcss3t-theme-1">
                        <input type="radio" name="pcss3t" checked value="false"  id="tab1" class="tab-content-first">
                        <label for="tab1"><i class="fa-solid fa-clock-rotate-left"></i>Productos</label>				
                        <input type="radio" name="pcss3t" id="tab2" value="true" class="tab-content-2">
                        <label for="tab2"><i class="fa-regular fa-circle-check" ></i>Facturas Pendientes</label>
                        <input type="radio" name="pcss3t" id="tab3" value="true"  class="tab-content-3">
                        <label for="tab3"><i class="fa-regular fa-circle-check" ></i> Facturas Completadas</label>				
                        <ul>
                            <li class="tab-content tab-content-first typography">
                                <div class="row">
                                    <div class="col">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                           Agregar Producto
                                         </button>
                                    </div>
                                
                                  </div>
                                
                                <table id="products" class="table">
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
                            </li>					
                            <li class="tab-content tab-content-2 typography">
                                <div class="row">
                                    <div class="col">
                                       
                                    </div>
                                
                                  </div>
                                  <table id="clients" class="table">
                                    <thead>
                                      <tr>                                      
                                        <th scope="col">IdCliente</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Correo</th>
                                        <th scope="col">status</th>                                    
                                        <th scope="col">accion</th>
                                      </tr>
                                    </thead>                        
                                  </table>   
                                {{-- <table id="shop" class="table">
                                    <thead>
                                      <tr>
                                      
                                        <th scope="col">Id</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Productos</th>                                      
                                        <th scope="col">accion</th>
                                      </tr>
                                    </thead>
                                    
                                  </table> --}}
                            </li>		
                            <li class="tab-content tab-content-3 typography">
                                <table id="invoice" class="table">
                                    <thead>
                                      <tr>
                                      
                                        <th scope="col">Id</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Productos</th>
                                        <th scope="col">user</th>
                                        <th scope="col">accion</th>
                                      </tr>
                                    </thead>
                                    
                                  </table>
                            </li>		
                         						
                        </ul>
                    </div>
                 
                </div>
            </div>
        </div>


</div>
{{--  Productos   modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formProduct">
          
          <input type="hidden" name="id"id="id" />       
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Nombre:</label>
            <input type="text" class="form-control" name="name" id="name">
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Descripción:</label>
            <textarea class="form-control" id="description" name="description"></textarea>
          </div>
          <div class="row">            
            <div class="col-md-6 ms-auto">
               <label for="recipient-name" class="col-form-label">Precio:</label>
              <input type="text" class="form-control" name="price"  id="price">
            </div>
            <div class="col-md-6 ms-auto">
               <label for="recipient-name" class="col-form-label">Impuesto:</label>
              <input type="text" class="form-control" name="levy" id="levy">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" id="addProductButton" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>

--  Facturar cliente   modal --}}
<div class="modal fade" id="invoiceModal"  tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" width="100%" autoWidth="true">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="invoiceModalLabel">Facturar cliente</h5>
        <input type="text" hidden readonly  name="idClient" id="idClient">
        <input type="text" readonly  class="form-control" name="nameClient" id="nameClient">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table id="shop" class="table table-striped table-bordered">
            <thead>
              <tr>              
                <th scope="col">IdCompra</th>
                <th scope="col">Status</th>
                <th scope="col">Fecha</th>
                <th scope="col">Productos</th>              
                <th scope="col">accion</th>
              </tr>
            </thead>            
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" onclick="invoiceShops()" id="invoiceshops" class="btn btn-primary"><li class="bi-send-fill" > Facturar Todo</li></button>
      </div>
    </div>
  </div>
</div>

{{--  Modal datos factura emitida --}}
<div class="modal fade" id="invoiceShowModal" tabindex="-1" aria-labelledby="invoiceShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" width="100%" autoWidth="true">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="invoiceShowModalLabel">Factura</h5>  
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          
   
          <table id="tableShowInvoiceClient" class="table table-striped table-bordered">
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
