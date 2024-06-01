<?php
 

$table = 'residents_view_male';
 
// Table's primary key
$primaryKey = 'id';

$columns = array(
    array('db' => 'firstname', 'dt' => 0),
    array('db' => 'lastname', 'dt' => 1),
    array('db' => 'middlename', 'dt' => 2),
    array('db' => 'suffix', 'dt' => 3),
    array('db' => 'sex', 'dt' => 4),
    array('db' => 'birthdate', 'dt' => 5),
    array('db' => 'age', 'dt' => 6),
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