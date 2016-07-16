<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/_locale/{locale?}/{url?}', function ($locale = 'en', $url = null) {
    Session::set('locale.language',$locale);
    $cookie = cookie()->forever('locale', $locale);
    if( $url != null){
        return redirect(base64_decode($url))->withCookie($cookie);
    }
    elseif(Session::has('locale.redirect_uri')){
        return redirect(Session::get('locale.redirect_uri'))->withCookie($cookie);
    }
    else{
        return redirect('/')->withCookie($cookie);
    }

});

Route::group(['middleware' => ['web','locale','menu','auth:web']], function () {
    Route::get('/orders','OrderController@index')->name('order.index');
    Route::get('/order','OrderController@create')->name('order.create');
    Route::post('/order','OrderController@store')->name('order.store');
    Route::get('/order/pay','OrderController@pay')->name('order.pay');
    Route::get('/account','IndexController@account')->name('account');
    Route::get('/account/address','IndexController@accountAddress')->name('account.address');
    //地址api
    Route::get('/api/address/{id}', 'IndexController@address')->name('api.address');
    //订单地址管理
    Route::get('/order/address', 'OrderController@address')->name('order.address.index');
    Route::post('/order/address', 'OrderController@postAddress')->name('order.address.store');
    Route::put('/order/address/{id}/default', 'OrderController@setDefaultAddress')->name('order.address.default');
    Route::delete('/order/address/{id}', 'OrderController@deleteAddress')->name('order.address.delete');
    Route::get('/order/payment/index', 'OrderController@indexPayment')->name('order.payment.index');
});
Route::group(['middleware' => ['web','locale','menu']], function () {
    Route::auth('web');
    Route::get('/admin/login', 'Admin\AuthController@getLogin');
    Route::post('/admin/login', 'Admin\AuthController@postLogin');
    Route::any('/admin/logout', function(){
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    });

    Route::get('/', ['as'=>'home',function () {
        return view('index');
    }]);
    Route::get('/types', ['as'=>'types','uses'=>'IndexController@types']);
    Route::get('/presses', ['as'=>'presses',function () {
        $types = App\Press::whereNull('parent_id')->get();
        return view('press',['types'=>$types]);
    }]);
    //页面
    Route::get('/about', ['as'=>'page.about',function () {
        $page = App\Page::find(1);
        return view('page', ['page'=>$page]);
    }]);
    Route::get('/hand', ['as'=>'page.hand',function () {
        $page = App\Page::find(2);
        return view('page', ['page'=>$page]);
    }]);
    Route::get('/wholesale', ['as'=>'page.wholesale',function () {
        $page = App\Page::find(3);
        return view('page', ['page'=>$page]);
    }]);
    Route::get('/contact', ['as'=>'page.contact',function () {
        $page = App\Page::find(4);
        return view('page', ['page'=>$page]);
    }]);
    //购物车
    Route::get('/cart/count', 'CartController@count')->name('cart.count');
    Route::resource('/cart', 'CartController');
    //产品
    Route::resource('/product', 'ProductController');
});
Route::group(['middleware' => ['web','locale','menu', 'auth:admin']], function () {
    Route::get('/admin', 'AdminController@index')->name('admin_dashboard');
    Route::get('/admin/account', 'AdminController@account')->name('admin_account');
    Route::resource('/admin/page', 'Admin\PageController',['only' => ['index', 'update', 'edit']]);
    Route::put('/admin/product/status/{id}', 'Admin\ProductController@status')->name('admin.product.status');
    Route::resource('/admin/product', 'Admin\ProductController');
    Route::resource('/admin/products/type', 'Admin\ProductTypeController');
    Route::post('/admin/account', 'AdminController@accountPost');
    Route::resource('/admin/press', 'Admin\PressController');
    Route::post('/admin/file/upload', 'AdminController@fileUpload')->name('admin_file_upload');
    Route::post('/admin/file/delete', 'AdminController@fileDelete')->name('admin_file_delete');
});
Route::get('/admin/install', function () {
    if (0 == \App\Admin::count()) {
        $user = new \App\Admin();
        $user->name = 'admin';
        $user->email = 'wanga503@outlook.com';
        $user->password = bcrypt('admin@2016');
        $user->save();
    }
    return redirect('/login');
});
