<?php
include_once 'connection.php';

try {
    $id = $_POST['data_id'];
    $sql = "SELECT * FROM residents WHERE id = :id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $fullname = $result['firstname'].' '.$result['lastname'].' '.$result['middlename'].' '.$result['suffix'];
    
    $sql = "DELETE FROM residents WHERE id = :id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    generate_logs('Removing Resident',  $fullname.' was removed');
    header('Location: ../residents.php?type=success&message='.$fullname.' was removed successfully!');
} catch (\Throwable $th) {
    generate_logs('Removing StaResidentff', $th);
    header('Location: ../residents.php?type=error&message=Something went wrong, please try again');
}