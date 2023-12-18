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
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['lastname']; ?></td>
                <td><?php echo $row['firstname']; ?></td>
                <td><?php echo $row['middlename']; ?></td>
                <td><?php echo $row['suffix']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['purok']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['sex']; ?></td>
                <td><?php echo $age; ?></td>
                <td><?php echo $row['birthdate']; ?></td>
                <td class="text-center">
                    <!-- <a class="btn btn-info link-light mx-1 mb-1" role="button" href="#">View</a> -->
                    <button class="btn btn-warning link-light mx-1 mb-1" type="button" data-bs-target="#update" data-bs-toggle="modal" data-id="<?php echo $row['id']; ?>" data-firstname="<?php echo $row['firstname']; ?>" data-lastname="<?php echo $row['lastname']; ?>" data-middlename="<?php echo $row['middlename']; ?>" data-suffix="<?php echo $row['suffix']; ?>" data-birthdate="<?php echo $row['birthdate']; ?>" data-sex="<?php echo $row['sex']; ?>" data-address="<?php echo $row['address']; ?>" data-phone="<?php echo $row['phone']; ?>" data-purok="<?php echo $row['purok']; ?>">Update</button>
                    <button class="btn btn-danger link-light mx-1 mb-1" type="button" data-bs-target="#remove" data-bs-toggle="modal" data-id="<?php echo $row['id']; ?>">Remove</button>
                </td>
            </tr>
        <?php
    }
}

function staff_list(){
    global $db;
    $sql = 'SELECT * FROM users WHERE type != "Admin" ORDER BY username ASC';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row) {
        ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['password']; ?></td>
                <td><?php echo $row['type']; ?></td>
                <td class="text-center">
                    <!-- <a class="btn btn-info link-light mx-1 mb-1" role="button" href="#">View</a> -->
                    <button class="btn btn-warning link-light mx-1 mb-1" type="button" data-bs-target="#update" data-bs-toggle="modal" data-id="<?php echo $row['id']; ?>" data-username="<?php echo $row['username']; ?>">Update</button>
                    <button class="btn btn-danger link-light mx-1 mb-1" type="button" data-bs-target="#remove" data-bs-toggle="modal" data-id="<?php echo $row['id']; ?>">Remove</button>
                </td>
            </tr>
        <?php
    }
}

function male_list(){
    global $db;
    $sql = 'SELECT * FROM residents WHERE sex = "Male" ORDER BY lastname ASC';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row) {
        $birthdate = new DateTime($row['birthdate']);
        $today = new DateTime();
        $age = $birthdate->diff($today)->y;
        ?>
            <tr>
                <td><?php echo $row['lastname']; ?></td>
                <td><?php echo $row['firstname']; ?></td>
                <td><?php echo $row['middlename']; ?></td>
                <td><?php echo $row['suffix']; ?></td>
                <td><?php echo $row['sex']; ?></td>
                <td><?php echo $age; ?></td>
            </tr>
        <?php
    }
}

function female_list(){
    global $db;
    $sql = 'SELECT * FROM residents WHERE sex = "Female" ORDER BY lastname ASC';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row) {
        $birthdate = new DateTime($row['birthdate']);
        $today = new DateTime();
        $age = $birthdate->diff($today)->y;
        ?>
            <tr>
                <td><?php echo $row['lastname']; ?></td>
                <td><?php echo $row['firstname']; ?></td>
                <td><?php echo $row['middlename']; ?></td>
                <td><?php echo $row['suffix']; ?></td>
                <td><?php echo $row['sex']; ?></td>
                <td><?php echo $age; ?></td>
            </tr>
        <?php
    }
}


function projects_list(){
    global $db;
    $sql = 'SELECT * FROM projects ORDER BY name ASC';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row) {
        ?>
             <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td class="text-center">
                    <a class="btn btn-info link-light mx-1 mb-1" role="button" href="budget.php?id=<?php echo $row['id']; ?>">Funds</a>
                    <button class="btn btn-warning link-light mx-1 mb-1" type="button" data-bs-target="#update" data-bs-toggle="modal" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name']; ?>" data-description="<?php echo $row['description']; ?>">Update</button>
                    <button class="btn btn-danger link-light mx-1 mb-1" type="button" data-bs-target="#remove" data-bs-toggle="modal" data-id="<?php echo $row['id']; ?>">Remove</button></td>
            </tr>
        <?php
    }
}

function project_fund_list($id){
    global $db;
    $sql = 'SELECT * FROM project_fund WHERE project_id = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row) {
        ?>
             <tr>
                <td><?php echo '₱'.number_format($row['fund'], 2); ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
        <?php
    }
}