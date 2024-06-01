<?php
 

$table = 'projects';
 
// Table's primary key
$primaryKey = 'id';

$columns = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'name', 'dt' => 1),
    array('db' => 'description', 'dt' => 2),
    array('db' => 'created_at', 'dt' => 3),
    array(
        'db' => 'id',
        'dt' => 4,
        'formatter' => function($d, $row) {
            return '<td class="text-center">
                <div class="d-flex justify-content-center">
                    <a class="btn btn-info link-light mx-1 mb-1" role="button" href="budget.php?id='.$row['id'].'">Funds</a>
                    <button class="btn btn-warning link-light mx-1 mb-1" type="button" data-bs-target="#update" data-bs-toggle="modal" data-id="'.$row['id'].'" data-name="'.$row['name'].'" data-description="'.$row['description'].'">Update</button>
                    <button class="btn btn-danger link-light mx-1 mb-1" type="button" data-bs-target="#remove" data-bs-toggle="modal" data-id="'.$row['id'].'">Remove</button>
                </div>
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