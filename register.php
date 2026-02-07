<?php
include('../includes/db.php');
session_start();

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $role = 'user'; 

    // Correct MySQLi check for existing email
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Email already registered!";
    } else {
        // Correct MySQLi insert
        $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $password, $role);
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $conn->insert_id;
            header("Location: ../index.php");
            exit();
        } else {
            $error_message = "Registration failed.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .register-container { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.05); width: 100%; max-width: 400px; text-align: center; }
        h2 { margin-bottom: 20px; color: #333; }
        label { display: block; text-align: left; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background-color: #28a745; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        button:hover { background-color: #218838; }
        .error-message { color: #e74c3c; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <form method="POST">
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <button type="submit" name="register">Register</button>
        </form>
        <?php if (isset($error_message)): ?>
            <p class="error-message"><?= htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>