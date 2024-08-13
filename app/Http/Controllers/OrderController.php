<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //
    public function index(){
        $user = Auth::user();


        $orders = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('orders_payment', 'orders_payment.order_id', '=', 'orders.id')
            ->join('furniture', 'order_items.furniture_id', '=', 'furniture.uuid')
            ->join('users', 'orders.user_id', '=', 'users.uuid')
            ->where('users.uuid', '=', $user->uuid)
            ->select('orders.id','users.name','orders.track_code','orders_payment.payment_status')
            ->groupBy('orders.id', 'users.name', 'orders.track_code', 'orders_payment.payment_status')
            ->orderBy('orders.created_at', 'desc')
            ->get();

            $order_items = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('order_items_production', 'order_items_id', '=', 'order_items.id')
            ->join('furniture', 'order_items.furniture_id', '=', 'furniture.uuid')
            ->join('users', 'orders.user_id', '=', 'users.uuid')
            ->where('users.uuid', '=', $user->uuid)
            ->select('order_items.id as id','orders.id as order_id', 'users.uuid as user_id','users.name',
                        'order_items.furniture_id', 'furniture.description','furniture.color', 'furniture.image',
                            'order_items.preorder as preorder', 'order_items.qty', 'order_items.total_price','order_items_production.production_status as status')
            ->orderBy('order_items.created_at','desc')
            // ->groupBy('orders.id', 'order_items.user_id')
            ->get();

        $order_info = DB::table('orders')
            ->join('orders_payment', 'orders_payment.order_id', '=', 'orders.id')
            ->join('orders_info','orders_info.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.uuid')
            ->where('users.uuid', '=', $user->uuid)
            ->select('orders_info.id as id','orders.id as order_id','orders_info.name','orders_info.company','orders_info.email','orders_info.phone_number',
                        'orders_info.address','orders_info.country','orders_info.region','orders_info.zip'
                            ,'orders.track_code','orders_payment.payment_status')
            ->orderBy('orders.created_at', 'desc')
            ->groupBy('orders_info.id', 'orders.id', 'orders_info.name', 'orders_info.company', 'orders_info.email', 'orders_info.phone_number',
                'orders_info.address', 'orders_info.country', 'orders_info.region', 'orders_info.zip',
                'orders.track_code', 'orders_payment.payment_status')
            ->get();

            // dd($order_info);
        // dd($user->company);
        return Inertia::render('Orders',[
            'orders' => $orders,
            'order_items' => $order_items,
            'order_info' => $order_info
        ]);
    }
}
