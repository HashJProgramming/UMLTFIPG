<?php
 

$table = 'project_fund';
$id = $_GET['id'];

// Table's primary key
$primaryKey = 'id';

$columns = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'project_id', 'dt' => 1),
    array('db' => 'fund', 'dt' => 2),
    array('db' => 'status', 'dt' => 3),
    array('db' => 'created_at', 'dt' => 4)
);

 
// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'umltfipg',
    'host' => '127.0.0.1'
);
 
$where = "project_id = '$id'";

require( 'ssp.class.php' );
 
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where)
);