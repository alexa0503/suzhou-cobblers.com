<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Session;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = App\Page::find($id);
        $property = App\PageProperty::where('page_id', $id)
            ->where('locale', Session::get('locale.language'))
            ->first();
        if( $property == null ){
            $title = $page->title;
            $desc = '';
        }
        else{
            $title = $property->name;
            $desc = $property->desc;
        }
        $data = [
            'id'=>$id,
            'title'=>$title,
            'desc'=>$desc,
            'thumb'=>$page->thumb,
        ];
        return view('cms.page.edit', ['page' => (object)$data]);
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
            //'image_path' => 'mimes:jpeg,bmp,png',
            //'like_num' => 'required',
        ]);


        /*
        $image_path = $post->image_path;
        if ($request->hasFile('image_path')) {
            if ($request->file('image_path')->getError() != 0) {
                return Response(['image_path' => $request->file('image_path')->getErrorMessage()], 422);
            }
            $file = $request->file('image_path');

            $entension = $file->getClientOriginalExtension();
            $file_name = uniqid().'.'.$entension;
            $path = 'uploads/posts/';
            $file->move(public_path($path), $file_name);
            $image_path = $path.$file_name;
        }
        */
        if( Session::get('locale.language') == 'en' ){
            $page = App\Page::find($id);
            $page->title = $request->input('title');
            $page->save();
        }
        $property = App\PageProperty::where('page_id', $id)
            ->where('locale', Session::get('locale.language'))
            ->first();
        if( $property == null ){
            $property = new App\PageProperty();
            $property->page_id = $id;
            $property->locale = Session::get('locale.language');
        }
        $property->name = $request->input('title');
        $property->desc = $request->input('desc');
        $property->save();

        //$post->desc = $request->input('desc');
        //$post->like_num = $request->input('like_num');
        //$post->image_path = $image_path;

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
        //
    }
}
