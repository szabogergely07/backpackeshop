<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

	protected $fillable = [
        'body', 'rating'
    ];


    public function product() {
    	return $this->belongsTo('App\Models\Product');
    }

    public function user() {
    	return $this->belongsTo('App\User');
    }
}
