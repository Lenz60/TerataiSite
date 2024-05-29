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

        if($request->preorder){
            $qty = 0;
        }else{
            $qty = 1;
        }

        // dd($furnitureSelected);

        // $cart = DB::table('cart');
        $user = Auth::user();
        // dd($user->uuid);
        Cart::create([
            'id' => fake()->uuid(),
            'user_id' => $user->uuid,
            'furniture_id' => $payloadFurniture,
            'qty' => $qty,
            'total_price' => $furnitureSelected->price
        ]);
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


}
