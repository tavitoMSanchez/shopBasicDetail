<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
 
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<style>


</style>
</head>

<body class="loading"
    data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @guest
                <a class="navbar-brand" href="{{ url('/') }}">
                   'Facturacion'
                </a>
               
                @else
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                          <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('homecar') }}">Detalle de Compra</a>
                          </li>
                        @if($user->is_admin == true)
                        <li class="nav-item">
                          <a class="nav-link" href="{{ route('invoiceadmin.index') }}">Administracion</a>
                        </li>
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" /> 
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('clientindex') }}">Compras</a>
                        </li>
                      
                    </ul>
                 @endguest
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                           
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                      Cerrar Sesion
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
 
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap JavaScript -->
   
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script >
 

    $("#saveShopButton").on('click', function(e){
         e.preventDefault();
         var formInv = $("#form").serialize();
        
            $.ajax({
                type: "POST",
                url: '{{ route('carproduct.store') }}',
                data: formInv,
                success:function(data){
                    if(data){
                    let valor = parseFloat(data.total.total_sales).toFixed(2);                   
                    document.getElementById("totals").value = '';
                    console.log(valor);
                        Swal.fire(
                             'Bien!',
                             data.msg + '<br/>'+'',
                             'success' )  
                       
                         document.getElementById("form").reset();  
                         $('#totals').val(valor);
                         $('#car').DataTable().ajax.reload();
                         $('#carrito').DataTable().ajax.reload();
                    }
                    else {
                       console.log(data);
                    }
                }
           
            })
          
        });
     
    function addproductcar(product_id)
    {  
             $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('#token').val()
                } });              
            $.ajax({
                type: "POST",
                url: '{{ route('carproduct.store') }}',
                data: {'product_id' :   product_id},
                 dataType: 'json',
                success:function(data){
                    if(data){
                    let valor = parseFloat(data.total.total_sales).toFixed(2);                   
                    document.getElementById("totals").value = '';
                    console.log(valor);
                        Swal.fire(
                             'Bien!',
                             data.msg + '<br/>'+'',
                             'success' )  
                       
                         
                         $('#totals').val(valor);
                         $('#car').DataTable().ajax.reload();
                         $('#carrito').DataTable().ajax.reload();
                    }
                    else {
                       console.log(data);
                    }
                }
           
            })
    }
    function deletecarproduct(id)
    {
            console.log("entro");        
            $.ajax({
                type: "GET",
                url: '{{ route('deletecarproduct') }}',
                data: {'id' :   id},
                 dataType: 'json',            
                success:function(data){
                    if(data){
                        Swal.fire(
                             'Bien!',
                             data.msg + '<br/>'+'',
                             'success'
                         )  
                         $('#car').DataTable().ajax.reload();
                         $('#carrito').DataTable().ajax.reload();
                    }
                    else {
                       console.log(data);
                    }
                }
            })
     }
    function buyshop()
    {                
            $.ajax({
                type: "GET",
                url: '{{ route('buyshop') }}',
                         
                success:function(data){
                    if(data){
                        Swal.fire(
                             'Bien!',
                             data.msg + '<br/>'+'',
                             'success'
                         )  
                      //   document.getElementById("form").reset();  
                         $('#totals').val('');
                         $('#car').DataTable().ajax.reload();
                         $('#carrito').DataTable().ajax.reload();
                    }
                    else {
                       console.log(data);
                    }
                }
            })
     }

    function deleteproduct(id)
    {
      Swal.fire({
          title: 'seguro desea eliminar?',
          text: "No se podra revertir!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Cancelar!',
          confirmButtonText: 'Si, Eliminar!'
        }).then((result) => {
          if (result.isConfirmed) {

            $.ajax({
                type: "GET",
                url: '{{ route('deleteproduct') }}',
                data: {'id' :   id},
                 dataType: 'json',            
                success:function(data){
                    if(data){
                        Swal.fire(
                             'Eliminado!',
                             data.msg + '<br/>'+'',
                             'success'
                         )  
                        // document.getElementById("form").reset();  
                         $('#products').DataTable().ajax.reload();
                         $('#productsClient').DataTable().ajax.reload();
                    }
                    else {
                       console.log(data);
                    }
                }
            })           
          }
        })
      
       
    }


    $('#exampleModal').on('hidden.bs.modal', function(e) {
    $(this)
      .find("input,textarea,select")
      .val('')
      // .end()
      // .find("input[type=checkbox], input[type=radio]")
      // .prop("checked", "")
      .end();
      })


    function editProduct(id)
    {
            console.log("entro");        
            $.ajax({
                type: "GET",
                url: '{{ route('editProduct') }}',
                data: {'id' :   id},
                 dataType: 'json',            
                success:function(data){
                    if(data){
                      console.log(data);
                      $('#name').val(data.product.name);
                      $('#description').val(data.product.description);
                      $('#price').val(data.product.price);
                      $('#levy').val(data.product.levy);
                      $('#id').val(data.product.id);
                      $('#exampleModal').modal('show');

                    }
                    else {
                       console.log(data);
                    }
                }
            })
    }
    $("#addProductButton").on('click', function(e)
    {
      let token = $('#token').val();
      var form = $("#formProduct").serializeArray(); 
          
      form.push({name:'_token', value:token});  
      let id = $('#id').val();
      if(id == '')
      {
        console.log("entro if");
        e.preventDefault()
            var formInv = $("#formProduct").serialize(); 
           
             console.log(form);     
                $.ajax({
                    type: "POST",
                    url: '{{ route('product.store') }}',
                    data: $.param(form),
                    success:function(data){
                        if(data){
                            console.log(data);
                            Swal.fire(
                                'Bien!',
                                data.msg + '<br/>'+'',
                                'success'
                            )  
                            document.getElementById("formProduct").reset();  
                            $('#products').DataTable().ajax.reload();
                            $('#exampleModal').modal('hide');

                        }
                        else {
                        console.log(data);
                        }
                    }
                })
      }
      else{
        e.preventDefault()
            var formInv = $("#formProduct").serialize();         
                $.ajax({
                    type: "POST",
                    url: '{{ route('updateproduct') }}',
                    data: $.param(form),
                    success:function(data){
                        if(data){
                            console.log(data);
                            Swal.fire(
                                'Bien!',
                                data.msg + '<br/>'+'',
                                'success'
                            )  
                            document.getElementById("formProduct").reset();  
                            $('#products').DataTable().ajax.reload();
                            $('#exampleModal').modal('hide');

                        }
                        else {
                        console.log(data);
                        }
                    }
                })
      }
           
    });

    function invoceShop(id)
    {
            console.log("entro");        
            $.ajax({
                type: "GET",
                url: '{{ route('invoiceShop') }}',
                data: {'id' :   id},
                 dataType: 'json',            
                success:function(data){
                    if(data){
                        Swal.fire(
                             'Bien!',
                             data.msg + '<br/>'+'',
                             'success'
                         )                           
                         $('#invoiceModal').modal('hide');
                         $('#clients').DataTable().ajax.reload();
                         $('#invoice').DataTable().ajax.reload();
                      //   $('#shop').DataTable().ajax.reload();
                    }
                    else {
                       console.log(data);
                    }
                }
            })
    }

    function invoiceShops()
    {
      let id  =  document.getElementById("idClient").value;
        console.log(id);
            console.log("entro");        
            $.ajax({
                type: "GET",
                url: '{{ route('invoiceShops') }}',
                data: {'id' :   id},
                 dataType: 'json',            
                success:function(data){
                    if(data){
                        Swal.fire(
                             'Bien!',
                             data.msg + '<br/>'+'',
                             'success'
                         )                           
                         $('#invoiceModal').modal('hide');
                         $('#clients').DataTable().ajax.reload();
                         $('#invoice').DataTable().ajax.reload();
                    }
                    else {
                       console.log(data);
                    }
                }
            })
    }
    
    function emitShop(id)
    {  
            $.ajax({
                type: "GET",
                url: '{{ route('tableInvoiceClient') }}',
                data: {'id' :   id},
                         
                success:function(data){
                    if(data){
                        console.log(data.data);
                        $('#tableInvoiceClient').DataTable().destroy();                       
                        invoiceClientShop(data.data);
                        let array = data.data;                 
                        $('#invoiceDataModal').modal('show');                     
                    let sumall = array.map(item => parseFloat(item.total)).reduce((prev, curr) => prev + curr, 0);
                    let price = array.map(item => parseFloat(item.price)).reduce((prev, curr) => prev + curr, 0);
                    let levy = array.map(item => parseFloat(item.levy)).reduce((prev, curr) => prev + curr, 0);
                    $('#totalShop').val(sumall.toFixed(2));
                    $('#totalLevy').val(levy.toFixed(2));
                    $('#totalPrice').val(price.toFixed(2));         
                         
                                    
                  }
                    else {
                       console.log(data);
                    }
                }
            })
    }
    function ShowInvoiceClient(id)
    {  
            $.ajax({
                type: "GET",
                url: '{{ route('tableShowInvoiceClient') }}',
                data: {'id' :   id},
                         
                success:function(data){
                    if(data){
                        console.log(data.data);
                        $('#tableShowInvoiceClient').DataTable().destroy();                       
                        tableShowInvoiceClient(data.data);
                        let array = data.data;
                        console.log(array);                  
                        $('#invoiceShowModal').modal('show');    
                 
                    let sumall = array.map(item => parseFloat(item.total)).reduce((prev, curr) => prev + curr, 0);
                    let price = array.map(item => parseFloat(item.price)).reduce((prev, curr) => prev + curr, 0);
                    let levy = array.map(item => parseFloat(item.levy)).reduce((prev, curr) => prev + curr, 0);
                    $('#totalShop').val(sumall.toFixed(2));
                    $('#totalLevy').val(levy.toFixed(2));
                    $('#totalPrice').val(price.toFixed(2));
                  //  $('#username').val(array.username);
                //$('#invoice').val(array.invoiceid);
                         
                                    
                            }
                    else {
                       console.log(data);
                    }
                }
            })
    }

    

    function dataClient(id)
    {
        
            $.ajax({
                type: "GET",
                url: '{{ route('dataClient') }}',
                data: {'id' :   id},
                 dataType: 'json',            
                success:function(response){
                   console.log(response);
                   document.getElementById("nameClient").value = ('Nombre:'+' '+ response.data.name +'          '+ 'correo:'+' '+ response.data.email);
                   document.getElementById("idClient").value = (response.data.id);
                   console.log(response.data.id);
                }
            })
            $('#invoiceModal').modal('show');     
    }

    //funcion para abrir el modal del cliente con sus comprar para que se facturen
    function clientInvoice(id)
    {     
            console.log("entro");        
            $.ajax({
             //   serverSide: true,
                type: "GET",
                url: '{{ route('shops') }}',
                data: {'id' :   id},
             
                //processing: true,            
                success:function(data){
                    if(data){
                        let json = JSON.stringify(data.data);                      
                       $('#shop').DataTable().destroy();                       
                         tableClientInvoice(data.data);
                        dataClient(id);
                         $('#clients').DataTable().ajax.reload();                          
                        $('#invoice').DataTable().ajax.reload();
                    }
                    else {
                       console.log(data);
                    }
                }
              
            })
            
    }
    function tableClientInvoice(datos)
    {
     
    $('#shop').DataTable({
    language: {
        "paginate": {
            "previous": "Anterior",
            "next" : "Siguiente"
        },
        "lengthMenu": "Mostrando registros",
        "zeroRecords": "Nada encontrado",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "Ningun registro",
        "infoFiltered": "(filtrado de _MAX_ registros no total)",
    },
    order: [[0, 'desc']],    
      
        "searching": false,
        "responsive": true,
        "autoWidth": false,
        // ajax: {
        //  url: id,
        //  data: {
        // "id": id
       "data": datos,
    
        "columns":[
            {data: 'id'},
            {data: 'status'},
            {data: 'created_at'},
            {data: 'cantidad'},                  
            {data:'action'},          
        ]

    });
    }


    function invoiceClientShop(datos)
    {
     
    $('#tableInvoiceClient').DataTable({
    language: {
        "paginate": {
            "previous": "Anterior",
            "next" : "Siguiente"
        },
        "lengthMenu": "Mostrando registros",
        "zeroRecords": "Nada encontrado",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "Ningun registro",
        "infoFiltered": "(filtrado de _MAX_ registros no total)",
    },
    order: [[0, 'desc']],  
        "paging": false,
            "lengthChange": false, 
         "info": false, 
         paging: false,
        "searching": false,
        "responsive": true,
        "autoWidth": false,
        // ajax: {
        //  url: id,
        //  data: {
        // "id": id
       "data": datos,
    
        "columns":[
            {data: 'idshop'},
            {data: 'idproduct'},
            {data: 'name'},
            {data: 'price'},
            {data: 'levy'},          
            {data: 'cantidad' },
         
        ]     
        

    });
    }

    function tableShowInvoiceClient(datos)
    {
     
    $('#tableShowInvoiceClient').DataTable({
    language: {
        "paginate": {
            "previous": "Anterior",
            "next" : "Siguiente"
        },
        "lengthMenu": "Mostrando registros",
        "zeroRecords": "Nada encontrado",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "Ningun registro",
        "infoFiltered": "(filtrado de _MAX_ registros no total)",
    },
    order: [[0, 'desc']],  
        "paging": false,
            "lengthChange": false, 
         "info": false, 
         paging: false,
        "searching": false,
        "responsive": true,
        "autoWidth": false,
     
       "data": datos,
    
        "columns":[
            {data: 'idshop'},
            {data: 'idproduct'},
            {data: 'name'},
            {data: 'price'},
            {data: 'levy'},          
            {data: 'cantidad' },
         
        ]     
        

    });
    }
    
    
         
  
   $(document).ready(function(){ 
    $('#clients').DataTable({
    language: {
        "paginate": {
            "previous": "Anterior",
            "next" : "Siguiente"
        },
        "lengthMenu": "Mostrando registros",
        "zeroRecords": "Nada encontrado",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "Ningun registro",
        "infoFiltered": "(filtrado de _MAX_ registros no total)",
    },
    order: [[0, 'desc']],    
        "processing": true,
        "serverSide": true,
        "searching": false,
        "responsive": true,
        "autoWidth": false,
        ajax: '{!! route('clients') !!}',
        "columns":[
            {data: 'id'},
            {data: 'name'},
            {data: 'email'},
            {data: 'status'},           
            {data:'action'},          
        ]

    });
    $('#shopClient').DataTable({
    language: {
        "paginate": {
            "previous": "Anterior",
            "next" : "Siguiente"
        },
        "lengthMenu": "Mostrando registros",
        "zeroRecords": "Nada encontrado",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "Ningun registro",
        "infoFiltered": "(filtrado de _MAX_ registros no total)",
    },
    order: [[0, 'desc']],    
        "processing": true,
        "serverSide": true,
        "searching": false,
        "responsive": true,
        "autoWidth": false,
        ajax: '{!! route('tableShopClient') !!}',
        "columns":[
            {data: 'id'},
            {data: 'status'},
            {data: 'created_at'},
            {data: 'cantidad'},
            {data: 'invoiceid'},
            {data:'action'},          
        ]

    });
   
    $('#invoice').DataTable({
    language: {
        "paginate": {
            "previous": "Anterior",
            "next" : "Siguiente"
        },
        "lengthMenu": "Mostrando registros",
        "zeroRecords": "Nada encontrado",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "Ningun registro",
        "infoFiltered": "(filtrado de _MAX_ registros no total)",
    },
    order: [[0, 'desc']],    
        "processing": true,
        "serverSide": true,
        "searching": false,
        "responsive": true,
        "autoWidth": false,
        ajax: '{!! route('invoices') !!}',
        "columns":[
            {data: 'id'},
            {data: 'status'},
            {data: 'created_at'},
            {data: 'cantidad'},
            {data: 'user_id'},
         
            // {data: 'levy'},
            {data:'action'},          
        ]

    });
  $('#car').DataTable({
    language: {
        "paginate": {
            "previous": "Anterior",
            "next" : "Siguiente"
        },
        "lengthMenu": "Mostrando registros",
        "zeroRecords": "Nada encontrado",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "Ningun registro",
        "infoFiltered": "(filtrado de _MAX_ registros no total)",
    },
    order: [[0, 'desc']],
    
        "processing": true,
        "serverSide": true,
        "searching": false,
        "responsive": true,
        "autoWidth": false,
        ajax: '{!! route('car') !!}',
        "columns":[           
            {data: 'name'},
            {data: 'description'},
            {data: 'price'},
            {data: 'levy'},
            {data:'action'},          
        ]

        });
  $('#productsClient').DataTable({
    language: {
        "paginate": {
            "previous": "Anterior",
            "next" : "Siguiente"
        },
        "lengthMenu": "Mostrando registros",
        "zeroRecords": "Nada encontrado",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "Ningun registro",
        "infoFiltered": "(filtrado de _MAX_ registros no total)",
    },
    order: [[0, 'desc']],
    
        "processing": true,
        "serverSide": true,
        "searching": false,
        "responsive": true,
        "autoWidth": false,
        ajax: '{!! route('tableProductClient') !!}',
        "columns":[
           
            {data: 'name'},
            {data: 'description'},
            {data: 'price'},
            {data: 'levy'},         
            {data:'action'},
          
        ]

        });
        $('#products').DataTable({
    language: {
        "paginate": {
            "previous": "Anterior",
            "next" : "Siguiente"
        },
        "lengthMenu": "Mostrando registros",
        "zeroRecords": "Nada encontrado",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "Ningun registro",
        "infoFiltered": "(filtrado de _MAX_ registros no total)",
    },
    order: [[0, 'desc']],
    
        "processing": true,
        "serverSide": true,
        "searching": false,
        "responsive": true,
        "autoWidth": false,
        ajax: '{!! route('products') !!}',
        "columns":[
           
            {data: 'name'},
            {data: 'description'},
            {data: 'price'},
            {data: 'levy'},         
            {data:'action'},
          
        ]

        });
  $('#carrito').DataTable({
    language: {
        "paginate": {
            "previous": "Anterior",
            "next" : "Siguiente"
        },
        "lengthMenu": "Mostrando registros",
        "zeroRecords": "Nada encontrado",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "Ningun registro",
        "infoFiltered": "(filtrado de _MAX_ registros no total)",
    },
    order: [[0, 'desc']],
    
        "processing": true,
        "serverSide": true,
        "searching": false,
        "responsive": true,
        "autoWidth": false,
        ajax: '{!! route('carrito') !!}',
        "columns":[
         
            {data: 'producto'},         
            {data: 'price'},           
            {data: 'cantidad'},
         
          
        ]

        });
       
    });

    </script>
</body>
</html>
