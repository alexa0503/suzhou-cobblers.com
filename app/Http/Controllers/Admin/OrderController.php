<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( null != $request->get('status')){
            $orders = App\Order::where('status',$request->get('status'))->paginate(20);
        }
        else{
            $orders = App\Order::paginate(20);
        }
        return view('cms.order.index',[
            'orders'=>$orders,
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
    public function show($id)
    {
        $order = App\Order::find($id);
        if( $order->locale == 'zh-cn' ){
            $order->detail_address = $order->country->name_cn.','.$order->province->name_cn;
            if( $order->city != null ){
                $order->detail_address .= ','.$order->city->name_cn;
            }
            $order->detail_address .= $order->deliver_address;
        }
        else{
            $order->detail_address = $order->deliver_address;
            if( $order->city != null ){
                $order->detail_address .= ','.$order->city->name_en;
            }
            $order->detail_address .= ','.$order->province->name_en.','.$order->country->name_en;
        }

        $order->price_symbol = $order->locale == 'zh-cn' ? '￥' : '$';
        return view('cms.order.show',['order'=>$order]);
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
        $order = App\Order::find($id);
        if($order->status == 1){
            $this->validate($request, [
                'deliver_no' => 'required|max:60',
            ]);
            $order->deliver_no = $request->input('deliver_no');
        }
        $order->status = $request->input('status');
        $order->save();
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
        //
    }
}
