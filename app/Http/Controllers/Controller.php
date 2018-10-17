<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $user;
    private $total;

      public function __construct()
    {
        $this->middleware('auth');

        // $users = User::all();
        // if (Auth::check()) {
        //     $this->user = Auth::user('id');
        // } else {
        //     return redirect('login');
        // }
        // $myproducts = $this->user->products;
        // $ordersum = [];
        // foreach ($myproducts as $myproduct) {
        //     $ordersum[] = $myproduct->pivot->subtotal;
        // }
        // $this->total = array_sum($ordersum);
    }



}
