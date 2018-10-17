<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderdetail extends Model
{

	protected $fillable = [
        'quantity', 'price', 'subtotal'
    ];

    public function order() {
    	return $this->belongsTo('App\Order');
    }

    public function product() {
    	return $this->belongsTo('App\Models\Product');
    }

}
