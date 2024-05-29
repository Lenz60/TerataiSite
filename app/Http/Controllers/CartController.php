<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    //
    public function index(){
        $cart = DB::table('cart')
        ->join('furniture', 'cart.furniture_id', '=', 'furniture.uuid')
        ->join('users', 'cart.user_id', '=', 'users.uuid')
        ->select('cart.id', 'cart.user_id', 'cart.furniture_id','furniture.image','furniture.description', 'cart.qty','cart.total_price' )
        ->get();
        // dd($cart);
        // return Inertia::render('Cart');
        return Inertia::render('Cart', ['carts' => $cart]);
    }
}
