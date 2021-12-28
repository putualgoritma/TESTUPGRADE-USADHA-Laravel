<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Manufacture extends Model
{
   public $table = 'product_manufacture';

    protected $fillable = [
        'good_id',
        'product_id',
        'quantity',
    ];
}
