<?php
namespace App\Helpers;
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
}
