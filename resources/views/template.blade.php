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
            <h2>Mr.John Doe</h2>
            <div class="invoice-address">
                <p class="Address">Address, </p>
                <p class="CountryEtc">Country,Region,Zip</p>
            </div>
        </div>
        <div class="invoice-number">
            <h1>INVOICE</h1>
            <div class="invoice-code">
                <h2 class="left">Invoice #</h2>
                <h2 class="right">121212</h2>
            </div>
            <div class="invoice-date">
                <h2 class="left">Date</h2>
                <h2 class="right">10/02/2024</h2>
            </div>
        </div>
        <div>
        </div>
    </div>
    <!-- <div class="customer-details">
        <div class="customer-title">
            <p>Customer Details</p>
        </div>
        <div class="customer-info">
            <div style="width: 30%;">
                <div class="info-row">
                    <p class="label">Name :  John</p>
                </div>
                <div class="info-row">
                    <p class="label">Company :  John</p>
                </div>
                <div class="info-row">
                    <p class="label">Email  :  John</p>
                </div>
                <div class="info-row">
                    <p class="label">Phone Number :  John</p>
                </div>
            </div>
            <div style="width: 30%;">
                <div class="info-row">
                    <p class="label">Address :  John</p>
                </div>
                <div class="info-row">
                    <p class="label">Country :  John</p>
                </div>
                <div class="info-row">
                    <p class="label">Region  :  John</p>
                </div>
                <div class="info-row">
                    <p class="label">Zip code :  John</p>
                </div>
            </div>
        </div>
    </div> -->
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
                    <tr>
                        <td>asd</td>
                        <td>asd</td>
                        <td>asd</td>
                        <td>asd</td>
                        <td>asd</td>
                    </tr>
                    <tr>
                        <td colspan="3" rowspan="3" style="border: none;"></td>
                        <td>Total Price</td>
                        <td>Rp10000</td>
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
                <p>Account #: 123456678</p>
                <p>A/C Name: Bpk Teratai</p>
                <p>Bank Name: BRI</p>
            </div>
            <div class="confirmation">
                <p>After completing the payment, please send us the purchase receipt to confirm the payment on this WhatsApp number</p>
                <p class="whatsapp-number">+628348793234</p>
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
    flex-direction: column;
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
    margin-bottom: -10px;
}
.invoice-address .Address{
    font-size: 1rem;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: grey;
    margin-bottom: -13px;
}
.invoice-address .CountryEtc{
    font-size: 1rem;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: grey;
    margin-bottom: 10px;
}

.invoice-number{
    margin-top: -13.5%;
    margin-left: 40%;
    height: fit-content;

}
.invoice-number h1{
    display: flex;
    font-size: 3.5rem;
    font-weight: 400;
    font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    color: #333646;
    margin-bottom: -5%;
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
    margin-left: 80%;
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
    margin-left: 76%;
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
