<?php
include_once 'connection.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['type'] = $user['type'];
    $_SESSION['id'] = $user['id'];
    
    generate_logs('Login', $username.'| Logged in');
    header('location: ../index.php');
} else {
    header('location: ../login.php?type=error&message=Wrong username or password');
}
