<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Omnipay\Omnipay;
use Log;
use App;

class PayController extends Controller
{
    public function index(Request $request, $payment, $id)
    {
        if($payment == 'alipay'){
            $gateway = Omnipay::create('Alipay_Express');
            $config = config('laravel-omnipay.gateways.alipay.options');
            $gateway->setPartner($config['partner']);
            $gateway->setKey($config['partner']);
            $gateway->setSellerEmail($config['sellerEmail']);

            $options = [
                'request_params'=> array_merge($_POST, $_GET),
            ];

            $response = $gateway->completePurchase($options)->send();

            if ($response->isPaid()) {
               return view('pay.success');
            } else {
                return view('pay.fail');
            }
        }
        else{
            $order = App\Order::find($id);
            if($order->status != 0){
                return redirect('/');
            }
            $gateway = Omnipay::create('PayPal_Express');
            $config = config('laravel-omnipay.gateways.paypal.options');
            $gateway->setUsername($config['username']);
            $gateway->setPassword($config['password']);
            $gateway->setSignature($config['signature']);
            $gateway->setTestMode($config['testMode']);
            $options = [
                'request_params'=> array_merge($_POST, $_GET), //Don't use $_REQUEST for may contain $_COOKIE
                'amount'=>$order->total_fee,
            ];
             $response = $gateway->completePurchase($options)->send();
             if ($response->isSuccessful()) {
                 $flag = Mail::send('emails.buy',['order'=>$order],function($message){
                     $to = 'suzhou_cobblers@yahoo.com';
                 $message->to($to)->subject($order->order_no.'订单支付成功');
                 });
                 
                 $order->status = 1;
                 $order->save();
                 return view('pay.success');
             }  else {
                $message = $response->getMessage();
                 Log::error($message);
                 return view('pay.fail');
             }
        }

    }
    public function notify(Request $request, $payment)
    {
        if($payment == 'alipay'){
            $gateway = Omnipay::create('Alipay_Express');
            $config = config('laravel-omnipay.gateways.alipay.options');
            $gateway->setPartner($config['partner']);
            $gateway->setKey($config['partner']);
            $gateway->setSellerEmail($config['sellerEmail']);
            $options = [
                'request_params'=> array_merge($_POST, $_GET),
            ];

            $response = $gateway->completePurchase($options)->send();

            if ($response->isPaid()) {
                die('success');
            } else {
                die('fail');
            }
        }
        else{
            $order = App\Order::find($id);
            if($order->status != 0){
                return '';
            }
            $gateway = Omnipay::create('PayPal_Express');
            $config = config('laravel-omnipay.gateways.paypal.options');
            $gateway->setUsername($config['username']);
            $gateway->setPassword($config['password']);
            $gateway->setSignature($config['signature']);
            $gateway->setTestMode($config['testMode']);
            $options = [
                'request_params'=> array_merge($_POST, $_GET), //Don't use $_REQUEST for may contain $_COOKIE
                'amount'=>$order->total_fee,
            ];
             $response = $gateway->completePurchase($options)->send();

             if ($response->isSuccessful()) {
                $flag = Mail::send('emails.buy',['order'=>$order],function($message){
                    $to = 'suzhou_cobblers@yahoo.com';
                $message->to($to)->subject($order->order_no.'订单支付成功');
                });
                $order->status = 1;
                $order->save();
                return 'success';
             }  else {
                $message = $response->getMessage();
                Log::error($message);
                return 'fail';
             }
        }
    }
    public function cancel()
    {
        return redirect(route('order.index'));
    }
}
