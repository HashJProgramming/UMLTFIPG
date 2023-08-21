<?php
include_once 'functions/authentication.php';
include_once 'functions/get-tables.php';
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Residents - UMLTFIPGB</title>
    <meta name="description" content="UMLTFIPGB - Utilizing Machine Learning Technique to Forecast the Influence of Population Growth on the Budget of Barangay Begong">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Application-Form.css">
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Links-icons.css">
</head>

<body id="page-top">
    <nav class="navbar navbar-expand-md bg-success-subtle py-3 mb-4">
        <div class="container-fluid"><a class="navbar-brand d-flex align-items-center" href="#"><span class="bs-icon-sm bs-icon-rounded bs-icon-semi-white d-flex justify-content-center align-items-center me-4 bs-icon"><img src="assets/img/republic-of-the-philippines-clipart-6.jpg" width="64" height="64"></span><span class="text-light-emphasis">UMLTFIPGB</span></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-3"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-3">
            <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="prediction-population.php">Prediction Population</a></li>
                    <li class="nav-item"><a class="nav-link" href="prediction-budget.php">Prediction Budget</a></li>
                    <li class="nav-item"><a class="nav-link" href="population.php">Population</a></li>
                    <li class="nav-item"><a class="nav-link" href="project.php">Projects</a></li>
                    <li class="nav-item"><a class="nav-link active" href="residents.php">Residents</a></li>
                </ul><button class="btn btn-outline-success" type="button">Logout</button>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-success mb-0">Residents - Under Maintenance</h3><a class="btn btn-success btn-sm link-light d-none d-sm-inline-block" role="button" href="#" data-bs-target="#add" data-bs-toggle="modal"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Add Resident</a>
        </div>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-success m-0 fw-bold">Residents List</p>
            </div>
            <div class="card-body">
                <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                    <table class="table my-0 table-display" id="dataTable">
                        <thead>
                            <tr>
                                <th>Lastname</th>
                                <th>Firstname</th>
                                <th>Middlename</th>
                                <th>Suffix</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Sex</th>
                                <th>Age</th>
                                <th>Birthdate</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            resident_list();
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
                                            <p><strong>Suffix</strong><span class="text-danger">*</span></p><input class="form-control" type="text" required="" name="suffix" placeholder="Ex. Sr. Jr" pattern="^(?!\s).*$">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="row">
                                        <div class="col">
                                            <p><strong>Date Of Birth</strong>&nbsp;<span class="text-danger">*</span></p><input class="form-control" type="date" required="" name="birthdate">
                                        </div>
                                        <div class="col">
                                            <p><strong>Phone Number&nbsp;</strong><span class="text-danger">*</span></p><input class="form-control" type="text" name="phone" placeholder="7777777777" pattern="[0-9]+" minlength="11" maxlength="11" required="">
                                        </div>
                                        <div class="col">
                                            <p><strong>Sex</strong><span class="text-danger">*</span></p><select class="form-select" name="sex">
                                                <optgroup label="SELECT SEX">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <p><strong>Address&nbsp;</strong><span class="text-danger">*</span></p><input class="form-control" type="text" required="" name="address" placeholder="Ex. Room No-361, 33/1, 3rd Floor" pattern="^(?!\s).*$">
                                </div>
                                <div class="form-group mb-3"><p><strong>Your Picture </strong><span class="text-danger">*</span></p>
                                    <div class="file">
                                                <!-- Upload image input-->
                                                <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm ">
                                                    <input id="upload" name="picture" type="file" onchange="readURL(this);" class="form-control border-0">
                                                    <label id="upload-label" for="upload" class="font-weight-light text-muted">Choose file</label>
                                                    <div class="input-group-append">
                                                        <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Choose file</small></label>
                                                    </div>
                                                </div>

                                                <!-- Uploaded image area-->
                                                <p class="font-italic text-dark text-center">The image uploaded will be rendered inside the box below.</p>
                                                <div class="image-area mt-4 text-dark"><img id="imageResult" src="#" alt="" class="img-fluid rounded shadow-sm mx-auto d-block"  width=200></div>
                                    <div class="col d-none">
                                        <p><strong>URL</strong><span class="text-danger">*</span></p>
                                        <input id="urllink" name="url" type="url" class="form-control" readonly/>
                                    </div>
                                    </div></div>
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
                                            <p><strong>Suffix</strong><span class="text-danger">*</span></p><input class="form-control" type="text" required="" name="suffix" placeholder="Ex. Sr. Jr" pattern="^(?!\s).*$">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="row">
                                        <div class="col">
                                            <p><strong>Date Of Birth</strong>&nbsp;<span class="text-danger">*</span></p><input class="form-control" type="date" required="" name="birthdate">
                                        </div>
                                        <div class="col">
                                            <p><strong>Phone Number&nbsp;</strong><span class="text-danger">*</span></p><input class="form-control" type="text" name="phone" placeholder="7777777777" pattern="[0-9]+" minlength="11" maxlength="11" required="">
                                        </div>
                                        <div class="col">
                                            <p><strong>Sex</strong><span class="text-danger">*</span></p><select class="form-select" name="sex">
                                                <optgroup label="SELECT SEX">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <p><strong>Address&nbsp;</strong><span class="text-danger">*</span></p><input class="form-control" type="text" required="" name="address" placeholder="Ex. Room No-361, 33/1, 3rd Floor" pattern="^(?!\s).*$">
                                </div>
                                <div class="form-group mb-3"><p><strong>Your Picture </strong><span class="text-danger">*</span></p>
                                    <div class="file">
                                                <!-- Upload image input-->
                                                <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm ">
                                                    <input id="upload2" name="picture" type="file" onchange="readURL2(this);" class="form-control border-0">
                                                    <label id="upload-label2" for="upload2" class="font-weight-light text-muted">Choose file</label>
                                                    <div class="input-group-append">
                                                        <label for="upload2" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Choose file</small></label>
                                                    </div>
                                                </div>

                                                <!-- Uploaded image area-->
                                                <p class="font-italic text-dark text-center">The image uploaded will be rendered inside the box below.</p>
                                                <div class="image-area mt-4 text-dark"><img id="imageResult2" src="#" alt="" class="img-fluid rounded shadow-sm mx-auto d-block"  width=200></div>
                                    <div class="col d-none">
                                        <p><strong>URL</strong><span class="text-danger">*</span></p>
                                        <input id="urllink2" name="url" type="url" class="form-control" readonly/>
                                    </div>
                                    </div></div>
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
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script src="assets/js/jszip.min.js"></script>
    <script src="assets/js/Application-Form-Bootstrap-Image-Uploader.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/buttons.print.min.js"></script>
    <script src="assets/js/buttons.html5.min.js"></script>
    <script src="assets/js/sweetalert2.all.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>