<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type_id = $request->get('type');
        if ( $type_id == null){
            return redirect(route('types'));
        }
        $products = App\Product::where('type_id', $type_id)->where('is_active',1)->orderBy('sort_id', 'ASC')->orderBy('created_at', 'DESC')->get();
        $types = App\ProductType::all();
        $type = App\ProductType::find($type_id);
        return view('product.index',[
            'products'=>$products,
            'types'=>$types,
            'type'=>$type,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $product = App\Product::find($id);
        $types = App\ProductType::all();
        $type = App\ProductType::find($product->type_id);
        $size_types = $product->sizes;
        $size_type = App\ProductSizeType::find($product->size_type_id);
        $size_type_desc = App::getLocale() == 'en' ? $size_type->en_desc : $size_type->zh_cn_desc;
        //var_dump($size_type);
        $products = App\Product::where('type_id', $product->type_id)->where('id', '!=', $product->id)->get()->random(2);
        //var_dump($products);
        //$locale = \Cookie::get('locale');
        return view('product.show', [
            'types'=>$types,
            'product'=>$product,
            'size_types'=>$size_types,
            'products'=>$products,
            'size_type_desc'=>$size_type_desc,
            'type'=>$type,
        ]);
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
        //
    }
}
