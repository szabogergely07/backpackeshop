<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    private $myproducts;
    private $categories;

    public function __construct() {
            
        $this->categories = Category::all();
        $this->middleware(function ($request, $next) {
                if (Auth::user()) {
                    $this->myproducts = Auth::user()->products;
                   
                }
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
        //
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
        $user = User::find($id);

        $ordersum = [];

        if (isset($this->myproducts)) {
            foreach ($this->myproducts as $myproduct) {
                $ordersum[] = $myproduct->pivot->subtotal;
            }
        }
        $total = array_sum($ordersum);
        $quantity = count($ordersum);

        return view('user.edit')
            ->with('total',$total)
            ->with('quantity',$quantity)
            ->with('myproducts',$this->myproducts)
            ->with('categories',$this->categories)
            ->with('user',$user);

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
        $password = $request->input('password');

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        // $user->password = Hash::make('$password');
        $user->save();

        return redirect('/');
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
