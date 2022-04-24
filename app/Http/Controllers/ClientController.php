<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Car;
use App\Models\Shop;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Database\Eloquent\Builder;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
       
    }
    public function index()
    {

        $id_user = auth()->id(); 
        $user = User::where('id',$id_user)->first();    
       
        return view('client.indexshop',compact('user'));
    }
//tabla compras de un cliente
    public function tableShopClient()
    {
        $id_user = auth()->id();         
       
        $request = Product::select("shops.id", DB::raw('(CASE WHEN shops.status = 0 THEN "PENDIENTE" 
         ELSE "FACTURADO" END) AS status'),'shops.created_at',DB::raw('COUNT(*) as cantidad'),
         'invoices.id as invoiceid')
        ->leftJoin('cars','products.id','=','cars.product_id')
        ->leftJoin('shops','cars.shop_id','=','shops.id')
        ->leftJoin('invoices','shops.invoice_id','=','invoices.id')
        ->where('cars.user_id',$id_user)
       ->where('cars.shop_id','<>',0)
       // ->where('shops.status',0)
        ->groupBy('cars.shop_id');    
        
     
            return Datatables::of($request)->addColumn('action', function($request){
                return '<button onClick="emitShop('. $request->invoiceid .')"   class="btn-icon btn-icon-only   btn btn-pill btn-sm btn-outline-primary"
                 ><i class="bi bi-clipboard-data"></i></button>';})->make(true);
      
       
    }
    //tabla cliente de los productos que realizo en una compra
    public function tableInvoiceClient(Request $request)    
    {  
        
        $id_user = auth()->id();    
       
        $products = Shop::select("shops.id as idshop","products.id as idproduct","products.name",
        DB::raw('ROUND(SUM(products.price),2) as price'),DB::raw('ROUND(SUM(products.levy),2) as levy'),
        DB::raw('COUNT(cars.product_id) as cantidad'),'shops.invoice_id as invoiceid',
        DB::raw('ROUND(SUM(products.price + products.levy),2) as total'),'users.name as username')
        ->leftJoin('cars','shops.id','=','cars.shop_id')
        ->join('users','shops.user_id','=','users.id')
        ->leftJoin('products','cars.product_id','=','products.id')
        ->where('shops.invoice_id','=',$request->id)
        ->where('cars.user_id',$id_user)
       
        ->where('cars.shop_id','<>',0)
        ->groupBy('cars.product_id');    
        return Datatables::of($products)->make(true);
    }
//tabla desglozado de la factura emitida
    public function tableShowInvoiceClient(Request $request)    
    {
        
        
        $id_user = auth()->id();    
       
        $products = Shop::select("shops.id as idshop","products.id as idproduct","products.name",
        DB::raw('ROUND(SUM(products.price),2) as price'),DB::raw('ROUND(SUM(products.levy),2) as levy'),
        DB::raw('COUNT(cars.product_id) as cantidad'),'shops.invoice_id as invoiceid',
        DB::raw('ROUND(SUM(products.price + products.levy),2) as total'),'users.name as username')
        ->leftJoin('cars','shops.id','=','cars.shop_id')
        ->join('users','shops.user_id','=','users.id')
        ->leftJoin('products','cars.product_id','=','products.id')
        ->where('shops.invoice_id','=',$request->id)
       // ->where('cars.user_id',$id_user)
       
        ->where('cars.shop_id','<>',0)
        ->groupBy('cars.product_id');    
        return Datatables::of($products)->make(true);
    }
}  
