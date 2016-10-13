<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Session;
use Carbon\Carbon;
use DB;
use App\Helpers\Helper;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $types = App\ProductType::all();
        if( !empty($request->input('type')) ){
            $products = App\Product::where('type_id', $request->input('type'))->paginate(20);
        }
        else{
            $products = App\Product::paginate(20);
        }
        return view('cms.product.index', [
            'products'=>$products,
            'types'=>$types,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = App\ProductType::all();
        $size_types = App\ProductSizeType::all();
        return view('cms.product.create',[
            'types'=>$types,
            'size_types'=>$size_types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_name' => 'required|max:60',
            'stock' => 'required|numeric',
            'product_type' => 'exists:product_types,id',
            'product_size_type' => 'exists:product_size_types,id',
            'price' => 'required|numeric',
            'desc' => 'required',
            //'return_desc' => 'required',
            //'clean_desc' => 'required',
            //'thumb' => 'mimes:jpeg,bmp,png,gif',
        ]);

        $thumb = [];
        if ($request->hasFile('thumb')) {
            foreach( $request->file('thumb') as $file ){
                if ($file->getError() != 0) {
                    return Response(['thumb[]' => $file->getErrorMessage()], 422);
                }
                $entension = $file->getClientOriginalExtension();
                $file_name = uniqid().'.'.$entension;
                $path = 'uploads/'.date('Ymd').'/';
                $file->move(public_path($path), $file_name);
                $thumb[] = $path.$file_name;
            }
        }
        DB::beginTransaction();
        try{
            //
            $product = new App\Product();
            $locale = Session::get('locale.language');
            //$product->title = $request->input('product_name');
            $product->stock = $request->input('stock');
            //$product->creatd_at = Carbon::now();
            $product->size_type_id = $request->input('product_size_type');
            $product->type_id = $request->input('product_type');
            $product->save();
            //图库
            foreach( $thumb as $k=>$v){
                $image = new App\ProductImage();
                $image->is_preview = $k == 0 ? 1 : 0;
                $image->image_path = $v;
                $image->product_id = $product->id;
                $image->save();
            }
            //价格
            $price = new App\ProductPrice();
            $price->value = $request->input('price');
            $price->locale = $locale;
            $price->product_id = $product->id;
            $price->save();

            //产品名称
            $property = new App\ProductProperty();
            $property->product_id = $product->id;
            $property->locale = $locale;
            $property->name = 'title';
            $property->value = $request->input('product_name');
            $property->save();
            //产品描述
            $property = new App\ProductProperty();
            $property->product_id = $product->id;
            $property->locale = $locale;
            $property->name = 'desc';
            $property->value = $request->input('desc');
            $property->save();
            //退换说明
            $property = new App\ProductProperty();
            $property->product_id = $product->id;
            $property->locale = $locale;
            $property->name = 'return_desc';
            $property->value = $request->input('return_desc');
            $property->save();
            //退换说明
            $property = new App\ProductProperty();
            $property->product_id = $product->id;
            $property->locale = $locale;
            $property->name = 'clean_desc';
            $property->value = $request->input('clean_desc');
            $property->save();

            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            return Response(['thumb[]' => $e->getMessage()], 422);
        }
        return ['ret' => 0];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = App\Product::find($id);
        $prices = Helper::priceConversion($product->prices);
        $properties = Helper::propertyConversion($product->properties);
        //var_dump($product->size_type);

        return view('cms.product.show',['product'=>$product,'properties'=>$properties,'prices'=>$prices]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = App\Product::find($id);
        $types = App\ProductType::all();
        $size_types = App\ProductSizeType::all();
        return view('cms.product.edit',[
            'types'=>$types,
            'size_types'=>$size_types,
            'product'=>$product
        ]);
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
        $this->validate($request, [
            'product_name' => 'required|max:60',
            'stock' => 'required|numeric',
            'product_type' => 'exists:product_types,id',
            'product_size_type' => 'exists:product_size_types,id',
            'price' => 'required|numeric',
            'desc' => 'required',
            //'return_desc' => 'required',
            //'clean_desc' => 'required',
            //'thumb' => 'mimes:jpeg,bmp,png,gif',
        ]);

        $thumb = [];
        if ($request->hasFile('thumb')) {
            foreach( $request->file('thumb') as $file ){
                if ($file->getError() != 0) {
                    return Response(['thumb[]' => $file->getErrorMessage()], 422);
                }
                $entension = $file->getClientOriginalExtension();
                $file_name = uniqid().'.'.$entension;
                $path = 'uploads/'.date('Ymd').'/';
                $file->move(public_path($path), $file_name);
                $thumb[] = $path.$file_name;
            }
        }
        DB::beginTransaction();
        try{
            $product = App\Product::find($id);
            $locale = Session::get('locale.language');
            //$product->title = $request->input('product_name');
            $product->stock = $request->input('stock');
            $product->size_type_id = $request->input('product_size_type');
            $product->type_id = $request->input('product_type');
            $product->save();
            //删除图片
            if( $locale == 'en' && !empty($thumb)){
                App\ProductImage::where('product_id', $product->id)->delete();
            }

            //图库
            foreach( $thumb as $k=>$v){
                $image = new App\ProductImage();
                $image->is_preview = $k == 0 ? 1 : 0;
                $image->image_path = $v;
                $image->product_id = $product->id;
                $image->save();
            }
            //价格
            $price_model = App\ProductPrice::where('product_id', $product->id)->where('locale', $locale);
            if( $price_model->count() == null){
                $price = new App\ProductPrice();
            }
            else{
                $price = $price_model->first();
            }
            $price->value = $request->input('price');
            $price->locale = $locale;
            $price->product_id = $product->id;
            $price->save();

            //产品名称
            $property_model = App\ProductProperty::where('product_id', $product->id)
                ->where('locale', $locale)
                ->where('name', 'title');
            if( $property_model->count() == null){
                $property = new App\ProductProperty();
            }
            else{
                $property = $property_model->first();
            }
            $property->product_id = $product->id;
            $property->locale = $locale;
            $property->name = 'title';
            $property->value = $request->input('product_name');
            $property->save();
            //产品描述
            $property_model = App\ProductProperty::where('product_id', $product->id)
                ->where('locale', $locale)
                ->where('name', 'desc');
            if( $property_model->count() == null){
                $property = new App\ProductProperty();
            }
            else{
                $property = $property_model->first();
            }
            $property->product_id = $product->id;
            $property->locale = $locale;
            $property->name = 'desc';
            $property->value = $request->input('desc');
            $property->save();
            //退换说明
            $property_model = App\ProductProperty::where('product_id', $product->id)
                ->where('locale', $locale)
                ->where('name', 'return_desc');
            if( $property_model->count() == null){
                $property = new App\ProductProperty();
            }
            else{
                $property = $property_model->first();
            }
            $property->product_id = $product->id;
            $property->locale = $locale;
            $property->name = 'return_desc';
            $property->value = $request->input('return_desc');
            $property->save();
            //清洁说明
            $property_model = App\ProductProperty::where('product_id', $product->id)
                ->where('locale', $locale)
                ->where('name', 'clean_desc');
            if( $property_model->count() == null){
                $property = new App\ProductProperty();
            }
            else{
                $property = $property_model->first();
            }
            $property->product_id = $product->id;
            $property->locale = $locale;
            $property->name = 'clean_desc';
            $property->value = $request->input('clean_desc');
            $property->save();

            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            return Response(['thumb[]' => $e->getMessage()], 422);
        }
        return ['ret' => 0];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::transaction(function () use($id) {
            App\ProductImage::where('product_id', $id)->delete();
            App\ProductPrice::where('product_id', $id)->delete();
            App\ProductProperty::where('product_id', $id)->delete();
            App\Product::destroy($id);
        });
        return ['ret' => 0, 'msg' => ''];
    }
    //产品上架
    public function status($id)
    {
        $product = App\Product::find($id);
        $product->is_active = $product->is_active == 1 ? 0 : 1;
        $product->save();
        return ['ret'=>0,'msg'=>''];
    }
}
