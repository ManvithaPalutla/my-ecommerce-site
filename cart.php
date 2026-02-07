<?php
session_start();
include '../includes/db.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$user_id = $_SESSION['user_id'];

// Logic: Update Quantity
if (isset($_POST['update_quantity'])) {
    $cart_id = $_POST['cart_id'];
    $qty = (int)$_POST['quantity'];
    mysqli_query($conn, "UPDATE cart SET quantity = $qty WHERE id = $cart_id AND user_id = $user_id");
}

// Logic: Remove
if (isset($_POST['remove_from_cart'])) {
    $cart_id = $_POST['cart_id'];
    mysqli_query($conn, "DELETE FROM cart WHERE id = $cart_id AND user_id = $user_id");
}

$query = "SELECT cart.id AS cart_id, products.name, products.price, products.image, cart.quantity 
          FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = $user_id";
$result = mysqli_query($conn, $query);
$cart_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 20px; }
        .cart-wrapper { max-width: 900px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        
        .cart-item { 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            padding: 15px; 
            border-bottom: 1px solid #eee; 
            margin-bottom: 10px;
        }

        /* IMAGE SIZE FIX */
        .item-details { display: flex; align-items: center; gap: 20px; }
        .item-details img { width: 80px; height: 80px; object-fit: contain; background: #fafafa; border-radius: 5px; }
        
        .controls-group { display: flex; align-items: center; gap: 10px; }
        .qty-input { width: 50px; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        
        .btn { padding: 8px 15px; border-radius: 5px; border: none; cursor: pointer; font-weight: bold; color: white; text-decoration: none; }
        .btn-blue { background: #007bff; }
        .btn-remove { background: #f8f9fa; color: #dc3545; border: 1px solid #ddd; }
        .btn-green { background: #28a745; padding: 12px 25px; }

        .total-banner { text-align: center; font-size: 24px; font-weight: bold; margin: 30px 0; color: #007bff; }
        .footer-row { display: flex; justify-content: space-between; }
    </style>
</head>
<body>
    <div class="cart-wrapper">
        <h2 style="text-align:center;">Your Cart</h2>
        <?php foreach ($cart_items as $item): 
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
        ?>
            <div class="cart-item">
                <div class="item-details">
                    <img src="../images/<?= htmlspecialchars($item['image']); ?>">
                    <div>
                        <strong><?= htmlspecialchars($item['name']); ?></strong><br>
                        <span style="color:#666;">$<?= number_format($item['price'], 2); ?></span>
                    </div>
                </div>
                <form method="POST" class="controls-group">
                    <input type="hidden" name="cart_id" value="<?= $item['cart_id']; ?>">
                    <input type="number" name="quantity" value="<?= $item['quantity']; ?>" class="qty-input">
                    <button type="submit" name="update_quantity" class="btn btn-blue">Update</button>
                    <button type="submit" name="remove_from_cart" class="btn btn-remove">Remove</button>
                </form>
            </div>
        <?php endforeach; ?>

        <div class="total-banner">Total: $<?= number_format($total, 2); ?></div>

        <div class="footer-row">
            <a href="../index.php" class="btn btn-green">Back to Shop</a>
            <a href="checkout.php" class="btn btn-green">Proceed to Checkout</a>
        </div>
    </div>
</body>
</html>