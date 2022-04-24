<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use App\Models\Invoice;
use App\Models\Car;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Database\Eloquent\Builder;


class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
       
    }

    public function index()
    {
        
        $id_user = auth()->id(); 
        $user = User::where('id',$id_user)->first();
       return view('admin.index',compact('user'));
    }
// Tabla de las compras pendientes a facturar por cliente de la vista facturas pendientes(modal)
    public function tableInvoiceShops(Request $request)
    {
       // $id_user = 1;
        $request = Product::select("shops.id", DB::raw('(CASE WHEN shops.status = 0 THEN "PENDIENTE"  ELSE "FACTURADO" END) AS status') ,'shops.created_at',DB::raw('COUNT(*) as cantidad'))
        ->leftJoin('cars','products.id','=','cars.product_id')
        ->leftJoin('shops','cars.shop_id','=','shops.id')
        ->where('cars.user_id',$request->id)
        ->where('cars.shop_id','<>',0)
        ->where('shops.status',0)
        ->groupBy('cars.shop_id');    
        
        return Datatables::of($request)->addColumn('action', function($request){
            return '<button onClick="invoceShop('. $request->id .')"   class="btn-icon btn-icon-only btn btn-pill btn-sm btn-outline-primary"
             ><i class="bi bi-send-fill"></i></button>';})->make(true);
    }

  // tabla de las facturas emitidas
    public function tableInvoice()
    {
        $id_user = 1;
        $request = Product::select("shops.invoice_id as id", DB::raw('(CASE WHEN shops.status = 0 THEN "PENDIENTE"  ELSE "FACTURADO" END) AS status') ,"shops.created_at",DB::raw('COUNT(*) as cantidad') ,"cars.user_id as user_id","shops.invoice_id")
        ->leftJoin('cars','products.id','=','cars.product_id')
        ->leftJoin('shops','cars.shop_id','=','shops.id')
      //  ->where('cars.user_id',$id_user)
        ->where('cars.shop_id','<>',0)
        ->where('shops.status',1)
        //->distinct('shops.invoice_id')
        ->groupBy('shops.invoice_id');    
        
        return Datatables::of($request)->addColumn('action', function($request){
            return '<button onClick="ShowInvoiceClient('. $request->invoice_id .')"  class="btn-icon btn-icon-only btn btn-pill btn-sm btn-outline-primary"
             ><i class="bi bi-eye"></i></button>';})->make(true);
    }

    //tabla de los clientes con compras pendientes por facturar.(vista facturas pendientes)
    public function tableClient()
    {
     
        $request = Product::select("users.id","users.name","users.email", DB::raw('(CASE WHEN shops.status = 0 THEN "PENDIENTE"  ELSE "FACTURADO" END) AS status'))
        ->leftJoin('cars','products.id','=','cars.product_id')
        ->leftJoin('shops','cars.shop_id','=','shops.id')
        ->leftJoin('users','cars.user_id','=','users.id')
        ->where('shops.invoice_id','=',0)
        ->where('shops.status',0)
        ->groupBy('cars.user_id');    
        
        return Datatables::of($request)->addColumn('action', function($request){
            return '<button onClick="clientInvoice('. $request->id .')"  class="btn-icon btn-icon-only btn btn-pill btn-sm btn-outline-primary tab-content-4"
             ><i class="bi bi-book"></i></button>';})->make(true);
    }
  
    
    public function invoiceShop(Request $request)
    {
        $id_user = auth()->id();
        $invoice = Invoice::create( [
            'user_id' => $id_user,
        ]);
        DB::table('shops')
            ->where('id',$request->id)
            ->where('shops.status',0)
            ->update(['invoice_id' => $invoice['id'],
                        'status' => 1  ]);

    
        $res = array('msg' => 'Se ha factura la compra!');
        return response()->json($res);
    }

    public function invoiceShops(Request $request)
    {
       // dd($request->id);
        $id_user = auth()->id();
        $shops = Product::select("shops.id", DB::raw('(CASE WHEN shops.status = 0 THEN "PENDIENTE"  ELSE "FACTURADO" END) AS status') ,
        "shops.created_at",DB::raw('COUNT(*) as cantidad') ,"cars.user_id as user_id")
        ->leftJoin('cars','products.id','=','cars.product_id')
        ->leftJoin('shops','cars.shop_id','=','shops.id')
        ->where('cars.user_id',$request->id)
        ->where('cars.shop_id','<>',0)
        ->where('shops.status',0)
        ->groupBy('cars.shop_id')->get();    
       
       //dd($shops);
        $invoice = Invoice::create( [
            'user_id' => $id_user,
        ]);

        foreach($shops as $shop){
            DB::table('shops')
            ->where('id',$shop->id)
            ->where('shops.status',0)
            ->update(['invoice_id' => $invoice['id'],
                        'status' => 1  ]);
        } 

    
        $res = array('msg' => 'Se han factura las compras!');
        return response()->json($res);
    }
    //obtener datos del cliente para el modal para facturar las compras o compra de la vista fact pendientes
    public function dataClient(Request $request)
    {
       
        $data = User::where('id',$request->id)->first();
        
        $res = array('msg' => 'Se han factura las compras!','data' => $data);
        return response()->json($res);
    }
   
}
