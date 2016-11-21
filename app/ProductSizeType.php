<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSizeType extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name', 'value', 'en_desc', 'zh_cn_desc'
    ];
    
}
