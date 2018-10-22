<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\User;

class ProductController extends Controller
{

    private $myproducts;

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
     
        $ordersum = [];
        foreach ($this->myproducts as $myproduct) {
            $ordersum[] = $myproduct->pivot->subtotal;
        }
        $total = array_sum($ordersum);
        $quantity = count($ordersum);

        $products = Product::all();
        return view('products.products')->with('total',$total)->with('quantity',$quantity)->with('myproducts',$this->myproducts)->with('products',$products);

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
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ordersum = [];
        foreach ($this->myproducts as $myproduct) {
            $ordersum[] = $myproduct->pivot->subtotal;
        }
        $total = array_sum($ordersum);
        $quantity = count($ordersum);

        $product = Product::findorFail($id);

        return view('products.product')->with('total',$total)->with('quantity',$quantity)->with('myproducts',$this->myproducts)->with('product',$product);
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
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
