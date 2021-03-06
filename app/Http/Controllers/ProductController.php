<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Category;
use App\Review;
use Illuminate\Support\Facades\Redis;

class ProductController extends Controller
{
    protected $redis;
    private $myproducts;
    private $categories;

    public function __construct() {
        
        $this->redis = Redis::connection();
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
    public function index($pages=10)
    {
        $idWithQ = [];
        $ordersum = [];
        $products = Product::with('reviews')->paginate($pages);
        $total = 0;
        $quantity = -1;

        if (Auth::check()) {
            if (isset($this->myproducts)) {
                foreach ($this->myproducts as $myproduct) {
                    $ordersum[] = $myproduct->pivot->subtotal;
                }
            }
            $total = array_sum($ordersum);
            $quantity = count($ordersum);
        } else {
            $idWithQ = $this->redis->hgetall('product');
            $ids = array_keys($idWithQ);
            $this->myproducts = Product::whereIn('id',$ids)->get();

            $total = [];
            foreach ($this->myproducts as $product) {
                $total[] = $idWithQ[$product->id] * $product->price;    
            }
            $total = array_sum($total);
        }

        return view('products.products')
            ->with('total',$total)
            ->with('quantity',$quantity)
            ->with('myproducts',$this->myproducts)
            ->with('products',$products)
            ->with('categories',$this->categories)
            ->with('idWithQ',$idWithQ);

    }

    public function categories($category) {
        $idWithQ = [];
        $ordersum = [];
        $products = Product::where('category_id',$category)->paginate(10);
        $total = 0;
        $quantity = -1;

        if (Auth::check()) {
            if (isset($this->myproducts)) {
                foreach ($this->myproducts as $myproduct) {
                    $ordersum[] = $myproduct->pivot->subtotal;
                }
            }
            $total = array_sum($ordersum);
            $quantity = count($ordersum);
        } else {
            $idWithQ = $this->redis->hgetall('product');
            $ids = array_keys($idWithQ);
            $this->myproducts = Product::whereIn('id',$ids)->get();

            $total = [];
            foreach ($this->myproducts as $product) {
                $total[] = $idWithQ[$product->id] * $product->price;    
            }
            $total = array_sum($total);
        }

        return view('products.products')
        ->with('total',$total)
        ->with('quantity',$quantity)
        ->with('myproducts',$this->myproducts)
        ->with('products',$products)
        ->with('categories',$this->categories)
        ->with('idWithQ',$idWithQ);
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
        $idWithQ = [];
        $ordersum = [];
        $total = 0;
        $quantity = -1;
        $product = Product::findorFail($id);

        // To show paginated reviews
        $reviews = Review::where('product_id',$id)->paginate(3);
        
        // Get the average rating of a product as a percentage
        $prodReviews = Review::where('product_id',$id)->get();
        $reviewCount = $prodReviews->count();

        if (Auth::check()) {
            if (isset($this->myproducts)) {
                foreach ($this->myproducts as $myproduct) {
                    $ordersum[] = $myproduct->pivot->subtotal;
                }
            }
            $total = array_sum($ordersum);
            $quantity = count($ordersum);
        } else {
            $idWithQ = $this->redis->hgetall('product');
            $ids = array_keys($idWithQ);
            $this->myproducts = Product::whereIn('id',$ids)->get();

            $total = [];
            foreach ($this->myproducts as $product) {
                $total[] = $idWithQ[$product->id] * $product->price;    
            }
            $total = array_sum($total);
        }
        
        return view('products.product')
            ->with('total',$total)
            ->with('quantity',$quantity)
            ->with('myproducts',$this->myproducts)
            ->with('product',$product)
            ->with('categories',$this->categories)
            ->with('reviews',$reviews)
            ->with('reviewCount',$reviewCount)
            ->with('idWithQ',$idWithQ);
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
