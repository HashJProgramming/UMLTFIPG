<?php
include_once 'functions/authentication.php';
include_once 'functions/get-tables.php';
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Staff Management - UMLTFIPG</title>
    <meta name="description" content="UMLTFIPG - Utilizing Machine Learning Technique to Forecast the Influence of Population Growth on the Budget of Barangay Begong">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Application-Form.css">
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Links-icons.css">
    <link href="assets/css/datatables.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <nav class="navbar navbar-expand-md bg-success-subtle py-3 mb-4">
        <div class="container-fluid"><a class="navbar-brand d-flex align-items-center" href="#"><span class="bs-icon-sm bs-icon-rounded bs-icon-semi-white d-flex justify-content-center align-items-center me-4 bs-icon"><img src="assets/img/republic-of-the-philippines-clipart-6.jpg" width="64" height="64"></span><span class="text-light-emphasis">UMLTFIPG</span></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-3"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-3">
            <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="prediction-population.php">Prediction Population</a></li>
                    <li class="nav-item"><a class="nav-link" href="prediction-budget.php">Prediction Budget</a></li>
                    <li class="nav-item"><a class="nav-link" href="population.php">Population</a></li>
                    <li class="nav-item <?php if($_SESSION['type'] == 'Staff'){echo "d-none";} else {echo "d-block";}?>"><a class="nav-link" href="project.php">Funding</a></li>
                    <li class="nav-item <?php if($_SESSION['type'] == 'Staff'){echo "d-none";} else {echo "d-block";}?>"><a class="nav-link" href="residents.php">Residents</a></li>
                    <li class="nav-item <?php if($_SESSION['type'] == 'Staff'){echo "d-none";} else {echo "d-block";}?>"><a class="nav-link active" href="staff.php">Staff</a></li>
                </ul><a class="btn btn-outline-success" type="button" href="functions/logout.php">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-success mb-0">Staff Management</h3><a class="btn btn-success btn-sm link-light " role="button" href="#" data-bs-target="#add" data-bs-toggle="modal"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Add Resident</a>
        </div>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-success m-0 fw-bold">Residents List</p>
            </div>
            <div class="card-body">
                <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                    <table class="table my-0 table-bordered table-display" id="dataTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Type</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            staff_list();
                            ?>
                        </tbody>
                        <tfoot>
                            <tr></tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="add">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Staff</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <section>
                        <div class="container">
                            <form action="functions/staff-create.php" method="post" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <div class="row">
                                        <div class="col">
                                            <p><strong>Username</strong>&nbsp;<span class="text-danger">*</span></p><input class="form-control" type="text" required="" name="username" placeholder="Ex. John" pattern="^(?!\s).*$">
                                        </div>
                                        <div class="col">
                                            <p><strong>Password</strong>&nbsp;<span class="text-danger">*</span></p><input class="form-control" type="password" required="" name="password" placeholder="Ex. 12345678" pattern="^(?!\s).*$">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="submit">Save</button></div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="update">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Staff</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <section>
                        <div class="container">
                            <form action="functions/staff-update.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="data_id">
                                <div class="form-group mb-3">
                                    <div class="row">
                                        <div class="col">
                                            <p><strong>Username</strong>&nbsp;<span class="text-danger">*</span></p><input class="form-control" type="text" required="" name="username" placeholder="Ex. John" pattern="^(?!\s).*$">
                                        </div>
                                        <div class="col">
                                            <p><strong>Password</strong>&nbsp;<span class="text-danger">*</span></p><input class="form-control" type="password" required="" name="password" placeholder="New Password" pattern="^(?!\s).*$">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="submit">Save</button></div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="remove">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remove Staff</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove this Staff?</p>
                </div>
                <form action="functions/staff-remove.php" method="post">
                    <input type="hidden" name="data_id">
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-danger" type="submit">remove</button></div>
                </form>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/sweetalert2.all.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>