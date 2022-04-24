<?php

namespace App\Http\Controllers;
use App\Models\Car;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use DB;
use Illuminate\Database\Eloquent\Builder;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
       
    }
   
    public function buyshop()
    {
        $id_user = auth()->id(); 
        //dd($id_user);
        $products = Car::select('id')->where('user_id',$id_user)->get();
        $shop = Shop::create( [
            'user_id' => $id_user,
        ]);

        foreach($products as $product)
        {
            DB::table('cars')
            ->where('id',$product->id)->where('cars.shop_id',0)
            ->update(['shop_id' => $shop['id']]);            
        }

        $res = array('msg' => 'Se ha comprado el producto!');
        return response()->json($res);     
        
    }
}
