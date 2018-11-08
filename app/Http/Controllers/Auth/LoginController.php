<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Support\Facades\Redis;
use App\Models\Product;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/product';

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
        $this->middleware('guest')->except('logout');
        $this->categories = Category::all();
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $idWithQ = [];
        $quantity = -1;
        $idWithQ = $this->redis->hgetall('product');
        $ids = array_keys($idWithQ);
        $myproducts = Product::whereIn('id',$ids)->get();

        $total = [];
        foreach ($myproducts as $product) {
            $total[] = $idWithQ[$product->id] * $product->price;    
        }
        $total = array_sum($total);
        
        return view('auth.login')
            ->with('myproducts', $myproducts)
            ->with('categories', $this->categories)
            ->with('idWithQ',$idWithQ)
            ->with('total',$total);
    }

     /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $this->redis->flushDB();

        return $this->loggedOut($request) ?: redirect('/');
    }
}