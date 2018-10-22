<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Orderdetail;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\User;

class OrderController extends Controller
{
	protected $myproducts;

	public function __construct() {
    	
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
                $this->myproducts = Auth::user()->products;
                return $next($request);
        });
    }

	public function index() {
		
        $user = Auth::user();
        
		$orders = Order::where('user_id', $user->id)->orderBy('created_at','desc')->get();

		foreach($orders as $order) {
			$orderId[] = $order->id;
		}

		$orderdetails = Orderdetail::whereIn('order_id', $orderId)->with('product')->get();
		//var_dump($orderdetails); die();

        $ordersum = [];
        foreach ($this->myproducts as $myproduct) {
            $ordersum[] = $myproduct->pivot->subtotal;
        }
        $total = array_sum($ordersum);
        $quantity = count($ordersum);

		return view('orders.orders')->with('orders',$orders)->with('orderdetails',$orderdetails)->with('total',$total)->with('quantity',$quantity)->with('myproducts',$this->myproducts);
	}

    public function store(Request $request) {
    	if (Auth::check()) {
            $user = Auth::user();
        } else {
        	return redirect('login');
        }


        //Create new Order
        $order = new Order;
        $total = [];
        foreach($user->products as $product) {
        	$total[] = $product->pivot->subtotal;
    	}

    	$order->total = array_sum($total);
    	$order->user_id = $user->id;

    	$order->save();

    	//Create new order details
    	foreach($user->products as $product) {
    		$order_details = new Orderdetail;
			$order_details->product_id = $product->pivot->product_id;
			$order_details->order_id = $order->id;
			$order_details->quantity = $product->pivot->quantity;
			$order_details->price = $product->price;
			$order_details->subtotal = $product->pivot->subtotal;
			$order_details->save();
		}

		//Delete Cart
		$user->products()->detach();

		return redirect('order');

    }
}
