<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
//use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App;
use Session;
use Cart;
use Auth;
use Validator;
use DB;
use Omnipay\Omnipay;
use Cache;

class OrderController extends Controller
{
    public function types()
    {
        $product_types = App\ProductType::whereNull('parent_id')->get();
        return view('types', ['types'=>$product_types]);
    }
    public function index()
    {
        $user_id = Auth::guard('web')->user()->id;
        $locale = App::getLocale();
        $orders = App\Order::where('user_id', $user_id)->get();

        return view('order.index',['orders'=>$orders]);
    }
    public function create(Request $request)
    {
        $user_id = Auth::guard('web')->user()->id;
        $locale = App::getLocale();
        $cart = Cart::instance($locale);
        if($cart->count() == 0){
            return redirect(route('cart.index'));
        }
        $items = $cart->content();
        $address = App\DeliverAddress::findOrFail($request->input('address'));
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
        $this->validate($request, [
            'deliver_address' => 'required',
            'payment' => 'required',
            'deliver_type' => 'required',
            'buyer_message'=>'max:120',
        ]);
        $user_id = Auth::guard('web')->user()->id;
        $locale = App::getLocale();
        $deliver_fee = 0;///运费
        $order_no = date('YmdHis').$user_id;//生成订单编号
        $cart = Cart::instance($locale);
        if($cart->count() == 0){
            return redirect(route('cart.index'));
        }
        $items = $cart->content();
        $address = App\DeliverAddress::findOrFail($request->input('deliver_address'));
        $total_fee = $cart->subTotal() + $deliver_fee;
        $items_fee = $cart->subTotal();

        $order_data = [
            'deliver_address'=>$address->detailed_address,
            'consignee_last_name'=>$address->last_name,
            'consignee_first_name'=>$address->first_name,
            'consignee_zip_code'=>$address->zip_code,
            'consignee_phone_number'=>$address->phone_district.' '.$address->phone_number,
            'deliver_address'=>$address->detailed_address,
            'deliver_country_id'=>$address->country_id,
            'deliver_province_id'=>$address->province_id,
            'deliver_city_id'=>$address->city_id,
            'deliver_type'=>$request->input('deliver_type'),
            'deliver_fee'=>$deliver_fee,
            'total_fee'=>$total_fee,
            'items_fee'=>$items_fee,
            'order_no'=>$order_no,
            'buyer_message'=>$request->input('buyer_message'),
            'user_id'=>$user_id,
            'locale'=>$locale,
            'payment'=>$request->input('payment'),
            'status'=>0,
        ];
        DB::beginTransaction();
        try {
            $order = App\Order::firstOrCreate($order_data);
            foreach($items as $item){
                $product_data = [
                    'product_id'=>$item->options->product_id,
                    'product_name'=>$item->name,
                    'unit_price'=>$item->price,
                    'qty'=>$item->qty,
                    'order_id'=>$order->id,
                    'user_id'=>$user_id,
                ];
                App\OrderProduct::firstOrCreate($product_data);
                $items_name[] = $item->name;
            }
            $cart->destroy();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $error_msg = $e->getMessage()."<br/>";
            return Response($error_msg,503);
        }
        return redirect(route('order.pay',['id'=>$order->id]));




    }
    public function pay(Request $request, $id)
    {
        $order = App\Order::findOrFail($id);
        //支付宝
        if( $order->payment == 1 ){
            //git:https://github.com/lokielse/omnipay-alipay
            $gateway = Omnipay::create('Alipay_Express');
            $gateway->setPartner('2088102849184119');
            $gateway->setKey('m3qu2mlackd1yhi8jijygvjkb23zmzbh');
            $gateway->setSellerEmail('suzhou_cobblers@yahoo.com');
            $gateway->setReturnUrl(route('pay.return',['payment'=>'alipay']));
            $gateway->setNotifyUrl(route('pay.notify',['payment'=>'alipay']));
            $options = [
                'out_trade_no' => $order->order_no,
                'subject' => $order->subject,
                'total_fee'=>$order->total_fee,
            ];
            $response = $gateway->purchase($options)->send();
            $response->redirect();
        }
        //paypal
        elseif($order->payment == 2){
            $gateway = Omnipay::create('PayPal_Express');
            $options = config('laravel-omnipay.gateways.paypal.options');
            $gateway->setUsername($options['username']);
            $gateway->setPassword($options['password']);
            $gateway->setSignature($options['signature']);
            $options = array(
                'amount' => $order->total_fee,
                'currency' => 'USD',
                'description' => $order->subject,
                'transactionId' => $order->order_no,
                'transactionReference' => $order->order_no,
                'returnUrl' => route('pay.return',['payment'=>'paypal']),
                'cancelUrl' => route('pay.cancel',['payment'=>'paypal']),
                'notifyUrl' => route('pay.notify',['payment'=>'paypal'])
             );
             //var_dump($gateway);
             $response = $gateway->purchase($options)->send();
             //var_dump($response->getMessage(),route('pay.cancel',['payment'=>'paypal']));
             $response->redirect();
        }
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
            'country_id' => 'required',
            'province_id' => 'required',
            //'city' => 'required',
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
        $address = App\DeliverAddress::firstOrCreate($data);
        return ['ret'=>0,'data'=>['id'=>$address->id]];
    }
    public function address(Request $request)
    {
        $locale = App::getLocale();
        $cart = Cart::instance($locale);

        $user_id = Auth::guard('web')->user()->id;
        $locale = App::getLocale();
        $addresses = App\DeliverAddress::where('locale', $locale)
            ->where('user_id', $user_id)->get();

        //Cache::forget('cities');
        $cache_name = 'cities.'.App::getLocale();
        if (!Cache::has($cache_name)){
            $collection = App\WorldCity::where('parent_id',null)->get();
            $data = $collection->keyBy('id')->map(function($item){
                $collection = $item->sub;
                $provinces = $collection->keyBy('id')->map(function($item){
                    $collection = $item->sub;
                    $cities = $collection->keyBy('id')->map(function($item){
                        return ['name'=>$item->name];
                    });
                    return ['name'=>$item->name,'cities'=>$cities];
                });

                return ['name'=>$item->name,'provinces'=>$provinces];
            });

            Cache::forever($cache_name, $data);
        }
        $world_cities = json_encode(Cache::get($cache_name));

        //return Cache::get($cache_name);

        return view('order.address',[
            'addresses' => $addresses,
            'world_cities'=>$world_cities
        ]);
    }
    public function setDefaultAddress(Request $request, $id = null)
    {
        $user_id = Auth::guard('web')->user()->id;
        $locale = App::getLocale();
        App\DeliverAddress::where('locale', $locale)
            ->where('user_id', $user_id)->update(['is_default' => 0]);
        $address = App\DeliverAddress::findOrFail($id);
        $address->is_default = 1;
        $address->save();
        return [‘ret’=>0];
    }
    public function deleteAddress(Request $request, $id = null)
    {
        $user_id = Auth::guard('web')->user()->id;
        $locale = App::getLocale();

        $address = App\DeliverAddress::findOrFail($id);
        if( $address->user_id != $user_id ){
            return ['ret'=>1001, 'message'=>'抱歉，您没有足够的权限'];
        }
        $address->delete();
        return ['ret'=>0];
    }
    public function show()
    {

    }
}
