<?php
include_once 'connection.php';
$username =  $_POST['username'];
$password = $_POST['password'];

$checkSql = 'SELECT COUNT(*) FROM users WHERE username = :username';
$checkStmt = $db->prepare($checkSql);
$checkStmt->bindParam(':username', $username);
$checkStmt->execute();
$count = $checkStmt->fetchColumn();

if ($count > 0) {
    header('Location: ../staff.php?type=error&message=Username already exists');
    exit;
}
$sql = 'INSERT INTO users (`username`, `password`, `type`) VALUES (:username, :password, "Staff")';
$stmt = $db->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
$stmt->execute();

generate_logs('Staff Adding', $_SESSION['username']);
header('Location: ../staff.php?type=success&message=Staff was added successfully');

?>