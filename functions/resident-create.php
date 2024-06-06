<?php
include_once 'connection.php';

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$middlename = $_POST['middlename'];
$suffix = $_POST['suffix'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$sex = $_POST['sex'];
$birthdate = $_POST['birthdate'];
$purok = $_POST['purok'];
$barangay = $_POST['barangay'];
$fullname = $firstname.' '.$lastname.' '.$middlename.' '.$suffix;

$sql = "SELECT * 
FROM residents 
WHERE firstname = :firstname 
AND lastname = :lastname 
AND middlename = :middlename 
AND suffix = :suffix";

$stmt = $db->prepare($sql);
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':middlename', $middlename);
$stmt->bindParam(':suffix', $suffix);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    header('Location: ../residents.php?type=error&message='.$fullname.' is already exist');
    exit;
}

$target_dir = "resident-pictures/";
$target_file = $target_dir . $fullname . '.' . pathinfo($picture['name'], PATHINFO_EXTENSION);

$sql = "INSERT INTO residents (firstname, lastname, middlename, suffix, address, phone, sex, birthdate, purok, barangay) VALUES (:firstname, :lastname, :middlename, :suffix, :address, :phone, :sex, :birthdate, :purok, :barangay)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':middlename', $middlename);
$stmt->bindParam(':suffix', $suffix);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':sex', $sex);
$stmt->bindParam(':birthdate', $birthdate);
$stmt->bindParam(':purok', $purok);
$stmt->bindParam(':barangay', $barangay);
$stmt->execute();
generate_logs('Adding Customer', $fullname.'| New resident was added');
header('Location: ../residents.php?type=success&message=New resident was added successfully');
?>