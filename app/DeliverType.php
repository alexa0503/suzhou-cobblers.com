<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliverType extends Model
{
    public $timestamps = false;
    protected $fillable =  ['name', 'locale'];
    public function fees()
    {
        return $this->hasMany('App\DeliverFee');
    }
}
