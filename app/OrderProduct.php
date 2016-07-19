<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        'product_id',
        'product_name',
        'unit_price',
        'qty',
        'order_id',
        'user_id',
    ];
    public $timestamps = false;
    public function detail()
    {
        return $this->belongsTo('App\Product','product_id');
    }
}
