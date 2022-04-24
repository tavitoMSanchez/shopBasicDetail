<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Car;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Auth;
class ProductController extends Controller
{
    public $data;

    public function __construct()
    {
        $this->middleware('auth');
       
    }
  
    public function getTotal()
    {
        $id_user = auth()->id();
        $datos = DB::table('products')
        ->join('cars', 'products.id', '=', 'cars.product_id')
        ->select(DB::raw('ROUND(SUM(products.price  + products.levy),2) as total_sales'))
        ->where('cars.user_id',$id_user)
        ->where('cars.shop_id',0)       
        ->first();
     
        return $datos;
    }

   public function carProducts(){
    $id_user = auth()->id();
  
    $products = Product::select('products.id as idproduct','products.name as producto',DB::raw('ROUND(SUM(products.price + products.levy),2) as price'),DB::raw('COUNT(*) as cantidad'))
    ->leftJoin('cars','products.id','=','cars.product_id')->where('cars.user_id',$id_user)->where('cars.shop_id',0)->groupBy('cars.product_id');  
   
    return $products;
   } 
   
   public  function index()
   {
        $id_user = auth()->id(); 
        $user = User::where('id',$id_user)->first();        
        $car = Car::select('id')->where('user_id',$id_user)->get();
        $total = $this->getTotal();
        $total2 = $this->carProducts();
        $products = Product::get();
        return view('client',compact('products','total','total2','user')); 
   }
   public  function indexcar()
   {
        $id_user = auth()->id(); 
        $user = User::where('id',$id_user)->first();        
        $car = Car::select('id')->where('user_id',$id_user)->get();
        $total = $this->getTotal();
        $total2 = $this->carProducts();
        $products = Product::get();
        return view('client.car',compact('products','total','total2','user')); 
   }

    public function table()
    {

       

        $id_user = auth()->id();
       $request = Product::select("products.id","products.name","products.description","products.price","products.levy", "cars.id as carsid")
       ->leftJoin('cars','products.id','=','cars.product_id')
       ->where('cars.user_id',$id_user)
       ->where('cars.shop_id',0);   
        $car = Car::select('id')->where('user_id',$id_user)->get();
       
        return Datatables::of($request)->addColumn('action', function($request){
            return '<button onClick="deletecarproduct('. $request->carsid .')"  class="btn-icon btn-icon-only btn btn-pill btn-sm btn-outline-danger"
             ><i class="bi bi-trash3"></i></button>';})->make(true);
            
         
    }

    public function tableProduct()
    {
        $id_user = auth()->id();
        $request = Product::all();    
 
        $car = Car::select('id')->where('user_id',$id_user)->get();
       
        return Datatables::of($request)->addColumn('action', function($request){
        return '<button onClick="editProduct('. $request->id .')"  class="btn-icon btn-icon-only btn btn-pill btn-sm btn-outline-primary"
            ><i class="bi bi-plus-circle-fill"></i></button>' . '<button onClick="deleteproduct('. $request->id .')"  class="btn-icon btn-icon-only btn btn-pill btn-sm btn-outline-danger"
             ><i class="bi bi-trash3"></i></button>';})->make(true);           
         
    }

    public function tableProductClient()
    {
        $id_user = auth()->id();
        $request = Product::all(); 
        return Datatables::of($request)->addColumn('action', function($request){
        return '<button onClick="addproductcar('. $request->id .')"  class="btn-icon btn-icon-only btn btn-pill btn-sm btn-outline-success"
        ><i class="bi bi-plus-circle-fill"></i></button>';})->make(true);
            
         
    }

    public function tablecar()
    {
        $total2 = $this->carProducts();
        return Datatables::of($total2)->make(true);
            
         
    }
    
    public function store(Request $request)
    {      
         $product = Product::create($request->all());
       
         if($product){
            $res = array('msg' => 'Se ha agregado el producto!');
            return response()->json($res);
          }    
       
    }

    public function delete(Request $request)
    {         
            $deleteproduct = Product::findOrFail($request->id);
            $deleteproduct->delete();
            if($deleteproduct){
                $res = array('msg' => 'Se ha eliminado de tu lista!');
                return response()->json($res);
              }       
    }
    public function updateProduct(Request $request)
    {
         $product =  DB::table('products')
        ->where('id',$request->id)
        ->update([ 'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'levy' => $request->levy]);

        if($product){
            $res = array('msg' => 'Se ha actualizado!');
            return response()->json($res);
          } 
    }
    public function edit(Request $request)
    {         
        $product = Product::findOrFail($request->id);        
        $res = array('product' => $product);
        return response()->json($res);
                   
    }
}
