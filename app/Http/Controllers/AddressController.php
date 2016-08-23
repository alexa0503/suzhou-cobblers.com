<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App;
use App\Helpers\Helper;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locale = App::getLocale();
        $addresses = App\DeliverAddress::where('user_id', Auth::user()->id)->where('locale',$locale)->get();
        return view('address.index',[
            'addresses' => $addresses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $world_cities = Helper::getWorldCities(App::getLocale());
        return view('address.create',[
            'world_cities'=>$world_cities
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
            'country_id' => 'required',
            'province_id' => 'required',
            //'city' => 'required',
            'detailed_address'=>'required|max:120',
            'zip_code' => 'required|max:10',
            'first_name' => 'required|max:60',
            'last_name' => 'required|max:60',
            'phone_number'=>'required|max:20',
        ]);

        $data = $request->all();
        //unset($data['id']);
        unset($data['_token']);
        unset($data['_method']);
        $data['phone_number'] = $data['phone_number'];
        $data['user_id'] = Auth::guard('web')->user()->id;
        $data['locale'] = App::getLocale();
        App\DeliverAddress::firstOrCreate($data);

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
        $user_id = Auth::guard('web')->user()->id;
        $locale = App::getLocale();

        $world_cities = Helper::getWorldCities($locale);
        $address = App\DeliverAddress::find($id);
        if($address->user_id != $user_id || $address->locale != $locale){
            return redirect('address');
        }
        return view('address.edit',[
            'world_cities'=>$world_cities,
            'address' => $address
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_id = Auth::guard('web')->user()->id;
        $locale = App::getLocale();
        $world_cities = Helper::getWorldCities($locale);
        $address = App\DeliverAddress::find($id);
        if($address->user_id != $user_id || $address->locale != $locale){
            return redirect('address');
        }
        return view('address.edit',[
            'world_cities'=>$world_cities,
            'address' => $address
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
            'country_id' => 'required',
            'province_id' => 'required',
            //'city' => 'required',
            'detailed_address'=>'required|max:120',
            'zip_code' => 'required|max:10',
            'first_name' => 'required|max:60',
            'last_name' => 'required|max:60',
            'phone_number'=>'required|max:20',
        ]);

        $data = $request->all();
        unset($data['_token']);
        unset($data['_method']);
        App\DeliverAddress::where('id',$id)->update($data);
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
        $user_id = Auth::guard('web')->user()->id;
        $locale = App::getLocale();

        $address = App\DeliverAddress::findOrFail($id);
        if( $address->user_id != $user_id ){
            return ['ret'=>1001, 'message'=>'抱歉，您没有足够的权限'];
        }
        $address->delete();
        return ['ret'=>0];
    }

    public function default(Request $request, $id = null)
    {
        $user_id = Auth::guard('web')->user()->id;
        $locale = App::getLocale();
        App\DeliverAddress::where('locale', $locale)
            ->where('user_id', $user_id)->update(['is_default' => 0]);
        $address = App\DeliverAddress::findOrFail($id);
        $address->is_default = 1;
        $address->save();
        return ['ret'=>0];
    }
}
