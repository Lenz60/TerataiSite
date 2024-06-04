<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller
{
    //

    public function index(Request $request){
        $furniture = DB::table('furniture')
        ->get();
        $user = Auth::user();

        if($user){
            return Inertia::render('Catalog', ['furnitures' => $furniture, 'user' => true]);

        }else{
            return Inertia::render('Catalog', ['furnitures' => $furniture, 'user' => false]);

        }
        // dd($request->all());

        // return Inertia::render('Catalog', ['furnitures' => $furniture]);
    }

    public function cart(Request $request){
        // dd($request->uuid);
        $payloadFurniture = $request->uuid;
        $furnitureSelected = DB::table('furniture')
        ->where('uuid', $payloadFurniture)
        ->first();

        // dd($request->all());

        if($request->preorder){
            $preorder = true;
        }else{
            $preorder = false;
        }

        // dd($furnitureSelected);

        // $cart = DB::table('cart');
        $user = Auth::user();
        // dd($user->uuid);

        //Check if the furniture is already in the cart
        $cart = DB::table('cart')
        ->where('user_id', $user->uuid)
        ->where('furniture_id', $payloadFurniture)
        ->first();

        if($cart){
            // dd('Exist');
            $qty = $cart->qty + 1;
            $total_price = $furnitureSelected->price * $qty;
            DB::table('cart')
            ->where('user_id', $user->uuid)
            ->where('furniture_id', $payloadFurniture)
            ->update([
                'qty' => $qty,
                'total_price' => $total_price
            ]);

        }else{
            // dd('Does not exist');
            $this->createCart($user, $payloadFurniture, $preorder, $furnitureSelected);

        }


    }

    public function indexFiltered(){
        // dd(request('category'));
        $category = request('category');
        // dd('Test');
        $furniture = DB::table('furniture')
        ->where('category', $category)
        ->get();
        // dd($request->all());

        return Inertia::render('Catalog', ['furnitures' => $furniture]);
    }

    public function createCart($user, $payloadFurniture, $preorder, $furnitureSelected){
        Cart::create([
            'user_id' => $user->uuid,
            'furniture_id' => $payloadFurniture,
            'preorder'=> $preorder,
            'qty' => 1,
            'total_price' => $furnitureSelected->price
        ]);
    }


}
