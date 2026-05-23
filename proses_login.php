<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "halaman1_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get username and password from form
$user = $_POST['username'];
$pass = $_POST['password'];

// Prevent SQL injection
$user = $conn->real_escape_string($user);
$pass = $conn->real_escape_string($pass);

// Query to find user
$sql = "SELECT * FROM users WHERE username = '$user' AND password = MD5('$pass')";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Login successful
    session_start();
    $row = $result->fetch_assoc();
    $_SESSION['username'] = $row['username'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['id'] = $row['id'];
    
    // Redirect to dashboard
    header("Location: dashboard.php");
    exit();
} else {
    // Login failed
    session_start();
    $_SESSION['error'] = "Username atau Password salah!";
    header("Location: login.html");
    exit();
}

$conn->close();
?>
