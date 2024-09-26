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
use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ValidatedInput;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
        // return Inertia::render('Cart', ['carts' => $cart]);
        return Inertia::render('Cart', ['carts' => $cart]);
    }

    public function index(Request $request){
        //! I̶ d̶e̶c̶i̶d̶e̶d̶ t̶o̶ m̶a̶k̶e̶ t̶h̶e̶ c̶h̶e̶c̶k̶o̶u̶t̶ i̶s̶ c̶a̶n̶ b̶e̶ g̶e̶t̶ b̶y̶ d̶e̶f̶a̶u̶l̶t̶ r̶o̶u̶t̶e̶ t̶o̶ e̶n̶a̶b̶l̶e̶ v̶a̶l̶i̶d̶a̶t̶e̶ i̶n̶p̶u̶t̶
        //! c̶h̶a̶n̶g̶e̶ t̶h̶e̶ r̶e̶q̶u̶e̶s̶t̶s̶ g̶e̶t̶t̶e̶d̶ f̶r̶o̶m̶ c̶a̶r̶t̶ p̶o̶s̶t̶ t̶o̶ a̶ q̶u̶e̶r̶y̶ i̶n̶s̶t̶e̶a̶d̶ o̶f̶ r̶e̶q̶u̶e̶s̶t̶ p̶a̶r̶a̶m̶e̶t̶e̶r̶s̶
        //v Connection check is done
        //? Maybe refactor the code to make it more readable
        $getCart = DB::table('cart')
        ->join('furniture', 'cart.furniture_id', '=', 'furniture.uuid')
        ->join('users', 'cart.user_id', '=', 'users.uuid')
        ->select('cart.id', 'cart.user_id', 'cart.furniture_id','cart.preorder','furniture.image','furniture.description','furniture.color','furniture.wood_type','furniture.price', 'cart.qty','cart.total_price' )
        ->orderBy('cart.created_at', 'desc')
        ->get();
        // dd($cart);
        $user = Auth::user();
        $cartCounts = DB::table('cart')->where('user_id', $user->uuid)->count();
        if($cartCounts <= 0){
            return redirect()->route('cart.index');
        }
        // dd($cart);
        //Foreach the cart and then sum all the total price from cart
        $getTotalPrice = 0;
        foreach ($getCart as $carts){
            $getTotalPrice += $carts->total_price * $carts->qty;
        }
        // dd($totalPrice);

        if($request->cart != null){
            $cart = $request->cart;
            $totalPrice = $request->totalPrice;
        }
        $cart  = $getCart;
        $totalPrice = $getTotalPrice;
        // dd($cart);

        return Inertia::render('Checkout/Checkout',['carts' => $cart, 'totalPrice' => $totalPrice, 'cartCounts' => $cartCounts]);
    }

    private function validateInput(Request $request){
        // dd($request->info['name']);
        $info = $request->info;
        // dd($info);
        return Validator::make($info, [
            'name' => 'required',
            'company' => 'required',
            'email' => 'required',
            'phoneNumber' => 'required',
            'address' => 'required',
            'country' => 'required',
            'region' => 'required',
            'zip' => 'required',
        ]);
        // return $validator;
        // return $info->validate([
        //     'name' => 'required',
        //     'company' => 'required',
        //     'email' => 'required',
        //     'phoneNumber' => 'required',
        //     'address' => 'required',
        //     'country' => 'required',
        //     'region' => 'required',
        //     'zip' => 'required',
        // ]);
    }

    public function create(Request $request){
        // dd($request->all());
        $validate = $this->validateInput($request);
        // dd($validate);
        if ($validate->fails()) {
        return back()->withErrors($validate)->withInput();
        }


        // dd($mergeAddress);

        // dd($request->info);
        $whatsapp = Session::first();
        if($whatsapp){
            $sessionId = $whatsapp->sessionId;
        }else{
            $sessionId = null;
        }
        // dd($whatsapp);
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
        // dd($generatedInvoice);

        $invoiceName = str_replace(' ', '%20', $generatedInvoice->getFile()->getFilename());
        $url = asset('pdf/'. $invoiceName);
        $updateOrder = Order::find($orderId);
        if(!$sessionId){
            $updateOrder->invoice_status = 'Generated';
            $updateOrder->save();
            $this->addOrderDetails($orderId, $carts, $info);
            $this->handleCartClear($updateOrder, $carts);
            return;
        }


        try{

            $response = $client->request('GET','http://localhost:3000/sessions/', ['headers' => ['x-api-key' => 'testAPI']]);
            if($response){
                $clientStatus = true;
                $body = $response->getBody()->getContents();
                $data = json_decode($body,true);
                if(count($data)<=1){
                    $updateOrder->invoice_status = 'Generated';
                    $updateOrder->save();
                    $this->addOrderDetails($orderId, $carts, $info);
                    $this->handleCartClear($updateOrder, $carts);
                    return;
                }

                $status = $data[0]['status'];
                if($status !== 'connected' || $status != 'AUTHENTICATED' || $clientStatus == false){
                    $updateOrder->invoice_status = 'Generated';
                    $updateOrder->save();
                    $this->addOrderDetails($orderId, $carts, $info);
                    $this->handleCartClear($updateOrder, $carts);
                    return;
                }

                $response = $client->request('POST', 'http://localhost:3000/' . $sessionId . '/messages/send', [
                    'headers' => ['x-api-key' => 'testAPI'],
                    'json' => [
                        //! Change the number to customer number
                        'jid' => '6283840765667@s.whatsapp.net',
                        'type' => 'number',
                        'message' => [
                            'document' => ['url' => $url],
                            'mimetype' => 'application/pdf',
                            'caption' => "Here is your invoice of your order at Teratai Furniture",
                            'fileName' => $generatedInvoice->getFile()->getFilename()
                        ],
                    ],
                ]);
                if ($response->getStatusCode() == 200) {
                    $updateOrder->invoice_status = 'Sent';
                } else {
                    $updateOrder->invoice_status = 'Generated';
                }
            }
        }catch(Exception $e){
            //! Return this to a message error if server is not online
            //! or add the order anyway but set the invoice status to generated
            // dd($e->getCode());
            $updateOrder->invoice_status = 'Generated';
        }
        // $clientStatus=true;
        // return redirect()->route('cart.index');
        $updateOrder->save();
        $this->addOrderDetails($orderId, $carts, $info);
        return $this->handleCartClear($updateOrder, $carts);



    }

    private function addOrderDetails($orderId, $carts, $info){
        $mergedAddress = $info['address'] . ', ' . $info['address2'];
        foreach ($carts as $cart) {
            $preorder = $cart['preorder'] == 0 ? 'false' : 'true';
            $orderItemsId = fake()->uuid;

            // Add OrderItems
            OrderItems::create([
                'id'  => $orderItemsId,
                'order_id' => $orderId,
                'furniture_id'=>$cart['furniture_id'],
                'preorder'=>$preorder,
                'price' => $cart['price'],
                'qty' => $cart['qty'],
                'total_price' => $cart['total_price'],
            ]);

            // Add OrderItemsProduction
                OrderItemsProduction::create([
                'order_items_id' => $orderItemsId,
                'production_status' => 'In Production',
            ]);
        }

        // Add OrdersPayment
        OrdersPayment::create([
            'order_id' => $orderId,
            'payment_method' => 'Pending',
            'payment_status' => 'Pending',
        ]);

        // Add OrdersInfo
        OrdersInfo::create([
            'order_id' => $orderId,
            'name'=> $info['name'],
            'company' => $info['company'],
            'email' => $info['email'],
            'phone_number' => $info['phoneNumber'],
            'address' => $mergedAddress,
            'country' => $info['country'],
            'region' => $info['region'],
            'zip' => $info['zip'],
        ]);
    }

    private function handleCartClear($updateOrder, $carts){
        $clearCart = $this->deleteCart($carts);
        if (!$clearCart) {
            return;
        }
        // dd($updateOrder->invoice_status);
        if ($updateOrder->invoice_status == 'Generated') {
            return redirect()->route('cart.index')->with('message', 'checkout:401');
        } else {
            return redirect()->route('cart.index')->with('message', 'checkout:200');
        }
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
        $data  = [
            'title' => 'Invoice',
            'code' => $code,
            'name' => $info['name'],
            'company' => $info['company'],
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
