<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Redis;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    //protected $redis;
    // protected $myproducts;
    // protected $total;
    // protected $quantity;

      public function __construct()
    {
        // $this->middleware('auth');
          //$this->redis = Redis::connect();

    

    }

    // public function trial() {
    //         $this->middleware(function ($request, $next) {
    //         $this->myproducts = Auth::user();
    //         return $next($request);
    //     });

    // var_dump($this->myproducts); die();
        
    //     $ordersum = [];
    //     foreach ($this->myproducts as $myproduct) {
    //         $ordersum[] = $myproduct->pivot->subtotal;
    //     }
    //     $this->total = array_sum($ordersum);
    //     $this->quantity = count($ordersum);



        
    // }

}
