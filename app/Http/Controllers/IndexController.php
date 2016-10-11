<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Carbon\Carbon;
use App;
use Session;
use Cart;
use Auth;
use Cache;

class IndexController extends Controller
{
    public function types()
    {
        $product_types = App\ProductType::whereNull('parent_id')->get();
        return view('types', ['types'=>$product_types]);
    }
    public function newProduct()
    {
        $products = App\Product::where('is_active',1)->orderBy('created_at', 'DESC')->limit(12)->get();
        return view('new-product',[
            'products'=>$products,
        ]);
    }
    public function address(Request $request, $id = null)
    {
        $address = App\DeliverAddress::findOrFail($id);
        return $address;
    }
    public function indexAddress(Request $request)
    {

    }
    public function cities(Request $request)
    {
        //Cache::forget('cities');
        $cache_name = 'cities.'.App::getLocale();
        if (!Cache::has($cache_name)){
            $collection = App\WorldCity::where('parent_id',null)->get();
            $data = $collection->keyBy('id')->map(function($item){
                $collection = $item->sub;
                $provinces = $collection->keyBy('id')->map(function($item){
                    $collection = $item->sub;
                    $cities = $collection->keyBy('id')->map(function($item){
                        return ['name'=>$item->name];
                    });
                    return ['name'=>$item->name,'cities'=>$cities];
                });

                return ['name'=>$item->name,'provinces'=>$provinces];
            });

            Cache::forever($cache_name, $data);
        }

        return Cache::get($cache_name);
    }
}
