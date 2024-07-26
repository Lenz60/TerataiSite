<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\OrdersInfo;
use Illuminate\Http\Request;
use App\Models\OrdersPayment;
use App\Models\OrdersProduction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia; // Add this line to import the Inertia facade

class CheckoutController extends Controller
{

    public function index2(){
        $cart = DB::table('cart')
        ->join('furniture', 'cart.furniture_id', '=', 'furniture.uuid')
        ->join('users', 'cart.user_id', '=', 'users.uuid')
        ->select('cart.id', 'cart.user_id', 'cart.furniture_id','cart.preorder','furniture.image','furniture.description','furniture.color','furniture.wood_type','furniture.price', 'cart.qty','cart.total_price' )
        ->orderBy('cart.created_at', 'desc')
        ->get();

        return Inertia::render('Checkout/Checkout',['carts' => $cart]);
    }

    public function index(Request $request){
        // dd($request->all());
        // $cart = DB::table('cart')
        // ->join('furniture', 'cart.furniture_id', '=', 'furniture.uuid')
        // ->join('users', 'cart.user_id', '=', 'users.uuid')
        // ->select('cart.id', 'cart.user_id', 'cart.furniture_id','cart.preorder','furniture.image','furniture.description','furniture.color','furniture.wood_type','furniture.price', 'cart.qty','cart.total_price' )
        // ->orderBy('cart.created_at', 'desc')
        // ->get();
        $user = Auth::user();

        $cartCounts = DB::table('cart')->where('user_id', $user->uuid)->count();
        $cart  = $request->cart;
        $totalPrice = $request->totalPrice;

        return Inertia::render('Checkout/Checkout',['carts' => $cart, 'totalPrice' => $totalPrice, 'cartCounts' => $cartCounts]);
    }

    public function create(Request $request){
        // dd($request->all());
        $info = $request->info;
        $carts = $request->cart;
        $orderId = fake()->uuid;
        $totalOrderPrice = $request->totalPrice;
        Order::create([
            'id' => $orderId,
            'total_price' => $totalOrderPrice,
            'track_code' => 'TRK'.rand(1000,9999),
        ]);
        // dd($request->totalPrice);
        foreach($carts as $cart){

            // dd($cart['total_price']);
            if($cart['preorder']==0){
                $preorder = 'false';
            }else{
                $preorder = 'true';
            }

            OrderItems::create([
                //TODO: add Original price in OrderItems table
                'order_id' => $orderId,
                'user_id' => $cart['user_id'],
                'furniture_id'=>$cart['furniture_id'],
                'preorder'=>$preorder,
                'price' => $cart['price'],
                'qty' => $cart['qty'],
                'total_price' => $cart['total_price'],
                'track_code' => 'TRK'.rand(1000,9999),
            ]);
        }
        OrdersPayment::create([
            'order_id' => $orderId,
            'payment_method' => 'pending',
            'payment_status' => 'pending',
        ]);

        OrdersProduction::create([
            'order_id' => $orderId,
            'production_status' => 'In Production',
        ]);

        OrdersInfo::create([
            'order_id' => $orderId,
            'phone_number' => $info['phoneNumber'],
            'address' => $info['address'],
            'country' => $info['country'],
            'region' => $info['region'],
            'zip' => $info['zip'],
        ]);

        return redirect()->back()->with('message', 'checkout:200');
    }
}
