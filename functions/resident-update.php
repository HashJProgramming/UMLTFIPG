<?php
include_once 'connection.php';
$id = $_POST['data_id'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$middlename = $_POST['middlename'];
$suffix = $_POST['suffix'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$sex = $_POST['sex'];
$birthdate = $_POST['birthdate'];
$picture = $_FILES['picture'];
$fullname = $firstname.' '.$lastname.' '.$middlename.' '.$suffix;


if (empty($picture['name'])) {
    $sql = "SELECT * FROM residents WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $target_file = $result['picture'];
}
    
$sql = "UPDATE residents 
SET firstname = :firstname, 
lastname = :lastname, 
middlename = :middlename, 
suffix = :suffix, 
address = :address, 
phone = :phone, 
sex = :sex, 
birthdate = :birthdate, 
picture = :picture 
WHERE id = :id";

$stmt = $db->prepare($sql);
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':middlename', $middlename);
$stmt->bindParam(':suffix', $suffix);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':sex', $sex);
$stmt->bindParam(':birthdate', $birthdate);
$stmt->bindParam(':picture', $target_file);
$stmt->bindParam(':id', $id);

if (isset($picture) && $picture['error'] == 0) {
    $target_dir = "resident-pictures/";
    $target_file = $target_dir . $fullname . '.' . pathinfo($picture['name'], PATHINFO_EXTENSION);
    if (move_uploaded_file($picture['tmp_name'], $target_file)) {
        $stmt->bindParam(':picture', $target_file);
    } else {
        header('Location: ../residents.php?type=error&message=Failed to upload picture');
        exit;
    }
} else {
    $stmt->bindParam(':picture', $target_file);
}

if ($stmt->execute()) {
    generate_logs('Updating Resident', $fullname.'| Resident information was updated');
    header('Location: ../residents.php?type=success&message=Resident information was updated successfully');
} else {
    header('Location: ../residents.php?type=error&message=Failed to update resident information');
}
?>
