<?php
session_start();
include '../includes/db.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // In a real app, you would save this to an 'orders' table here.
    // For now, we just clear the cart so it's empty for next time.
    mysqli_query($conn, "DELETE FROM cart WHERE user_id = $user_id");
    
    header("Location: order_success.php");
    exit();
}
?>