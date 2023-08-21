<?php
include_once 'connection.php';
$project_id =  $_POST['data_id'];
$fund = $_POST['fund'];
$status = $_POST['status'];

$sql = 'INSERT INTO project_fund (project_id, fund, status) VALUES (:project_id, :fund, :status)';
$stmt = $db->prepare($sql);
$stmt->bindParam(':project_id', $project_id);
$stmt->bindParam(':fund', $fund);
$stmt->bindParam(':status', $status);
$stmt->execute();

generate_logs('Added a fund to a project', $_SESSION['username']);
header('Location: ../project.php?type=success&message=Fund was added successfully');

?>