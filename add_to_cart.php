<?php
session_start();
include '../includes/db.php'; // Database connection

// 1. Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); //
    exit(); //
}

$user_id = $_SESSION['user_id']; //

// 2. Safely get the ID from the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id']; //
} else {
    // If no ID is found, send them back to the shop
    header("Location: ../index.php");
    exit();
}

$quantity = 1; //

// 3. Check if the product is already in the cart for this user
$stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?"); //
$stmt->bind_param("ii", $user_id, $product_id); //
$stmt->execute(); //
$result = $stmt->get_result(); //
$cart_item = $result->fetch_assoc(); //

if ($cart_item) {
    // 4. If it exists, increase the quantity
    $new_quantity = $cart_item['quantity'] + 1; //
    $update_stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?"); //
    $update_stmt->bind_param("ii", $new_quantity, $cart_item['id']); //
    $update_stmt->execute(); //
} else {
    // 5. If it's new, insert it into the cart table
    $insert_stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)"); //
    $insert_stmt->bind_param("iii", $user_id, $product_id, $quantity); //
    $insert_stmt->execute(); //
}

// 6. Redirect to cart.php to see the items
header("Location: cart.php"); //
exit(); //
?>