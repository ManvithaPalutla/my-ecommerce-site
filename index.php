<?php
session_start();
include 'includes/db.php'; 

// Fetch products using MySQLi
$result = mysqli_query($conn, "SELECT * FROM products");
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop | Premium Stationery</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; }
        
        /* Professional Header */
        header { background: #1a1a1a; color: white; padding: 15px 0; position: sticky; top: 0; z-index: 1000; }
        .header-container { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        nav a { color: white; text-decoration: none; margin-left: 20px; font-weight: 500; }
        
        .main-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        h2 { border-left: 5px solid #28a745; padding-left: 15px; margin-bottom: 30px; }

        /* Grid Layout */
        .product-list { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); 
            gap: 25px; 
        }

        /* Card Alignment Fix */
        .product { 
            background: white; 
            border-radius: 12px; 
            padding: 20px; 
            display: flex; 
            flex-direction: column; 
            justify-content: space-between; 
            text-align: center; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            height: 400px; /* Forces uniform card height */
        }

        .product-image { 
            height: 180px; 
            object-fit: contain; /* Prevents stretching */
            margin-bottom: 15px; 
        }

        .add-to-cart-button { 
            background-color: #28a745; 
            color: white; 
            padding: 12px; 
            border-radius: 8px; 
            text-decoration: none; 
            font-weight: bold; 
            transition: 0.3s;
        }
        .add-to-cart-button:hover { background-color: #218838; }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>My Shop</h1>
            <nav>
                <a href="index.php">Home</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="pages/cart.php">Cart 🛒</a>
                    <form method="POST" style="display: inline;"><button type="submit" name="logout" style="background:none; border:1px solid white; color:white; padding:5px 10px; cursor:pointer; margin-left:15px; border-radius:4px;">Logout</button></form>
                <?php else: ?>
                    <a href="pages/login.php">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <div class="main-container">
        <h2>Featured Products</h2>
        <div class="product-list">
            <?php foreach ($products as $product) : ?>
                <div class="product">
                    <img src="images/<?= htmlspecialchars($product['image']); ?>" class="product-image">
                    <div>
                        <h3><?= htmlspecialchars($product['name']); ?></h3>
                        <p style="color:#28a745; font-weight:bold;">$<?= number_format($product['price'], 2); ?></p>
                    </div>
                    <a href="pages/add_to_cart.php?id=<?= $product['id']; ?>" class="add-to-cart-button">Add to Cart</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>