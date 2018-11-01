<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Product;
use App\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
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
        $this->validate($request, [
            'body' => 'required|max:1000',
            'rating' => 'required',
            'productId' => 'required'
        ]);


        $body = $request->input('body');
        $rating = $request->input('rating');
        $product = $request->input('productId');
        $user = Auth::user()->id;

        $review = new Review;
        $review->body = $body;
        $review->rating = $rating;
        $review->product_id = $product;
        $review->user_id = $user;

        $review->save();

        // Get the average rating of a product as a percentage
        $prodReviews = Review::where('product_id',$product)->get();
        $sum = [];
        foreach ($prodReviews as $prodReview) {
            $sum[] = $prodReview->rating;
        }

        if (!empty($sum)) {
            $average = (array_sum($sum) / count($sum)) / 5 * 100;
        } else {
            $average = 0;
        }

        // Update the product average rating
        $prodRating = Product::findOrFail($product);
        $prodRating->product_rating = $average;
        $prodRating->save();

        //return redirect()->route('product.show', ['id' => $product]);

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
