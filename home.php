<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['validUser']) || $_SESSION['validUser'] !== "yes") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Admin Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f1f1;
        }
        .home-container {
            max-width: 500px;
            margin: 60px auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            text-align: center;
        }
        h2 {
            color: #333;
        }
        a.logout-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 25px;
            background: #c00;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
        }
        a.logout-btn:hover {
            background: #900;
        }
    </style>
</head>
<body>
    <div class="home-container">
        <h2>Welcome <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>You are successfully logged in.</p>
        <a class="logout-btn" href="logout.php">Logout</a>
    </div>
</body>
</html>
