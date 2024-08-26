<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Session;
use App\Models\Furniture;
use App\Models\OrderItems;
use App\Models\OrdersInfo;
use Illuminate\Http\Request;
use App\Models\OrdersPayment;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function getIndex(){
        $cart = DB::table('cart')
        ->join('furniture', 'cart.furniture_id', '=', 'furniture.uuid')
        ->join('users', 'cart.user_id', '=', 'users.uuid')
        ->select('cart.id', 'cart.user_id', 'cart.furniture_id','cart.preorder','furniture.image','furniture.description','furniture.color','furniture.wood_type','furniture.price', 'cart.qty','cart.total_price' )
        ->orderBy('cart.created_at', 'desc')
        ->get();
        // dd($cart);
        // return Inertia::render('Cart');
        //Add cart to the sessionstorage named cart
        // $carts = $cart;
        // $request->session()->put('cart', $carts);
        return Inertia::render('Cart', ['carts' => $cart]);
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
        // dd($request->info);
        $Whatsapp = Session::first();
        $SesId = $Whatsapp->sessionId;
        // dd($Whatsapp);
        $client = new \GuzzleHttp\Client();

        // dd($status);
        // dd($SesId);
        $user = Auth::user();
        $info = $request->info;
        $carts = $request->cart;
        $orderId = fake()->uuid;
        $totalOrderPrice = $request->totalPrice;
        $track_code = rand(100000,999999);
        // dd($user->uuid);
        //Generate PDF function here
        Order::create([
            'id' => $orderId,
            'user_id'=> $user->uuid,
            'total_price' => $totalOrderPrice,
            'track_code' => $track_code,
            'invoice_status' => 'Pending',
        ]);
        $generatedInvoice = $this->generateInvoice($track_code, $orderId, $info, $carts);
        // $generatedInvoice->getFile()->getPath();
            // dd($generatedInvoice->getFile()->getPathname());
            // $filePath = $generatedInvoice->getFile()->getPath();
            // Path to the PDF file
        $pdfPath = public_path('pdf/' . $generatedInvoice->getFile()->getFilename());

        // Read the file and encode it to base64
        $pdfData = base64_encode(file_get_contents($pdfPath));
        $invoiceName = str_replace(' ', '%20', $generatedInvoice->getFile()->getFilename());
        $url = asset('pdf/'. $invoiceName);
        $updateOrder = Order::find($orderId);
        if($generatedInvoice->getStatusCode() == 200){
            //* Create method to send the pdf to whatsapp
            $response = $client->request('GET','http://localhost:3000/sessions/',['headers'=> [
                'x-api-key'  => 'testAPI',
            ]]);
            $body = $response->getBody()->getContents();
            $data = json_decode($body,true);
            $status = $data[0]['status'];
            if($status == "connected"){
                $response = $client->request('POST','http://localhost:3000/'.$SesId.'/messages/send',[
                    'headers' => ['x-api-key' => 'testAPI'],
                    'json'=> [
                        'jid' => '6283840765667@s.whatsapp.net',
                        'type' => 'number',
                        'message' => ['document' => ['url' => $url,],
                                    "mimetype" => 'application/pdf',
                                    "caption" => "Here is your invoice of your order at Teratai Furniture",
                                    "fileName" => $generatedInvoice->getFile()->getFilename()],
                    ],
                ]);
                // dd($response->getBody()->getContents());
            }
            if($response->getStatusCode() == 200){
                $updateOrder->invoice_status = 'Sent';
                $updateOrder->save();
            }else {
                $updateOrder->invoice_status = 'Generated';
                $updateOrder->save();
            }
        }else{
            $updateOrder->invoice_status = 'Failed to generate';
            $updateOrder->save();
        }
        foreach($carts as $cart){

            // dd($cart['total_price']);
            if($cart['preorder']==0){
                $preorder = 'false';
            }else{
                $preorder = 'true';
            }
            $orderItemsId = fake()->uuid;

            OrderItems::create([
                'id'  => $orderItemsId,
                'order_id' => $orderId,
                'furniture_id'=>$cart['furniture_id'],
                'preorder'=>$preorder,
                'price' => $cart['price'],
                'qty' => $cart['qty'],
                'total_price' => $cart['total_price'],
            ]);

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

    public function generateInvoice($code,$orderId, $info, $carts){
        // dd(resource_path('Pages/Invoice/Template.vue'));
        // dd($carts);
        $user = Auth::user();
        $orders = Order::get()->where('id', '=', $orderId)->first();
        $path = public_path(). '/pdf/' . $user->name .'[Invoice-'. $code . ']' . '.pdf';
        $css = file_get_contents(resource_path('css/app.css'));
        // dd($css);
        // $template =resource_path()->get('Pages/Invoice/Template.vue');
        $furniture = Furniture::get();
        $data  = [
            'title' => 'Invoice',
            'code' => $code,
            'name' => $info['name'],
            'address'=> $info['address'],
            'country' => $info['country'],
            'region' => $info['region'],
            'zip' => $info['zip'],
            'date' => $orders->created_at,
            'furnitures' => $carts,
            'totalPrice' => $orders->total_price
        ];
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
        $pdf = PDF::loadView('template', $data);
        // $pdf = PDF::loadFile(resource_path('Pages/Invoice/Template.vue'),$data);
        $setCss = $pdf->getCss($css);
        $pdf->setCss($setCss);
        $pdf->setPaper('A4', 'portrait');
        // return $pdf->stream();
        $pdf->save($path);
        return response()->download($path);
        // return $pdf->download('invoice.pdf');
    }

    public function pdf(){
        return view('template1');
    }
}
