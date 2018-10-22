<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\User;

class BasketController extends Controller
{

    protected $myproducts;

    public function __construct() {
        
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
                $this->myproducts = Auth::user()->products;
                return $next($request);
        });
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
                $this->myproducts = Auth::user()->products;
                return $next($request);
        });



       $ordersum = [];
        foreach ($this->myproducts as $myproduct) {
            $ordersum[] = $myproduct->pivot->subtotal;
        }
        $total = array_sum($ordersum);
        $quantity = count($ordersum);

        return view('user.basket')->with('myproducts',$this->myproducts)->with('total',$total)->with('quantity',$quantity);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user('id');
        }

        $product = $request->input('id');
        $quantity = $request->input('quantity');
        
        $prod = Product::findOrFail($product);
        $subtotal = $prod->price * $quantity;
        //var_dump($subtotal); die();

        $oldproduct = $user->products()
            -> wherePivot('product_id', $product)->first();
            //var_dump($oldproduct->pivot->quantity); die();
        

        if(!$oldproduct) {
            $user->products()->attach($product, ['quantity' => $quantity, 'subtotal' => $subtotal]);
        } else {
            $quantity += $oldproduct->pivot->quantity;
            $user->products()->updateExistingPivot($product, ['quantity' => $quantity, 'subtotal' => $subtotal]);
        }
        return redirect('product');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         if (Auth::check()) {
            $user = Auth::user('id');
        }
        
        $quantity = $request->input('quantity');
        $prod = Product::findOrFail($id);

        if($request->input('way') == 1) {
            $quantity += 1;
        } else {
            $quantity -= 1;
        }

        $subtotal = $prod->price * $quantity;

        if($quantity > 0) {
            $user->products()->updateExistingPivot($id, ['quantity' => $quantity, 'subtotal' => $subtotal]);
        } else {
            $user->products()->detach($id);
        }

        return redirect('basket');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::check()) {
            $user = Auth::user('id');
        }
        
        $user->products()->detach($id);

        return redirect('basket');
    }
}
