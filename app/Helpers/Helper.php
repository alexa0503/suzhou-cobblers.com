<?php
namespace App\Helpers;
use Cache;
use App;
class Helper {
    public static function propertyConversion($properties)
    {
        $result = [];
        foreach($properties as $item){
            $result[$item->locale][$item->name] = $item->value;
        }
        return $result;
    }
    public static function priceConversion($prices)
    {
        $result = [];

        foreach($prices as $item){
            $currency = $item->locale == 'zh-cn' ? 'CNY' : 'USD';
            $symbol = $item->locale == 'zh-cn' ? '￥' : '$';
            $result[$item->locale] = ['value'=>$item->value,'currency'=>$currency,'symbol'=>$symbol];
        }
        return $result;
    }
    public static function getWorldCities($locale)
    {
        $cache_name = 'cities.'.$locale;
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
        return json_encode(Cache::get($cache_name));
    }
}
