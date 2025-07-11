<?php
session_start();

// Sesuaikan path ke koneksi.php
require_once __DIR__ . '/config/koneksi.php'; // Jika config sejajar dengan proses_login
// atau

// Debug koneksi
if (!isset($conn) || $conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        die("Error prepare statement: " . $conn->error);
    }
    
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        if(password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit();
        }
    }
    
    // Jika login gagal
    header("Location: index.php?error=1");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>