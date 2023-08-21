<?php
include_once 'connection.php';

$name = $_POST['name'];
$description = $_POST['description'];

$sql = "SELECT * 
FROM projects 
WHERE name = :name";
$stmt = $db->prepare($sql);
$stmt->bindParam(':name', $name);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    header('Location: ../project.php?type=error&message='.$name.' is already exist');
    exit;
}

$sql = "INSERT INTO projects (name, description) VALUES (:name, :description)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':description', $description);
$stmt->execute();

header('Location: ../project.php?type=success&message=New project was added successfully');

?>