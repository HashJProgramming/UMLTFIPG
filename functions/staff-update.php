<?php
include_once 'connection.php';
$id =  $_POST['data_id'];
$username =  $_POST['username'];
$password = $_POST['password'];

$checkSql = 'SELECT COUNT(*) FROM users WHERE username = :username AND id != :id';
$checkStmt = $db->prepare($checkSql);
$checkStmt->bindParam(':username', $username);
$checkStmt->bindParam(':id', $id);
$checkStmt->execute();
$count = $checkStmt->fetchColumn();

if ($count > 0) {
    header('Location: ../staff.php?type=error&message=Username already exists');
    exit;
}

$sql = 'UPDATE users SET username = :username, password = :password WHERE id = :id';
$stmt = $db->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
$stmt->bindParam(':id', $id);
$stmt->execute();
generate_logs('Staff Update', $_SESSION['username']);
header('Location: ../staff.php?type=success&message=Staff was updated successfully');
exit;
?>