<?php
 

$table = 'project_fund';
$id = $_GET['id'];

// Table's primary key
$primaryKey = 'id';

$columns = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'fund', 'dt' => 1),
    array('db' => 'status', 'dt' => 2),
    array('db' => 'created_at', 'dt' => 3)
);

 
// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'umltfipg',
    'host' => '127.0.0.1'
);
 
$where = "id = '$id'";

require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $where)
);