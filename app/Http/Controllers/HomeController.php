<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            if (Auth::user()) {
                $this->myproducts = Auth::user()->products;   
            }
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

        $products = Product::all();
        return view('home')->with('total',$total)->with('quantity',$quantity)->with('myproducts',$this->myproducts)->with('products',$products);
    }
}
