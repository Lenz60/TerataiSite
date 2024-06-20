<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\OrdersPayment;
use App\Models\OrdersProduction;
use Inertia\Inertia;
use Illuminate\Http\Request; // Add this import statement
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    //
    public function index(){
        $cart = DB::table('cart')
        ->join('furniture', 'cart.furniture_id', '=', 'furniture.uuid')
        ->join('users', 'cart.user_id', '=', 'users.uuid')
        ->select('cart.id', 'cart.user_id', 'cart.furniture_id','cart.preorder','furniture.image','furniture.description','furniture.price', 'cart.qty','cart.total_price' )
        ->orderBy('cart.created_at', 'desc')
        ->get();
        // dd($cart);
        // return Inertia::render('Cart');
        //Add cart to the sessionstorage named cart
        // $carts = $cart;
        // $request->session()->put('cart', $carts);
        return Inertia::render('Cart', ['carts' => $cart]);
    }

    public function destroy(Request $request){
        // dd($request->all());
        // Delete furiture where request->uuid
        //Check the request if its array or not, if array proceed to delete multiple items,
        //
        if(is_array($request->uuid)){
            $furnituresId = $request->uuid;
            foreach ($furnituresId as $furniture){
                DB::table('cart')
                ->where('furniture_id', $furniture)
                ->delete();
            }
            return redirect()->route('cart.index');
        }else{
            $furnitureId = $request->uuid;
            DB::table('cart')
            ->where('furniture_id', $furnitureId)
            ->delete();
            return redirect()->route('cart.index');
        }

    }

    public function checkout(Request $request){
        // dd($request->all());
        // dd($request->all());
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
                'qty' => $cart['qty'],
                'total_price' => $cart['total_price'],
                'track_code' => 'TRK'.rand(1000,9999),
            ]);

            OrdersPayment::create([
                'order_id' => $orderId,
                'payment_method' => 'pending',
                'payment_status' => 'pending',
            ]);

            OrdersProduction::create([
                'order_id' => $orderId,
                'production_status' => 'In Production',
            ]);

        }

        return redirect()->back()->with('message', 'checkout:200');

    }
}
