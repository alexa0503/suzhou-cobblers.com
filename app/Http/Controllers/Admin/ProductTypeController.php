<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Session;
use DB;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = App\ProductType::with('properties')->paginate(20);
        return view('cms.productType.index', ['types'=>$types]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms.productType.create');
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
            'title' => 'required|max:60',
            'desc' => 'required',
            'thumb' => 'mimes:jpeg,bmp,png,gif',
        ]);
        $thumb = '';
        if ($request->hasFile('thumb')) {
            if ($request->file('thumb')->getError() != 0) {
                return Response(['thumb' => $request->file('thumb')->getErrorMessage()], 422);
            }
            $file = $request->file('thumb');

            $entension = $file->getClientOriginalExtension();
            $file_name = uniqid().'.'.$entension;
            $path = 'uploads/'.date('Ymd').'/';
            $file->move(public_path($path), $file_name);
            $thumb = $path.$file_name;

        }
        DB::beginTransaction();
        try{
            $type = new App\ProductType();
            $type->thumb = $thumb;
            if( Session::get('locale.language') == 'en' ){
                $type->title = trim($request->input('title'));
            }
            $type->save();
            $property = App\ProductTypeProperty::where('product_type_id', $type->id)
                ->where('locale', Session::get('locale.language'))
                ->first();
            if( $property == null ){
                $property = new App\ProductTypeProperty();
                $property->product_type_id = $type->id;
                $property->locale = Session::get('locale.language');
            }
            $property->name = trim($request->input('title'));
            $property->desc = $request->input('desc');
            $property->save();
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            return Response(['thumb' => $e->getMessage()], 422);
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
        $type = App\ProductType::find($id);
        return view('cms.productType.edit', ['type'=>$type]);
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
            'title' => 'required|max:60',
            'desc' => 'required',
            'thumb' => 'mimes:jpeg,bmp,png,gif',
        ]);
        $type = App\ProductType::find($id);
        $thumb = $type->thumb;
        if ($request->hasFile('thumb')) {
            if ($request->file('thumb')->getError() != 0) {
                return Response(['thumb' => $request->file('thumb')->getErrorMessage()], 422);
            }
            $file = $request->file('thumb');

            $entension = $file->getClientOriginalExtension();
            $file_name = uniqid().'.'.$entension;
            $path = 'uploads/'.date('Ymd').'/';
            $file->move(public_path($path), $file_name);
            $thumb = $path.$file_name;
            $type->thumb = $thumb;
        }

        if( Session::get('locale.language') == 'en' ){
            $type->title = trim($request->input('title'));
        }
        $type->save();
        $property = App\ProductTypeProperty::where('product_type_id', $id)
            ->where('locale', Session::get('locale.language'))
            ->first();
        if( $property == null ){
            $property = new App\ProductTypeProperty();
            $property->product_type_id = $id;
            $property->locale = Session::get('locale.language');
        }
        $property->name = trim($request->input('title'));
        $property->desc = $request->input('desc');
        $property->save();
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
        $count = App\Product::where('type_id',$id)->count();
        if( $count > 0){
            return ['ret' => 1001, 'msg' => '该分类仍然有产品，无法删除'];
        }
        DB::transaction(function () use($id) {
            App\ProductTypeProperty::where('product_type_id', $id)->delete();
            App\ProductType::destroy($id);
        });

        return ['ret' => 0, 'msg' => ''];
    }
}
