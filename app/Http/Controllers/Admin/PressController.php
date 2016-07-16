<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Session;
use Carbon\Carbon;
use DB;

class PressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $types = App\Press::whereNull('parent_id')->get();
        if( !empty($request->input('type')) ){
            $presses = App\Press::where('parent_id', $request->input('type'))->paginate(20);
        }
        else{
            $presses = App\Press::whereNull('parent_id')->paginate(20);
        }
        return view('cms.press.index', [
            'presses'=>$presses,
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
        $types = App\Press::whereNull('parent_id')->get();
        return view('cms.press.create', [
            'types' => $types,
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
            'title_en' => 'required|max:60',
            'title_cn' => 'required|max:60',
            'thumb' => 'mimes:jpeg,bmp,png',
            'image' => 'mimes:jpeg,bmp,png',
        ]);

        $thumb = null;
        $image = null;

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

        if ($request->hasFile('image')) {
            if ($request->file('image')->getError() != 0) {
                return Response(['image' => $request->file('image')->getErrorMessage()], 422);
            }
            $file = $request->file('image');

            $entension = $file->getClientOriginalExtension();
            $file_name = uniqid().'.'.$entension;
            $path = 'uploads/'.date('Ymd').'/';
            $file->move(public_path($path), $file_name);
            $image = $path.$file_name;
        }
        $parent_id = (int)$request->input('parent_id') < 1 ? null : $request->input('parent_id');
        $press = new App\Press();
        $press->parent_id = $parent_id;
        $press->thumb = $thumb;
        $press->image = $image;
        $press->save();

        $property = new App\PressProperty();
        $property->name = 'title';
        $property->locale = 'en';
        $property->value = $request->input('title_en');
        $property->press_id = $press->id;
        $property->save();

        $property = new App\PressProperty();
        $property->name = 'title';
        $property->locale = 'zh-cn';
        $property->value = $request->input('title_cn');
        $property->press_id = $press->id;
        $property->save();
        return [];
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
        $press = App\Press::find($id);
        $types = App\Press::whereNull('parent_id')->get();
        return view('cms.press.edit', [
            'press' => $press,
            'types' => $types,
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
            'title_en' => 'required|max:60',
            'title_cn' => 'required|max:60',
            'thumb' => 'mimes:jpeg,bmp,png',
            'image' => 'mimes:jpeg,bmp,png',
        ]);

        $press = App\Press::find($id);
        $thumb = $press->thumb;
        $image = $press->image;

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

        if ($request->hasFile('image')) {
            if ($request->file('image')->getError() != 0) {
                return Response(['image' => $request->file('image')->getErrorMessage()], 422);
            }
            $file = $request->file('image');

            $entension = $file->getClientOriginalExtension();
            $file_name = uniqid().'.'.$entension;
            $path = 'uploads/'.date('Ymd').'/';
            $file->move(public_path($path), $file_name);
            $image = $path.$file_name;
        }
        $parent_id = (int)$request->input('parent_id') < 1 ? null : $request->input('parent_id');
        $press->parent_id = $parent_id;
        $press->thumb = $thumb;
        $press->image = $image;
        $press->save();

        $property = App\PressProperty::where('press_id', $press->id)->where('locale', 'en')->first();
        if( $property == null ){
            $property = new App\PressProperty();
        }
        $property->name = 'title';
        $property->locale = 'en';
        $property->value = $request->input('title_en');
        $property->press_id = $press->id;
        $property->save();

        $property = App\PressProperty::where('press_id', $press->id)->where('locale', 'zh-cn')->first();
        if( $property == null ){
            $property = new App\PressProperty();
        }
        $property->name = 'title';
        $property->locale = 'zh-cn';
        $property->value = $request->input('title_cn');
        $property->press_id = $press->id;
        $property->save();
        return [];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $press = App\Press::find($id);
        if( $press->parent_id == null){
            $count = App\Press::where('parent_id', $id)->count();
            if($count > 0){
                return ['ret'=>1001, 'msg'=>'该分类下有内容，无法删除'];
            }
        }
        DB::transaction(function () use($id) {
            App\PressProperty::where('press_id', $id)->delete();
            App\Press::destroy($id);
        });
        return ['ret' => 0, 'msg' => ''];
    }
}
