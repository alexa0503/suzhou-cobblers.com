<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App;
use Cart;
class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locale = App::getLocale();
        $cart = Cart::instance($locale);
        $items = $cart->content();
        //var_dump($items);
        //return [];
        return view('cart.index',[
            'items'=>$items,
            'cart'=>$cart,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $locale = App::getLocale();
        $cart = Cart::instance($locale);
        //$cart->destroy();
        $id = $request->input('id');
        $size = $request->input('size');
        $num = $request->input('num');
        $product = App\Product::find($id);
        //$product->sizes;
        if($product->stock < $num ){
            return ['ret'=>1001,'msg'=>trans('messages.not_enough_goods')];
        }
        $cart->add([
            //'product'=>$product,
            'id'=>$locale.'_'.$product->id.'_'.$size,
            'name'=>$product->title,
            'qty'=>$num,
            'price'=>$product->price,
            'options'=>[
                'size'=>$size,
                'product_id'=>$product->id,
                'locale'=>$locale,
                'thumb'=>$product->preview_image,
                'sizes'=>$product->sizes,
            ]
        ]);
        $count = $cart->count();
        return ['ret'=>0,'data'=>['num'=>$count]];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $locale = App::getLocale();
        $cart = Cart::instance($locale);
        $cart->remove($id);
        return ['ret'=>0,'msg'=>''];
    }
    public function count(Request $request)
    {
        $locale = App::getLocale();
        $cart = Cart::instance($locale);
        $count = $cart->count();
        return ['ret'=>0,'data'=>['num'=>$count]];
    }
}
