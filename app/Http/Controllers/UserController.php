<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $user;
    private $myproducts;
    private $total;
    private $users;

    public function __construct() {
        $this->users = User::all();
       
            $this->middleware(function ($request, $next) {
                $this->myproducts = Auth::user()->products;

                    return $next($request);
            });
       
        // $ordersum = [];
        // foreach ($this->myproducts as $myproduct) {
        //     $ordersum[] = $myproduct->pivot->subtotal;
        // }
        // $this->total = array_sum($ordersum);

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

        $products = Product::all();
        return view('user.users')->with('users',$this->users)->with('products',$products)->with('total',$total)->with('myproducts',$this->myproducts);
    }

    public function basket() {
         $ordersum = [];
        foreach ($this->myproducts as $myproduct) {
            $ordersum[] = $myproduct->pivot->subtotal;
        }
        $total = array_sum($ordersum);

        return view('user.basket')->with('myproducts',$this->myproducts)->with('total',$total);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
