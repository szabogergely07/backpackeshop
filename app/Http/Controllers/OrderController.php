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
	
	// public function __construct() {
 //    	if (Auth::check()) {
 //            $this->user = Auth::user();
 //        } else {
 //        	return redirect('login');
 //        }
 //    }

	public function index() {
		if (Auth::check()) {
            $user = Auth::user();
        } else {
        	return redirect('login');
        }

		$orders = Order::where('user_id', $user->id)->orderBy('created_at','desc')->get();

		foreach($orders as $order) {
			$orderId[] = $order->id;
		}

		$orderdetails = Orderdetail::whereIn('order_id', $orderId)->with('product')->get();
		//var_dump($orderdetails); die();

		return view('orders.orders', compact('orders', 'orderdetails'));
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
