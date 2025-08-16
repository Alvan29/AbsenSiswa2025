<?php
include 'koneksi.php';
session_start();

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('username atau password Anda salah. Silakan coba lagi!')</script>";
    }
}
