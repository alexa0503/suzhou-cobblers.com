<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;
class Order extends Model
{
    //
    protected $fillable = [
        'deliver_address',
        'consignee_last_name',
        'consignee_first_name',
        'consignee_zip_code',
        'consignee_phone_number',
        'deliver_address',
        'deliver_country_id',
        'deliver_province_id',
        'deliver_city_id',
        'deliver_type',
        'deliver_fee',
        'total_fee',
        'items_fee',
        'order_no',
        'buyer_message',
        'user_id',
        'locale',
        'status',
        'payment',
    ];
    public function getSubjectAttribute($vaule)
    {
        return 'Alipay';
    }
    public function products()
    {
        return $this->hasMany('App\OrderProduct');
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function country()
    {
        return $this->hasOne('App\WorldCity','id','deliver_country_id');
    }
    public function city()
    {
        return $this->hasOne('App\WorldCity','id','deliver_city_id');
    }
    public function province()
    {
        return $this->hasOne('App\WorldCity','id','deliver_province_id');
    }
    public function deliver()
    {
        return $this->hasOne('App\DeliverType','id','deliver_type');
    }
}
