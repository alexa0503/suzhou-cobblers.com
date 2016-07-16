<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App;
use Session;
use Cart;
use Auth;

class OrderController extends Controller
{
    public function types()
    {
        $product_types = App\ProductType::whereNull('parent_id')->get();
        return view('types', ['types'=>$product_types]);
    }
    public function create(Request $request)
    {
        $user_id = \Auth::guard('web')->user()->id;
        $locale = App::getLocale();
        $cart = Cart::instance($locale);
        $items = $cart->content();
        $address = App\DeliverAdress::findOrFail($request->input('address'));
        if( $address->user_id != $user_id){
            return Response('您没有足够的权限',503);
        }
        return view('order.create',[
            'items'=>$items,
            'cart'=>$cart,
            'address'=>$address,
        ]);
    }
    public function store(Request $request)
    {
        if( $request->pay == 'alipay' ){
            $alipay = app('alipay.web');
            $alipay->setOutTradeNo('order_id');
            $alipay->setTotalFee('order_price');
            $alipay->setSubject('goods_name');
            $alipay->setBody('goods_description');
            $alipay->setQrPayMode('4');
            return redirect()->to($alipay->getPayLink());
        }
    }
    public function pay(Request $request)
    {
    }
    public function indexPayment(Request $request)
    {
        $locale = App::getLocale();
        $cart = Cart::instance($locale);
        $items = $cart->content();

        return view('payment',[
            'itmes'=>$items,
        ]);
    }
    public function postAddress(Request $request)
    {
        $this->validate($request, [
            'country' => 'required',
            'province' => 'required',
            'city' => 'required',
            'detailed_address'=>'required|max:120',
            'zip_code' => 'required|numeric',
            'first_name' => 'required|max:60',
            'last_name' => 'required|max:60',
            'phone_district'=>'required',
            'phone_number'=>'required|numeric',
        ]);
        $data = $request->all();
        unset($data['_token']);
        $data['phone_number'] = $data['phone_district'].' '.$data['phone_number'];
        $data['user_id'] = Auth::guard('web')->user()->id;
        $data['locale'] = App::getLocale();
        unset($data['phone_district']);
        $address = App\DeliverAdress::firstOrCreate($data);
        return ['ret'=>0,'data'=>['id'=>$address->id]];
    }
    public function address(Request $request)
    {
        $locale = App::getLocale();
        $cart = Cart::instance($locale);

        $user_id = \Auth::guard('web')->user()->id;
        $locale = App::getLocale();
        $addresses = App\DeliverAdress::where('locale', $locale)
            ->where('user_id', $user_id)->get();
        return view('address',[
            'addresses' => $addresses
        ]);
    }
    public function setDefaultAddress(Request $request, $id = null)
    {
        $user_id = \Auth::guard('web')->user()->id;
        $locale = App::getLocale();
        App\DeliverAdress::where('locale', $locale)
            ->where('user_id', $user_id)->update(['is_default' => 0]);
        $address = App\DeliverAdress::findOrFail($id);
        $address->is_default = 1;
        $address->save();
        return [‘ret’=>0];
    }
    public function deleteAddress(Request $request, $id = null)
    {
        $user_id = \Auth::guard('web')->user()->id;
        $locale = App::getLocale();

        $address = App\DeliverAdress::findOrFail($id);
        if( $address->user_id != $user_id ){
            return ['ret'=>1001, 'message'=>'抱歉，您没有足够的权限'];
        }
        $address->delete();
        return ['ret'=>0];
    }
}
