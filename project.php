<?php
include_once 'functions/authentication.php';
include_once 'functions/get-tables.php';
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Budget - UMLTFIPG</title>
    <meta name="description" content="UMLTFIPG - Utilizing Machine Learning Technique to Forecast the Influence of Population Growth">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
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
                    <li class="nav-item"><a class="nav-link" href="prediction-purok-population.php">Prediction Population</a></li>
                    <li class="nav-item"><a class="nav-link" href="prediction-barangay-population.php">Prediction Barangay Population</a></li>
                    <li class="nav-item"><a class="nav-link" href="prediction-budget.php">Prediction Budget</a></li>
                    <li class="nav-item"><a class="nav-link" href="population.php">Population</a></li>
                    <li class="nav-item <?php if($_SESSION['type'] == 'Staff'){echo "d-none";} else {echo "d-block";}?>"><a class="nav-link active" href="project.php">Funding</a></li>
                    <li class="nav-item <?php if($_SESSION['type'] == 'Staff'){echo "d-none";} else {echo "d-block";}?>"><a class="nav-link" href="residents.php">Residents</a></li>
                    <li class="nav-item <?php if($_SESSION['type'] == 'Staff'){echo "d-none";} else {echo "d-block";}?>"><a class="nav-link" href="staff.php">Staff</a></li>
                </ul><a class="btn btn-outline-success" type="button" href="functions/logout.php">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-success mb-0">Fundings</h3><button class="btn btn-success btn-sm link-light " type="button" data-bs-target="#add" data-bs-toggle="modal"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Add Project</button>
        </div>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-success m-0 fw-bold">Funding List</p>
            </div>
            <div class="card-body">
                <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                    <table class="table my-0 table-bordered table-display" id="dataTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Funding Name</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Funding Name</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="add">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Project</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="functions/project-create.php" method="post">
                        <div class="form-group mb-3">
                            <div>
                                <p><strong>Project Name</strong>&nbsp;<span class="text-danger">*</span></p><input class="form-control" type="text" required="" name="name" placeholder="Ex. Skyway">
                            </div>
                            <div>
                                <p><strong>Project Description</strong>&nbsp;&nbsp;<span class="text-danger">*</span></p>
                            </div>
                            <div>
                                <p><textarea class="form-control" name="description" placeholder="Project Description" required=""></textarea></p>
                            </div>
                        </div>
                    
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="submit">Save</button></div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="update">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Project</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="functions/project-update.php" method="post">
                        <input type="hidden" name="data_id">
                        <div class="form-group mb-3">
                            <div>
                                <p><strong>Project Name</strong>&nbsp;<span class="text-danger">*</span></p><input class="form-control" type="text" required="" name="name" placeholder="Ex. Skyway">
                            </div>
                            <div>
                                <p><strong>Project Description</strong>&nbsp;&nbsp;<span class="text-danger">*</span></p>
                            </div>
                            <div>
                                <p><textarea class="form-control" name="description" placeholder="Project Description" required=""></textarea></p>
                            </div>
                        </div>
                    
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
                    <h4 class="modal-title">Remove Project</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove this project?</p>
                </div>
                <form action="functions/project-remove.php" method="post">
                    <input type="hidden" name="data_id">
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-danger" type="submit">Remove</button></div>
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
    <script src="assets/js/project.js"></script>
</body>

</html>