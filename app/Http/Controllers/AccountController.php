<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App;
use Cache;

class AccountController extends Controller
{
    public function getProfile()
    {
        $user = Auth::guard('web')->user();
        return view('profile',[
            'user'=>$user,
        ]);
    }
}
