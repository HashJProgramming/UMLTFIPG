<?php
include_once 'connection.php';

try {
    $id = $_POST['data_id'];
    $sql = "SELECT * FROM projects WHERE id = :id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $name = $result['name'];
    
    $sql = "DELETE FROM projects WHERE id = :id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    generate_logs('Removing project',  $name.' was removed');
    header('Location: ../project.php?type=success&message='.$name.' was removed successfully!');
} catch (\Throwable $th) {
    generate_logs('Removing project', $th);
    header('Location: ../project.php?type=error&message=Something went wrong, please try again');
}