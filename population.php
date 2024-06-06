<?php
include_once 'functions/authentication.php';
include_once 'functions/get-data.php';
include_once 'functions/get-tables.php';
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Population - UMLTFIPG</title>
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
                    <li class="nav-item"><a class="nav-link active" href="population.php">Population</a></li>
                    <li class="nav-item <?php if($_SESSION['type'] == 'Staff'){echo "d-none";} else {echo "d-block";}?>"><a class="nav-link" href="project.php">Funding</a></li>
                    <li class="nav-item <?php if($_SESSION['type'] == 'Staff'){echo "d-none";} else {echo "d-block";}?>"><a class="nav-link" href="residents.php">Residents</a></li>
                    <li class="nav-item <?php if($_SESSION['type'] == 'Staff'){echo "d-none";} else {echo "d-block";}?>"><a class="nav-link active" href="staff.php">Staff</a></li>
                </ul><a class="btn btn-outline-success" type="button" href="functions/logout.php">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-success mb-0">Population - Monitoring</h3>
        </div>
        <div class="row row-cols-2">
            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-success fw-bold m-0">Male</h6>
                        <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                        <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                            <p class="text-center dropdown-header">dropdown header:</p><a class="dropdown-item" href="#">&nbsp;Action</a><a class="dropdown-item" href="#">&nbsp;Another action</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="#">&nbsp;Something else here</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <?php male_month_chart(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="text-success fw-bold m-0">Female</h6>
                    <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                    <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                        <p class="text-center dropdown-header">dropdown header:</p><a class="dropdown-item" href="#">&nbsp;Action</a><a class="dropdown-item" href="#">&nbsp;Another action</a>
                        <div class="dropdown-divider"></div><a class="dropdown-item" href="#">&nbsp;Something else here</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <?php female_month_chart(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <p class="text-success m-0 fw-bold"><span class="badge bg-success"></span>&nbsp;Male</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive table mt-2"  role="grid" aria-describedby="dataTable_info">
                        <table class="table my-0 table-bordered table-display" id="dataTable-1">
                            <thead>
                                <tr>
                                    <th>Lastname</th>
                                    <th>Firstname</th>
                                    <th>Middlename</th>
                                    <th>Suffix</th>
                                    <th>Sex</th>
                                    <th>Age</th>
                                </tr>
                            </thead>
                            
                            <tfoot>
                                <tr>
                                    <th>Lastname</th>
                                    <th>Firstname</th>
                                    <th>Middlename</th>
                                    <th>Suffix</th>
                                    <th>Sex</th>
                                    <th>Age</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <p class="text-success m-0 fw-bold"><span class="badge bg-success"></span>&nbsp;Female</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                        <table class="table my-0 table-bordered table-display" id="dataTable-2" >
                            <thead>
                                <tr>
                                    <th>Lastname</th>
                                    <th>Firstname</th>
                                    <th>Middlename</th>
                                    <th>Suffix</th>
                                    <th>Sex</th>
                                    <th>Age</th>
                                </tr>
                            </thead>
                            
                            <tfoot>
                                <tr>
                                    <th>Lastname</th>
                                    <th>Firstname</th>
                                    <th>Middlename</th>
                                    <th>Suffix</th>
                                    <th>Sex</th>
                                    <th>Age</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
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
    <script src="assets/js/population.js"></script>
  
</body>

</html>