<?php
 

$table = 'residents_view';
 
// Table's primary key
$primaryKey = 'id';
 
$columns = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'lastname', 'dt' => 1),
    array('db' => 'firstname', 'dt' => 2),
    array('db' => 'middlename', 'dt' => 3),
    array('db' => 'suffix', 'dt' => 4),
    array('db' => 'phone', 'dt' => 5),
    array('db' => 'purok', 'dt' => 6),
    array('db' => 'address', 'dt' => 7),
    array('db' => 'sex', 'dt' => 8),
    array('db' => 'age', 'dt' => 9),
    array('db' => 'birthdate', 'dt' => 10),
    array('db' => 'status', 'dt' => 11),
    array(
        'db' => 'id',
        'dt' => 12,
        'formatter' => function($d, $row) {
            return '<td class="text-center">
                        <button class="btn btn-warning mx-1 mb-1" type="button" data-bs-target="#update" data-bs-toggle="modal" data-id="'.$row['id'].'" data-firstname="'.$row['firstname'].'" data-lastname="'.$row['lastname'].'" data-middlename="'.$row['middlename'].'" data-suffix="'.$row['suffix'].'" data-birthdate="'.$row['birthdate'].'" data-sex="'.$row['sex'].'" data-address="'.$row['address'].'" data-phone="'.$row['phone'].'" data-purok="'.$row['purok'].'">Update</button>
                        <button class="btn btn-danger mx-1 mb-1" type="button" data-bs-target="#remove" data-bs-toggle="modal" data-id="'.$row['id'].'">Remove</button>
                    </td>';
        }
    )
);

 
// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'umltfipg',
    'host' => '127.0.0.1'
);
 

 
require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);