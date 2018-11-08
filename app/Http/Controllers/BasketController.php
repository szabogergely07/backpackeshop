<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Category;
use Illuminate\Support\Facades\Redis;

class BasketController extends Controller
{
    protected $redis;
    protected $myproducts;
    protected $categories;

    public function __construct() {
        //$this->middleware('auth');
        $this->redis = Redis::connection();
      
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     

        $this->categories = Category::all();    
         $total = 0;
         $quantity = 0;

        if (Auth::check()) {
            
            $this->myproducts = Auth::user()->products;

           $ordersum = [];
            foreach ($this->myproducts as $myproduct) {
                $ordersum[] = $myproduct->pivot->subtotal;
            }
            $total = array_sum($ordersum);
            $quantity = count($ordersum);
        } else {
            return redirect('login');
        }

        return view('user.basket')
            ->with('myproducts',$this->myproducts)
            ->with('total',$total)
            ->with('quantity',$quantity)
            ->with('categories',$this->categories);
        

     
        
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


        $product = $request->input('id');
        $quantity = $request->input('quantity');
        

        $prod = Product::findOrFail($product);
        $subtotal = $prod->price * $quantity;
        //var_dump($subtotal); die();


        if (Auth::check()) {
            $user = Auth::user('id');

            $oldproduct = $user->products()
                -> wherePivot('product_id', $product)->first();
                //var_dump($oldproduct->pivot->quantity); die();
            

            if(!$oldproduct) {
                $user->products()->attach($product, ['quantity' => $quantity, 'subtotal' => $subtotal]);
            } else {
                $quantity += $oldproduct->pivot->quantity;
                $newsubtotal = $quantity * $prod->price;
                $user->products()->updateExistingPivot($product, ['quantity' => $quantity, 'subtotal' => $newsubtotal]);
            }
            
        } else {
            $this->redis->hset('product',$product,$quantity);
            $this->redis->expire('product',3600);
            //$this->redis->set('id:'.$product,$quantity);
            //var_dump($this->redis->type(5)); die();

            // $this->redis->hSet($product, 'quantity', $quantity);
            // $this->redis->hSet($product, 'id', $product);

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
        $product = Product::findOrFail($id);

        if($request->input('way') == 1) {
            $quantity += 1;
        } else {
            $quantity -= 1;
        }

        $subtotal = $product->price * $quantity;

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
