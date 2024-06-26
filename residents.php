<?php
include_once 'functions/authentication.php';
include_once 'functions/get-tables.php';
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Residents - UMLTFIPG</title>
    <meta name="description" content="UMLTFIPG - Utilizing Machine Learning Technique to Forecast the Influence of Population Growth">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
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
                    <li class="nav-item"><a class="nav-link" href="prediction-budget.php">Prediction Budget</a></li>
                    <li class="nav-item"><a class="nav-link" href="population.php">Population</a></li>
                    <li class="nav-item <?php if($_SESSION['type'] == 'Staff'){echo "d-none";} else {echo "d-block";}?>"><a class="nav-link" href="project.php">Funding</a></li>
                    <li class="nav-item <?php if($_SESSION['type'] == 'Staff'){echo "d-none";} else {echo "d-block";}?>"><a class="nav-link active" href="residents.php">Residents</a></li>
                    <li class="nav-item <?php if($_SESSION['type'] == 'Staff'){echo "d-none";} else {echo "d-block";}?>"><a class="nav-link" href="staff.php">Staff</a></li>
                </ul><a class="btn btn-outline-success" type="button" href="functions/logout.php">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-success mb-0">Residents</h3><a class="btn btn-success btn-sm link-light " role="button" href="#" data-bs-target="#add" data-bs-toggle="modal"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Add Resident</a>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-success m-0 fw-bold"><span class="badge bg-success"></span>&nbsp;Table</p>
            </div>
            <div class="card-body">
                <div class="table-responsive table mt-2"  role="grid" aria-describedby="dataTable_info">
                    <table class="table table-bordered table-striped nowrap" cellspacing="0" id="dataTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Lastname</th>
                                <th>Firstname</th>
                                <th>Middlename</th>
                                <th>Suffix</th>
                                <th>Phone</th>
                                <th>Barangay</th>
                                <th>Purok</th>
                                <th>Address</th>
                                <th>Sex</th>
                                <th>Age</th>
                                <th>Birthdate</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Lastname</th>
                                <th>Firstname</th>
                                <th>Middlename</th>
                                <th>Suffix</th>
                                <th>Phone</th>
                                <th>Barangay</th>
                                <th>Purok</th>
                                <th>Address</th>
                                <th>Sex</th>
                                <th>Age</th>
                                <th>Birthdate</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="add">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Resident Registration Form</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form class="text-center" method="post">
                        <div class="mb-3"></div>
                        <div class="mb-3"></div>
                        <div class="mb-3"></div>
                    </form>
                    <section>
                        <h1 class="text-center text-capitalize">Registration form</h1>
                        <div class="container">
                            <form action="functions/resident-create.php" method="post" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-4">
                                        <div class="col">
                                            <p><strong>First Name</strong>&nbsp;<span class="text-danger">*</span></p><input class="form-control" type="text" required="" name="firstname" placeholder="Ex. John" pattern="^(?!\s).*$">
                                        </div>
                                        <div class="col">
                                            <p><strong>Last Name</strong>&nbsp;<span class="text-danger">*</span></p><input class="form-control" type="text" required="" name="lastname" placeholder="Ex. Smith" pattern="^(?!\s).*$">
                                        </div>
                                        <div class="col">
                                            <p><strong>Middle Name</strong><span class="text-danger">*</span></p><input class="form-control" type="text" required="" name="middlename" placeholder="Ex. S." pattern="^(?!\s).*$">
                                        </div>
                                        <div class="col">
                                            <p><strong>Suffix</strong></p><input class="form-control" type="text" name="suffix" placeholder="Ex. Sr. Jr" pattern="^(?!\s).*$">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="row">
                                        <div class="col">
                                            <p><strong>Date Of Birth</strong>&nbsp;<span class="text-danger">*</span></p><input class="form-control" type="date" required="" name="birthdate">
                                        </div>
                                        <div class="col">
                                            <p><strong>Phone Number&nbsp;</strong></p><input class="form-control" type="text" name="phone" placeholder="7777777777" pattern="[0-9]+" minlength="11" maxlength="11">
                                        </div>
                                        <div class="col">
                                            <p><strong>Sex</strong><span class="text-danger">*</span></p><select class="form-select" name="sex">
                                                <optgroup label="SELECT SEX">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <p><strong>Barangay</strong><span class="text-danger">*</span></p>
                                            <select class="form-select" name="barangay" id="barangay-select">
                                                <optgroup label="SELECT BARANGAY">
                                                    <option value="Nilo">Nilo</option>
                                                    <option value="Longmot">Longmot</option>
                                                    <option value="Caluma">Caluma</option>
                                                    <option value="Mate">Mate</option>
                                                    <option value="Timolan">Timolan</option>
                                                    <option value="Libayoy">Libayoy</option>
                                                    <option value="Guinlin">Guinlin</option>
                                                    <option value="Limas">Limas</option>
                                                    <option value="Maragang">Maragang</option>
                                                    <option value="Busol">Busol</option>
                                                    <option value="Diana Countryside">Diana Countryside</option>
                                                    <option value="Lacupayan">Lacupayan</option>
                                                    <option value="Upper Nilo">Upper Nilo</option>
                                                    <option value="Lacarayan">Lacarayan</option>
                                                    <option value="Nangan-Nangan">Nangan-Nangan</option>
                                                    <option value="New Tuboran">New Tuboran</option>
                                                    <option value="Tigbao">Tigbao</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <p><strong>Purok</strong><span class="text-danger">*</span></p>
                                            <select class="form-select" name="purok" id="purok-select">
                                                <optgroup label="SELECT PUROK">
                                                    <option value="Purok 1">Purok 1</option>
                                                    <option value="Purok 2">Purok 2</option>
                                                    <option value="Purok 3">Purok 3</option>
                                                    <option value="Purok 4">Purok 4</option>
                                                    <option value="Purok 5">Purok 5</option>
                                                    <option value="Purok 6">Purok 6</option>
                                                    <option value="Purok 7">Purok 7</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <p><strong>Previous Address&nbsp;</strong></p><input class="form-control" type="text" name="address" placeholder="Ex. Room No-361, 33/1, 3rd Floor" pattern="^(?!\s).*$">
                                    
                                </div>
                                
                                <div class="justify-content-center d-flex form-group mb-3">
                                    <div id="submit-btn"></div>
                                </div>
                            </div>
                            <div class="col">
                                <h3 id="fail" class="text-center text-danger d-none"><br>Form not Submitted&nbsp;<a href="contact.php">Try Again</a><br><br></h3>
                                <h3 id="success-1" class="text-center text-success d-none"><br>Form Submitted Successfully&nbsp;<a href="contact.php">Send Another Response</a><br><br></h3>
                            </div>
                        </section>
                    </div>
                    <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="submit">Save</button></div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="update">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Resident Info</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form class="text-center" method="post">
                        <div class="mb-3"></div>
                        <div class="mb-3"></div>
                        <div class="mb-3"></div>
                    </form>
                    <section>
                        <h1 class="text-center text-capitalize">Update Resident</h1>
                        <div class="container">
                            <form action="functions/resident-update.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="data_id">
                                <div class="form-group mb-3">
                                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-4">
                                        <div class="col">
                                            <p><strong>First Name</strong>&nbsp;<span class="text-danger">*</span></p><input class="form-control" type="text" required="" name="firstname" placeholder="Ex. John" pattern="^(?!\s).*$">
                                        </div>
                                        <div class="col">
                                            <p><strong>Last Name</strong>&nbsp;<span class="text-danger">*</span></p><input class="form-control" type="text" required="" name="lastname" placeholder="Ex. Smith" pattern="^(?!\s).*$">
                                        </div>
                                        <div class="col">
                                            <p><strong>Middle Name</strong><span class="text-danger">*</span></p><input class="form-control" type="text" required="" name="middlename" placeholder="Ex. S." pattern="^(?!\s).*$">
                                        </div>
                                        <div class="col">
                                            <p><strong>Suffix</strong></p><input class="form-control" type="text" name="suffix" placeholder="Ex. Sr. Jr" pattern="^(?!\s).*$">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="row">
                                        <div class="col">
                                            <p><strong>Date Of Birth</strong>&nbsp;<span class="text-danger">*</span></p><input class="form-control" type="date" required="" name="birthdate">
                                        </div>
                                        <div class="col">
                                            <p><strong>Phone Number&nbsp;</strong></p><input class="form-control" type="text" name="phone" placeholder="7777777777" pattern="[0-9]+" minlength="11" maxlength="11">
                                        </div>
                                        <div class="col">
                                            <p><strong>Sex</strong><span class="text-danger">*</span></p><select class="form-select" name="sex">
                                                <optgroup label="SELECT SEX">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <p><strong>Barangay</strong><span class="text-danger">*</span></p>
                                            <select class="form-select" name="barangay" id="barangay-select-update">
                                                <optgroup label="SELECT BARANGAY">
                                                    <option value="Nilo">Nilo</option>
                                                    <option value="Longmot">Longmot</option>
                                                    <option value="Caluma">Caluma</option>
                                                    <option value="Mate">Mate</option>
                                                    <option value="Timolan">Timolan</option>
                                                    <option value="Libayoy">Libayoy</option>
                                                    <option value="Guinlin">Guinlin</option>
                                                    <option value="Limas">Limas</option>
                                                    <option value="Maragang">Maragang</option>
                                                    <option value="Busol">Busol</option>
                                                    <option value="Diana Countryside">Diana Countryside</option>
                                                    <option value="Lacupayan">Lacupayan</option>
                                                    <option value="Upper Nilo">Upper Nilo</option>
                                                    <option value="Lacarayan">Lacarayan</option>
                                                    <option value="Nangan-Nangan">Nangan-Nangan</option>
                                                    <option value="New Tuboran">New Tuboran</option>
                                                    <option value="Tigbao">Tigbao</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <p><strong>Purok</strong><span class="text-danger">*</span></p>
                                            <select class="form-select" name="purok" id="purok-select-update">
                                                <optgroup label="SELECT PUROK">
                                                    <option value="Purok 1">Purok 1</option>
                                                    <option value="Purok 2">Purok 2</option>
                                                    <option value="Purok 3">Purok 3</option>
                                                    <option value="Purok 4">Purok 4</option>
                                                    <option value="Purok 5">Purok 5</option>
                                                    <option value="Purok 6">Purok 6</option>
                                                    <option value="Purok 7">Purok 7</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <p><strong>STATUS</strong><span class="text-danger">*</span></p><select class="form-select" name="resident_status">
                                                <optgroup label="SELECT STATUS">
                                                <option value="1">Alive</option>
                                                <option value="0">Deceased</option> 
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <p><strong>Previous Address&nbsp;</strong></p><input class="form-control" type="text" name="address" placeholder="Ex. Room No-361, 33/1, 3rd Floor" pattern="^(?!\s).*$">
                                </div>
                                
                                <div class="justify-content-center d-flex form-group mb-3">
                                    <div id="submit-btn"></div>
                                </div>
                            </div>
                            <div class="col">
                                <h3 id="fail" class="text-center text-danger d-none"><br>Form not Submitted&nbsp;<a href="contact.php">Try Again</a><br><br></h3>
                                <h3 id="success-1" class="text-center text-success d-none"><br>Form Submitted Successfully&nbsp;<a href="contact.php">Send Another Response</a><br><br></h3>
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
                    <h4 class="modal-title">Remove Resident</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove this resident?</p>
                </div>
                <form action="functions/resident-remove.php" method="post">
                    <input type="hidden" name="data_id">
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-danger" type="submit">remove</button></div>
                </form>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/sweetalert2.all.min.js"></script>
    <script src="assets/js/residents.js"></script>
</body>

</html>