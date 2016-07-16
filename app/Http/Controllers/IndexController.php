<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Carbon\Carbon;
use App;
use Session;
use Cart;
use Auth;

class IndexController extends Controller
{
    public function types()
    {
        $product_types = App\ProductType::whereNull('parent_id')->get();
        return view('types', ['types'=>$product_types]);
    }
    public function address(Request $request, $id = null)
    {
        $address = App\DeliverAddress::findOrFail($id);
        return $address;
    }
}
