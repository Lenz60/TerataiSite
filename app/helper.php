<?php

use App\Models\Order;
use Barryvdh\DomPDF\PDF;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

if(!function_exists("generateInvoice")){
    function generateInvoice($order_id){
        $orders = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('orders_payment', 'orders_payment.order_id', '=', 'orders.id')
            ->join('furniture', 'order_items.furniture_id', '=', 'furniture.uuid')
            ->join('users', 'orders.user_id', '=', 'users.uuid')
            ->where('orders.id', '=', $order_id)
            ->select('orders.id','users.name','orders.track_code','orders_payment.payment_status')
            // ->groupBy('orders.id', 'users.name', 'orders.track_code', 'orders_payment.payment_status')
            // ->orderBy('orders.created_at', 'desc')
            ->first();

            $order_items = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('order_items_production', 'order_items_id', '=', 'order_items.id')
            ->join('furniture', 'order_items.furniture_id', '=', 'furniture.uuid')
            ->join('users', 'orders.user_id', '=', 'users.uuid')
            ->where('orders.id', '=', $order_id)
            ->select('order_items.id as id','users.name','order_items.furniture_id', 'furniture.description','furniture.color',
                            'order_items.price', 'order_items.qty', 'order_items.total_price')
            // ->orderBy('order_items.created_at','desc')
            // ->groupBy('orders.id', 'order_items.user_id')
            ->get();

        $info = DB::table('orders')
            ->join('orders_payment', 'orders_payment.order_id', '=', 'orders.id')
            ->join('orders_info','orders_info.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.uuid')
            ->where('orders.id', '=', $order_id)
            ->select('orders_info.name','orders_info.company','orders_info.email','orders_info.phone_number',
                        'orders_info.address','orders_info.country','orders_info.region','orders_info.zip')
            ->first();

        $user = Auth::user();
        // dd($info);
        // dd($orders);
        // dd($order_items);
        $code = $orders->track_code;
        $orders = Order::get()->where('id', '=', $order_id)->first();
        $path = public_path(). '/pdf/' . $user->name .'[Invoice-'. $code . ']' . '.pdf';
        $css = file_get_contents(resource_path('css/app.css'));

        $orderItemsArray = $order_items->toArray();
        // dd($orderItemsArray);
        // $infoArray = $info->toArray();
        $infoArray = [
            'name' => $info->name,
            'company' => $info->company,
            'address' => $info->address,
            'country' => $info->country,
            'region' => $info->region,
            'zip' => $info->zip
        ];
        $transformedCarts = array_map(function($item) {
            return [
                'id' => $item->id,
                'description' => $item->description,
                'qty' => $item->qty,
                'price' => $item->price,
                'color' => $item->color,
                'total_price' => $item->total_price
            ];
        }, $orderItemsArray);
        // dd($orderItemsArray);

        $data  = [
            'title' => 'Invoice',
            'code' => $code,
            'name' => $infoArray['name'],
            'company' => $infoArray['company'],
            'address'=> $infoArray['address'],
            'country' => $infoArray['country'],
            'region' => $infoArray['region'],
            'zip' => $infoArray['zip'],
            'date' => $orders->created_at,
            'furnitures' => $transformedCarts,
            'totalPrice' => $orders->total_price
        ];
        // dd($data);

        // $data  = [
        //     'title' => 'Invoice',
        //     'code' => $code,
        //     'name' => $infoArray['name'],
        //     'company' => $infoArray['company'],
        //     'address'=> $infoArray['address'],
        //     'country' => $infoArray['country'],
        //     'region' => $infoArray['region'],
        //     'zip' => $infoArray['zip'],
        //     'date' => $orders->created_at,
        //     'furnitures' => $order_items,
        //     'totalPrice' => $orders->total_price
        // ];
        // dd($data);

        // !Placeholder
        // $data  = [
        //     'title' => 'Invoice',
        //     'code' => "1121",
        //     'name' => "John",
        //     'address'=> "Jogja",
        //     'country' => "United States",
        //     'region' => "United States",
        //     'zip' => "1234",
        //     'date' => date("d-m-Y"),
        //     'furnitures' => $furniture,
        //     'totalPrice' => "asdasdads"
        // ];
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('template', $data);
        // // $pdf = PDF::loadFile(resource_path('Pages/Invoice/Template.vue'),$data);
        $setCss = $pdf->getCss($css);
        $pdf->setCss($setCss);
        $pdf->setPaper('A4', 'portrait');
        // // return $pdf->stream();
        $pdf->save($path);
        return response()->download($path);
        // logic to generate invoice using order_id
        // return invoice_number
    }
}
