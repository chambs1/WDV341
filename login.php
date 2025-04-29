<?php
session_start();
$errorMsg = "";

// Include your PDO connection
require_once "db-Connect.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize user input
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    // Prepare and execute SQL query using PDO
    $sql = "SELECT * FROM event_user WHERE event_user_name = :username AND event_user_password = :password";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $user);
    $stmt->bindParam(':password', $pass);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        // Login success
        $_SESSION['validUser'] = "yes";
        $_SESSION['username'] = $user;
        header("Location: home.php");
        exit();
    } else {
        // Login failed
        $errorMsg = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f1f1;
        }
        .login-container {
            max-width: 400px;
            margin: 60px auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-top: 15px;
            color: #444;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            margin-top: 20px;
            padding: 10px;
            background: #0077cc;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #005fa3;
        }
        .error-message {
            color: #c00;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Event Admin Login</h2>
        <?php if ($errorMsg) echo "<p class='error-message'>$errorMsg</p>"; ?>
        <form method="post" action="login.php">
            <label>Username:</label>
            <input type="text" name="username" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
