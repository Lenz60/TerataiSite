<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme='autumn'>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="http://www.example.com/">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}"></script>
    <title>Invoice</title>
    @routes
</head>
<body class="body">
    <div class="Header">
        <div class="invoice-header">
            <h1>Invoice to:</h1>
            <h2>{{$name}}</h2>
            <p>{{$company}} Company</p>
            <div class="invoice-address">
                <p class="Address">{{$address}}</p>
                <p class="CountryEtc">{{$country}}, {{$region}}, {{$zip}}</p>
            </div>
        </div>
        <div class="invoice-number">
            <h1>INVOICE</h1>
            <div class="invoice-code">
                <h2 class="left">Invoice #</h2>
                <h2 class="right">{{$code}}</h2>
            </div>
            <div class="invoice-date">
                <h2 class="left">Date</h2>
                <?php
                    $dateObject = new DateTime($date);
                    $convertedDate = $dateObject->format('d-m-Y');
                ?>
                <h2 class="right">{{$convertedDate}}</h2>
            </div>
        </div>
        <div>
        </div>
    </div>
    <div class="product-details">
        <div class="product-table-container">
            <table class="product-table">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($furnitures as $furniture )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{$furniture['description']}}</td>
                        <td>{{$furniture['qty']}}</td>
                        <td>${{$furniture['price']}}</td>
                        <td>${{$furniture['total_price']}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" rowspan="3" style="border: none;"></td>
                        <td>Total Price</td>
                        <td>${{$totalPrice}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="payment-method">
        <div class="payment-info">
            <div class="payment-notice">
                <h1>Payment Info: </h1>
            </div>
            <div class="bank-info">
                <p>Account #: {{config('app.rekening')}}</p>
                <p>A/C Name: {{config('app.atas_nama')}}</p>
                <p>Bank Name: {{config('app.bank_rekening')}}</p>
            </div>
            <div class="confirmation">
                <p>After completing the payment, please send us the purchase receipt to confirm the payment on this WhatsApp number</p>
                <p class="whatsapp-number">{{config('app.nomor_konfirmasi')}}</p>
            </div>
        </div>
    </div>
</body>
</html>
<style>
.body {
    padding: 20px;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.Header{
    height: 13%;
}

.invoice-header {
    display: flex;
    float: left;
}

.invoice-header h1 {
    font-size: 1.0rem;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333646;
    margin-bottom: -10px;
}
.invoice-header h2 {
    font-size: 1.1rem;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333646;
    margin-bottom: -15px;
}
.invoice-header p{
    font-size: 1rem;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: grey;
    margin-bottom: -15px;
}
.invoice-address .Address{
    font-size: 1rem;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: grey;
    margin-bottom: -13px;
}
.invoice-address .CountryEtc{
    font-size: 1rem;
    font-family: DejaVu Sans, Tahoma, Geneva, Verdana, sans-serif;
    color: grey;
    margin-bottom: 10px;
}

.invoice-number{
    margin-top: -13.5%;
    float: right;
    height: fit-content;
    width:  auto;

}
.invoice-number h1{
    font-size: 3.5rem;
    font-weight: 400;
    font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    color: #333646;
    margin-bottom: -5%;
    height: fit-content;
}

.invoice-code .left{
    display: flex;
    font-size: 1.0rem;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333646;
    float: left;
    margin-bottom: -10px;
}

.invoice-code .right{
    display: flex;
    font-size: 1.0rem;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333646;
    margin-left: 60%;
    margin-bottom: -10px;
}

.invoice-date{
    height: 20%;
}

.invoice-date .left{
    display: flex;
    font-size: 1.0rem;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333646;
    float: left;
    margin-bottom: -10px;
}

.invoice-date .right{
    display: flex;
    font-size: 1.0rem;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333646;
    margin-left: 60%;
    margin-bottom: -10px;
}

.invoice-details {
    display: flex;
    flex-direction: row;
    font-size: 0.5rem;
}

.invoice-details h2 {
    margin-right: 8px;
}


.info-row {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    font-size: 0.875rem;
}

.label {
    margin-right: 10px;
}


.product-table th{
    padding: 8px;
    text-align: center;
    border: 1px solid #333646;
    background-color: #333646;
    color: #e2e8f0;
}

.product-title {
    text-align: left;
    padding: 4px 20px;
    background-color: #e2e8f0;
}

.product-table-container {
    overflow-x: auto;
}

.product-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #333646;
}

.product-table td {
    padding: 8px;
    text-align: left;
    border: 1px solid #333646;
}

.payment-method {
    width: 100%;
    margin: 12px;
    display: flex;
    flex-direction: column;
}



.payment-info {
    padding: 5px;
}

.payment-notice h1{
    display: flex;
    font-size: 1.3rem;
    color: #333646;
    margin-bottom: -10px;
}

.bank-info p{
    color: #333646;
    font-size: 1.0rem;
    margin-bottom: -10px;
}

.bank-label {
    font-weight: 600;
    margin-right: 10px;
}

.confirmation {
    margin-top: 5%;
    display: flex;
    flex-direction: column;
    color: #333646;
}

.whatsapp-number {
    font-weight: 700;
    color: #333646;
}

</style>
