<?php
include_once 'functions/authentication.php';
include_once 'functions/get-tables.php';
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Project Funds - UMLTFIPG</title>
    <meta name="description" content="UMLTFIPG - Utilizing Machine Learning Technique to Forecast the Influence of Population Growth on the Budget of Barangay Begong">
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
                    <li class="nav-item"><a class="nav-link" href="prediction-population.php">Prediction Population</a></li>
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
            <h3 class="text-success mb-0">Adding Fund</h3><a class="btn btn-success btn-sm link-light " role="button" href="#" data-bs-target="#add" data-bs-toggle="modal"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Add Fund</a>
        </div>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-success m-0 fw-bold">Fund List</p>
            </div>
            <div class="card-body">
                <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                    <table class="table table-bordered my-0 table-display" id="dataTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Project ID</th>
                                <th>Fund</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Project ID</th>
                                <th>Fund</th>
                                <th>Status</th>
                                <th>Date</th>
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
                    <form action="functions/project-add-fund.php" method="post">
                    <input type="hidden" name="data_id" value="<?php echo $id; ?>">
                        <div class="form-group mb-3">
                            <div>
                                <p><strong>Project Fund</strong><span class="text-danger">*</span></p><input class="form-control" type="text" pattern="^(?!^\.)(?!.*\.$)[0-9.]+$" required="" name="fund">
                            </div>
                            <div>
                                <p><strong>Status</strong>&nbsp;<span class="text-danger">*</span></p>
                                <select class="form-select" name="status">
                                    <optgroup label="SELECT STATUS">
                                        <option value="APPROVED" selected="">APPROVED</option>
                                        <option value="REJECTED">REJECTED</option>
                                        <option value="POSTPONE">POSTPONE</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="submit">Save</button></div>
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
    <script>
        
        const currentPath = window.location.pathname;
        const urlParams = new URLSearchParams(window.location.search);
        const type = urlParams.get("type");
        const message = urlParams.get("message");

        $(document).ready(function() {
            if (type == "success") {
                Swal.fire("Success!", message, "success");
            } else if (type == "error") {
                Swal.fire("Error!", message, "error");
            }

            new DataTable("#dataTable", {
                ajax: 'functions/scripts/server_funds.php?id=<?php echo $id; ?>',
                processing: true,
                serverSide: true,
                dom: '<"top"Bfrtip<"clear">',
                buttons: [
                    {
                        extend: "excel",
                        title: "UMLTFIPG - Utilizing Machine Learning Technique to Forecast the Influence of Population Growth on the Budget of Barangay Begong",
                        className: "btn btn-primary",
                        text: '<i class="fa fa-file-excel"></i> EXCEL',
                    },
                    {
                        extend: "pdf",
                        title: "UMLTFIPG - Utilizing Machine Learning Technique to Forecast the Influence of Population Growth on the Budget of Barangay Begong",
                        className: "btn btn-primary",
                        text: '<i class="fa fa-file-pdf"></i> PDF',
                    },
                    {
                        extend: "print",
                        className: "btn btn-primary",
                        text: '<i class="fa fa-print"></i> Print',
                        title: "UMLTFIPG - Utilizing Machine Learning Technique to Forecast the Influence of Population Growth on the Budget of Barangay Begong",
                        autoPrint: true,
                        exportOptions: {
                            columns: ":visible",
                        },
                        customize: function (win) {
                            $(win.document.body)
                                .find("table")
                                .addClass("display")
                                .css("font-size", "9px");
                            $(win.document.body)
                                .find("tr:nth-child(odd) td")
                                .each(function (index) {
                                    $(this).css("background-color", "#D0D0D0");
                                });
                            $(win.document.body).find("h1").css("text-align", "center");
                        },
                    },
                ],
                responsive: {
                    details: {
                        display: DataTable.Responsive.display.modal({
                            header: function (row) {
                                var data = row.data();
                                return 'Details for ' + data[1];
                            }
                        }),
                        renderer: DataTable.Responsive.renderer.tableAll({
                            tableClass: 'table'
                        })
                    }
                },
                columnDefs: [
                    {
                        targets: 2,
                        render: function (data, type, row) {
                            return '₱' + parseFloat(data).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                        }
                    }
                ]
            });

        });

    </script>
</body>

</html>