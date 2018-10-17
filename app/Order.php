<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

	protected $fillable = [
        'total'
    ];


    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function orderdetail() {
    	return $this->hasOne('App\Orderdetail');
    }
}
