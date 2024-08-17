<?php

namespace App\Http\Controllers;

use App\Models\Furniture;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\OrderItems;
use App\Models\OrdersInfo;
use Illuminate\Http\Request;
use App\Models\OrdersPayment;
use App\Models\OrdersProduction;
use Illuminate\Support\Facades\DB;
use App\Models\OrderItemsProduction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $user = Auth::user();
        $info = $request->info;
        $carts = $request->cart;
        $orderId = fake()->uuid;
        $totalOrderPrice = $request->totalPrice;
        // dd($user->uuid);
        //Generate PDF function here
        Order::create([
            'id' => $orderId,
            'user_id'=> $user->uuid,
            'total_price' => $totalOrderPrice,
            'track_code' => 'TRK'.rand(1000,9999),
            'invoice_status' => 'Pending',
        ]);
        // dd($request->totalPrice);
        foreach($carts as $cart){

            // dd($cart['total_price']);
            if($cart['preorder']==0){
                $preorder = 'false';
            }else{
                $preorder = 'true';
            }
            $orderItemsId = fake()->uuid;

            OrderItems::create([
                //TODO: add Original price in OrderItems table
                'id'  => $orderItemsId,
                'order_id' => $orderId,
                'furniture_id'=>$cart['furniture_id'],
                'preorder'=>$preorder,
                'price' => $cart['price'],
                'qty' => $cart['qty'],
                'total_price' => $cart['total_price'],
                'track_code' => 'TRK'.rand(1000,9999),
            ]);

            // OrdersProduction::create([
            //     'order_id' => $orderId,
            //     'production_status' => 'In Production',
            // ]);
            OrderItemsProduction::create([
                'order_items_id' => $orderItemsId,
                'production_status' => 'In Production',
            ]);
        }
        OrdersPayment::create([
            'order_id' => $orderId,
            'payment_method' => 'Pending',
            'payment_status' => 'Pending',
        ]);


        OrdersInfo::create([
            'order_id' => $orderId,
            'name'=> $info['name'],
            'company' => $info['company'],
            'email' => $info['email'],
            'phone_number' => $info['phoneNumber'],
            'address' => $info['address'],
            'country' => $info['country'],
            'region' => $info['region'],
            'zip' => $info['zip'],
        ]);


            $clearCart = $this->deleteCart($carts);
            if($clearCart){
                return redirect()->route('cart.index');
            }

        // return redirect()->route('cart.destroy');
    }
    public function deleteCart($carts){
        foreach ($carts as $cart){
                $deleteCart = DB::table('cart')
                ->where('id', $cart['id'])
                ->delete();
        }
        return $deleteCart;
    }

    public function generateInvoice(){
        // dd(resource_path('Pages/Invoice/Template.vue'));
        $user = Auth::user();
        $path = public_path(). '/pdf/' . $user->name .' Invoice' . '.pdf';
        $css = file_get_contents(resource_path('css/app.css'));
        // dd($css);
        // $template =resource_path()->get('Pages/Invoice/Template.vue');
        $furniture = Furniture::get();
        $data  = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y'),
            'furnitures' => $furniture
        ];
        $pdf = PDF::loadView('template', $data);
        // $pdf = PDF::loadFile(resource_path('Pages/Invoice/Template.vue'),$data);
        $setCss = $pdf->getCss($css);
        $pdf->setCss($setCss);
        $pdf->setPaper('A4', 'landscape');
        $pdf->save($path);
        return response()->download($path);
        // return $pdf->download('invoice.pdf');
    }

    public function pdf(){
        return view('template1');
    }
}
