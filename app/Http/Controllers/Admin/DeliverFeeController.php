<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;

class DeliverFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fees = App\DeliverFee::paginate(20);
        return view('cms.deliverFee.index',[
            'fees'=>$fees,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = App\DeliverType::all();
        $countries = App\WorldCity::whereNull('parent_id')->get();
        $json_provinces = [];
        foreach($countries as $country){
            $provinces = $country->sub->map(function($item,$key){
                return ['id'=>$item->id,'name'=>$item->name_cn];
            });
            $json_provinces[$country->id] = $provinces->all();
        }

        return view('cms.deliverFee.create',[
            'types'=>$types,
            'countries'=>$countries,
            'json_provinces'=>json_encode($json_provinces),
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
            'type' => 'required',
            'country' => 'required',
        ]);
        $data = $request->all();
        $value = [];
        foreach($data['value'] as $k=>$v){
            $value[$data['key'][$k]] = $v;
        }
        $form_data = [];
        $form_data['type_id'] = $data['type'];
        $form_data['value'] = json_encode($value);
        $form_data['city_id'] = null == $data['province'] ? $data['country'] : $data['province'];

        App\DeliverFee::firstOrCreate($form_data);

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
        $types = App\DeliverType::all();
        $countries = App\WorldCity::whereNull('parent_id')->get();
        $json_provinces = [];
        foreach($countries as $country){
            $provinces = $country->sub->map(function($item,$key){
                return ['id'=>$item->id,'name'=>$item->name_cn];
            });
            $json_provinces[$country->id] = $provinces->all();
        }
        $fee = App\DeliverFee::find($id);

        return view('cms.deliverFee.edit',[
            'types'=>$types,
            'countries'=>$countries,
            'json_provinces'=>json_encode($json_provinces),
            'fee'=>$fee,
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
            'type' => 'required',
            'country' => 'required',
        ]);
        $data = $request->all();
        $fee = App\DeliverFee::find($id);
        $value = [];
        foreach($data['value'] as $k=>$v){
            $value[$data['key'][$k]] = $v;
        }

        $fee->type_id = $data['type'];
        $fee->city_id = null == $data['province'] ? $data['country'] : $data['province'];
        $fee->value = json_encode($value);
        $fee->save();

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
        //
    }
}
