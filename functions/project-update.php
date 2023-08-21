<?php
include_once 'connection.php';
$id = $_POST['data_id'];
$name = $_POST['name'];
$description = $_POST['description'];

$sql = "SELECT * 
FROM projects 
WHERE name = :name AND id != :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':id', $id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    header('Location: ../project.php?type=error&message='.$name.' is already exist');
    exit;
}

$sql = "UPDATE projects SET name = :name, description = :description WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':id', $id);
$stmt->execute();

header('Location: ../project.php?type=success&message=Project was updated successfully');

?>
