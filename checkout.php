<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Secure Payment</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .payment-card { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 400px; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        .btn-pay { width: 100%; background: #28a745; color: white; padding: 15px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 16px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="payment-card">
        <h2 style="text-align:center;">Payment Details</h2>
        <form action="order_success.php" method="POST">
            <label>Cardholder Name</label>
            <input type="text" placeholder="Full Name" required>
            <label>Card Number</label>
            <input type="text" placeholder="0000 0000 0000 0000" maxlength="16" required>
            <div style="display:flex; gap:10px;">
                <input type="text" placeholder="MM/YY" required>
                <input type="password" placeholder="CVV" maxlength="3" required>
            </div>
            <button type="submit" class="btn-pay">Pay & Confirm Order</button>
        </form>
    </div>
</body>
</html>