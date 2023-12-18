<?php
include_once 'connection.php';
$id =  $_POST['data_id'];

$sql = 'DELETE FROM users WHERE id = :id';
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
generate_logs('Staff Remove', $_SESSION['username']);
header('Location: ../staff.php?type=success&message=Staff was removed successfully');
exit;
?>