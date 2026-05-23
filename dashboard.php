<?php
session_start();

// Check if user logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard - Erean Website</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .user-info {
            background-color: #e8f4f8;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .user-info p {
            margin: 10px 0;
            font-size: 16px;
        }
        .logout-btn {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 10px;
            background-color: #d9534f;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            font-size: 16px;
        }
        .logout-btn:hover {
            background-color: #c9302c;
        }
        .nav-links {
            text-align: center;
            margin-top: 20px;
        }
        .nav-links a {
            margin: 0 10px;
            text-decoration: none;
            color: #0275d8;
        }
        .nav-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Dashboard</h1>
        
        <div class="user-info">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        </div>

        <p style="text-align: center;">Anda sudah login dengan berjaya!</p>

        <button class="logout-btn" onclick="logout()">Logout</button>

        <div class="nav-links">
            <a href="page1.html">Ke Page 1</a>
            <a href="login.html">Kembali ke Login</a>
        </div>
    </div>

    <script>
        function logout() {
            window.location.href = 'logout.php';
        }
    </script>
</body>
</html>
