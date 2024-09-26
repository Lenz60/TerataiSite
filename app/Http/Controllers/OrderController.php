<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Http\Request;
use Termwind\Components\Raw;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        // dd(public_path('pdf/'));
        // delete all files inside of asset(pdf/)
        // Storage::disk('public')->deleteDirectory('pdf');
        $files = glob(public_path('pdf/*')); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }

        // dd($order_items);
        return Inertia::render('Orders',[
            'orders' => $orders,
            'order_items' => $order_items,
            'order_info' => $order_info
        ]);
    }
    public function invoice(Request $request){
        $orderId = $request->Id;
        // $user = Auth::user();
        // $orders = Order::get()->where('id', '=', $orderId)->first();
        // $code = $orders->track_code;
        // $fileName =  $user->name .'[Invoice-'. $code . ']' . '.pdf';
        // $path = '/pdf/' . $fileName;
        // $fileUrl = asset($path);
        $publicStorage = public_path('pdf/');
        if (!file_exists($publicStorage)) {
                mkdir($publicStorage, 0755, true);
            }
        $invoice = generateInvoice($orderId);
        $path = $invoice->getFile()->getPath();
        $invoiceName = $invoice->getFile()->getFilename();
        $url = asset('pdf/'. $invoiceName);
        $publicUrl = public_path('pdf/'. $invoiceName);
        $invoiceNameWeb = str_replace(' ', '%20', $invoice->getFile()->getFilename());
        $redirectUrl = asset('pdf/'. $invoiceNameWeb);

        // dd($invoice);

        return Inertia::location($redirectUrl);
        // return response()->json(['url' => $redirectUrl]);

    }

    public function testInvoice(){
        generateInvoice("4bfa88d4-9faf-3c08-96d6-af980e19774b");
    }
}
