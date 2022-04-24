<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Car;
use Illuminate\Http\Request;
use DB;
use Illuminate\Database\Eloquent\Builder;

class CarController extends Controller
{
    public $total = 0;
   

    public function getTotal()
    {
       $id_user = auth()->id();
       $datos = DB::table('products')
        ->join('cars', 'products.id', '=', 'cars.product_id')
        ->select(DB::raw('SUM(products.price + products.levy) as total_sales'))
        ->where('cars.user_id',$id_user)
        ->where('cars.shop_id',0)
        //->groupBy('department')
        // ->havingRaw('SUM(price) > ?', [2500])
        ->first();

        return $datos;
    }
   
    public function store(Request $request)
    {

        $id_user=auth()->id();        
        $product = Car::create([
            'product_id' => $request->product_id,
            'user_id' => $id_user,
        ]);
       
        $total = $this->getTotal(); 
        if($product){
           $res = array('msg' => 'Se ha agregado a tu lista!','total' => $total);
           return response()->json($res);
         }
    }

    public function destroy(Car $car)
    {

        $deletecar = Car::findOrFail($car->id);
        $deletecar->delete();
        if($deletecar){
            $res = array('msg' => 'Se ha eliminado de tu lista!');
            return response()->json($res);
          }
    }
    public function delete(Request $request)
    {

        $deletecar = Car::findOrFail($request->id);
        $deletecar->delete();
        if($deletecar){
            $res = array('msg' => 'Se ha eliminado de tu lista!');
            return response()->json($res);
          }
    }
}
