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
    <div class="invoice-header">
        <h1>Invoice</h1>
        <div class="invoice-details">
            <h2>No: TRK2232  Date: date</h2>
        </div>
    </div>
    <div class="customer-details">
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
    </div>
    <div class="product-details">
        <div class="product-title">
            <p>Product Details</p>
        </div>
        <div class="product-table-container">
            <table class="product-table">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Wood type</th>
                    <th>Width</th>
                    <th>Length</th>
                    <th>Height</th>
                    <th>Color</th>
                    <th>Price</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>asd</td>
                        <td>asd</td>
                        <td>asd</td>
                        <td>asd</td>
                        <td>asd</td>
                        <td>asd</td>
                        <td>asd</td>
                        <td>asd</td>
                        <td>asd</td>
                        <td>asd</td>
                    </tr>
                    <tr>
                        <td colspan="9">Total Price</td>
                        <td colspan="1">Rp10000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="payment-method">
        <div class="payment-title">
            <p>Payment Method</p>
        </div>
        <div class="payment-info">
            <div class="payment-notice">
                <p>For your convenience, you may deposit the final amount at one of our banks</p>
            </div>
            <div class="bank-info">
                <p class="bank-label">BRI</p>
                <p>John Doe</p>
            </div>
            <div class="bank-info">
                <p class="bank-label">BCA</p>
                <p>John Doe</p>
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
}

.invoice-header {
    display: flex;
    flex-direction: column;
}

.invoice-header h1 {
    font-size: 1.4rem;
    font-family: serif;
    color: black;
}

.invoice-details {
    display: flex;
    flex-direction: row;
    font-size: 0.5rem;
}

.invoice-details h2 {
    margin-right: 8px;
}

.customer-details {
    width: 100%;
    margin: 12px;
    display: flex;
    flex-direction: column;
    background-color: #f1f5f9;
    border: 2px solid #475569;
    border-radius: 4px;
}

.customer-title {
    text-align: left;
    padding: 4px 20px;
    background-color: #e2e8f0;
}

.customer-info {
    padding: 10px;
    display: flex;
    flex-direction: row;
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

.product-details {
    margin: 12px;
    border: 2px solid #475569;
    border-radius: 4px;
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
    border: 1px solid #475569;
}

.product-table th, .product-table td {
    padding: 8px;
    text-align: left;
    border: 1px solid #475569;
}

.payment-method {
    width: 100%;
    margin: 12px;
    display: flex;
    flex-direction: column;
    background-color: #f1f5f9;
    border: 2px solid #475569;
    border-radius: 4px;
}

.payment-title {
    text-align: left;
    padding: 4px 20px;
    background-color: #e2e8f0;
}

.payment-info {
    padding: 12px;
}

.payment-notice {
    padding-bottom: 8px;
}

.bank-info {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    font-size: 0.875rem;
}

.bank-label {
    font-weight: 600;
    margin-right: 10px;
}

.confirmation {
    display: flex;
    flex-direction: column;
}

.whatsapp-number {
    font-weight: 600;
}

</style>
