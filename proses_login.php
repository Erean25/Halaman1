<?php
// Start session at the very beginning
session_start();

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

// Set charset to UTF-8
$conn->set_charset("utf8mb4");

// Validate POST data exists
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    $_SESSION['error'] = "Username dan password diperlukan!";
    header("Location: login.html");
    exit();
}

// Get and sanitize input
$user = trim($_POST['username']);
$pass = $_POST['password'];

// Validate input not empty
if (empty($user) || empty($pass)) {
    $_SESSION['error'] = "Username dan password tidak boleh kosong!";
    header("Location: login.html");
    exit();
}

// Use prepared statement to PREVENT SQL INJECTION
$sql = "SELECT id, username, email, password FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    $_SESSION['error'] = "Database error!";
    header("Location: login.html");
    exit();
}

// Bind parameter (string type)
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Check password using password_verify (SECURE)
    // NOTE: Your current passwords are hashed with MD5
    // For now, we'll check both MD5 and password_verify for compatibility
    $password_hash = $row['password'];
    
    // Try password_verify first (recommended method)
    if (password_verify($pass, $password_hash)) {
        // Password correct - Login successful
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['login_time'] = time();
        
        unset($_SESSION['error']);
        
        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } 
    // Fallback: Check if password is MD5 (for backward compatibility with existing data)
    else if (md5($pass) === $password_hash) {
        // Password correct - Login successful
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['login_time'] = time();
        
        unset($_SESSION['error']);
        
        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } 
    else {
        // Password incorrect
        $_SESSION['error'] = "Username atau Password salah!";
        header("Location: login.html");
        exit();
    }
} else {
    // User not found
    $_SESSION['error'] = "Username atau Password salah!";
    header("Location: login.html");
    exit();
}

$stmt->close();
$conn->close();
?>
