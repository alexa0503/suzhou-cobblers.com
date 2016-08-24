<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;

class DeliverTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = App\DeliverType::paginate(20);
        return view('cms.deliverType.index',[
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
        return view('cms.deliverType.create',[
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
            'locale' => 'required',
        ]);
        $form_data = [
            'name' => $request->get('name'),
            'locale' => $request->get('locale'),
        ];
        App\DeliverType::firstOrCreate($form_data);

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

        $type = App\DeliverType::find($id);
        return view('cms.deliverType.edit',[
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
            'locale' => 'required',
        ]);
        $type = App\DeliverType::find($id);
        $type->name = $request->get('name');
        $type->locale = $request->get('locale');
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
        $count = App\DeliverFee::where('type_id', $id)->count();
        if($count > 0){
            return ['ret'=>1001,'msg'=>'该分类下存在对应的运费设置，无法删除~'];
        }
        App\DeliverType::destroy($id);
        return ['ret'=>0];
    }
}
