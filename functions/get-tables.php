<?php
include_once 'connection.php';

function resident_list(){
    global $db;
    $sql = 'SELECT * FROM residents ORDER BY lastname ASC';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row) {
        $birthdate = new DateTime($row['birthdate']);
        $today = new DateTime();
        $age = $birthdate->diff($today)->y;
        ?>
            <tr>
                <td><img class="text-center rounded-circle me-2" width="100" height="100" src="functions/<?php echo $row['picture']; ?>"><?php echo $row['lastname']; ?></td>
                <td><?php echo $row['firstname']; ?></td>
                <td><?php echo $row['middlename']; ?></td>
                <td><?php echo $row['suffix']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['sex']; ?></td>
                <td><?php echo $age; ?></td>
                <td><?php echo $row['birthdate']; ?></td>
                <td class="text-center">
                    <!-- <a class="btn btn-info link-light mx-1 mb-1" role="button" href="#">View</a> -->
                    <button class="btn btn-warning link-light mx-1 mb-1" type="button" data-bs-target="#update" data-bs-toggle="modal" data-id="<?php echo $row['id']; ?>" data-firstname="<?php echo $row['firstname']; ?>" data-lastname="<?php echo $row['lastname']; ?>" data-middlename="<?php echo $row['middlename']; ?>" data-suffix="<?php echo $row['suffix']; ?>" data-birthdate="<?php echo $row['birthdate']; ?>" data-sex="<?php echo $row['sex']; ?>" data-address="<?php echo $row['address']; ?>" data-phone="<?php echo $row['phone']; ?>">Update</button>
                    <button class="btn btn-danger link-light mx-1 mb-1" type="button" data-bs-target="#remove" data-bs-toggle="modal" data-id="<?php echo $row['id']; ?>">Remove</button>
                </td>
            </tr>
        <?php
    }
}