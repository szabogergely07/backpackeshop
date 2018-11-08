<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Category;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    protected $categories;
    protected $redis;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->redis = Redis::connection();
        // $this->middleware(function ($request, $next) {
        //     if (Auth::user()) {
        //         $this->myproducts = Auth::user()->products;   
        //     }
        //     return $next($request);
        // });
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total = 0;
        $quantity = -1;
        $products = Product::all();
        $this->categories = Category::all();    

        if (Auth::check()) {
            $this->middleware(function ($request, $next) {
                    $this->myproducts = Auth::user()->products;
                    return $next($request);
            });
            $ordersum = [];
            if (isset($this->myproducts)) {
                foreach ($this->myproducts as $myproduct) {
                    $ordersum[] = $myproduct->pivot->subtotal;
                }
            } else {
                $this->myproducts = [];
            }

            $total = array_sum($ordersum);
            $quantity = count($ordersum);


        } else {

            //$ids = $this->redis->lrange('ids',0,100);
            
            $idWithQ = $this->redis->hgetall('product');
            $ids = array_keys($idWithQ);
            $this->myproducts = Product::whereIn('id',$ids)->get();

            $total = [];
            foreach ($this->myproducts as $product) {
                $total[] = $idWithQ[$product->id] * $product->price;    
            }
            $total = array_sum($total);
        }

        return view('home')
            ->with('total',$total)
            ->with('quantity',$quantity)
            ->with('myproducts',$this->myproducts)
            ->with('products',$products)
            ->with('categories',$this->categories)
            ->with('idWithQ',$idWithQ);

    }
}
