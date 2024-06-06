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
$purok = $_POST['purok'];
$barangay = $_POST['barangay'];
$resident_status = $_POST['resident_status'];
$fullname = $firstname.' '.$lastname.' '.$middlename.' '.$suffix;

    
$sql = "UPDATE residents 
SET `firstname` = :firstname, 
`lastname` = :lastname, 
`middlename` = :middlename, 
`suffix` = :suffix, 
`address` = :address, 
`phone` = :phone, 
`sex` = :sex, 
`birthdate` = :birthdate, 
`purok` = :purok,
`barangay` = :barangay,
`status` = :resident_status
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
$stmt->bindParam(':purok', $purok);
$stmt->bindParam(':barangay', $barangay);
$stmt->bindParam(':resident_status', $resident_status);
$stmt->bindParam(':id', $id);
$stmt->execute();
generate_logs('Updating Resident', $fullname.'| Resident information was updated');
header('Location: ../residents.php?type=success&message=Resident information was updated successfully');
?>
