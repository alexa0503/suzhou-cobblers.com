<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;

class SizeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = App\ProductSizeType::paginate(20);
        return view('cms.sizeType.index',[
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
        return view('cms.sizeType.create',[
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
            'name' => 'required',
            'value' => 'required',
        ]);
        $form_data = [
            'name' => $request->get('name'),
            'value' => serialize(explode(',',trim($request->get('value')))),
            'en_desc' => $request->input('en_desc'),
            'zh_cn_desc' => $request->input('zh_cn_desc'),
        ];
        App\ProductSizeType::firstOrCreate($form_data);

        return ['ret'=>0];
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

        $type = App\ProductSizeType::find($id);
        return view('cms.sizeType.edit',[
            'type'=>$type,
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
            'name' => 'required',
            'value' => 'required',
        ]);
        $type = App\ProductSizeType::find($id);
        $type->name = $request->get('name');
        $type->value = serialize(explode(',',trim($request->get('value'))));
        $type->en_desc = $request->input('en_desc');
        $type->zh_cn_desc = $request->input('zh_cn_desc');
        $type->save();
        return ['ret'=>0];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count = App\Product::where('size_type_id', $id)->count();
        if($count > 0){
            return ['ret'=>1001,'msg'=>'尺码下有产品，无法删除~'];
        }
        App\ProductSizeType::destroy($id);
        return ['ret'=>0];
    }
}
