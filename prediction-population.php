<?php
// Define the API URL
$getCurrentYear = date("Y") + 5;
$apiUrl = "http://localhost:5000/predicted_population/$getCurrentYear";

// Using cURL for more robust error handling
$ch = curl_init();

// Set the URL and other options
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute the request
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    die('cURL error: ' . curl_error($ch));
}

// Close the cURL session
curl_close($ch);

// Decode the JSON response
$data = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die('Error decoding JSON response: ' . json_last_error_msg());
}
?>
<?php
include_once 'functions/authentication.php';
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Prediction Population - UMLTFIPG</title>
    <meta name="description" content="UMLTFIPG - Utilizing Machine Learning Technique to Forecast the Influence of Population Growth on the Budget of Barangay Begong">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
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
                    <li class="nav-item"><a class="nav-link active" href="prediction-population.php">Prediction Population</a></li>
                    <li class="nav-item <?php if($_SESSION['type'] == 'Staff'){echo "d-none";} else {echo "d-block";}?>"><a class="nav-link" href="prediction-budget.php">Prediction Budget</a></li>
                    <li class="nav-item"><a class="nav-link" href="population.php">Population</a></li>
                    <li class="nav-item <?php if($_SESSION['type'] == 'Staff'){echo "d-none";} else {echo "d-block";}?>"><a class="nav-link" href="project.php">Funding</a></li>
                    <li class="nav-item <?php if($_SESSION['type'] == 'Staff'){echo "d-none";} else {echo "d-block";}?>"><a class="nav-link" href="residents.php">Residents</a></li>
                    <li class="nav-item <?php if($_SESSION['type'] == 'Staff'){echo "d-none";} else {echo "d-block";}?>"><a class="nav-link" href="staff.php">Staff</a></li>
                </ul><a class="btn btn-outline-success" type="button" href="functions/logout.php">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-success mb-0">Prediction - Population</h3>
            <a class="btn btn-success btn-sm link-light d-none d-sm-inline-block" role="button" href="#" data-bs-target="#view-table" data-bs-toggle="modal"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;View Table</a>
        </div>
        <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
<?php
foreach ($data['predicted_population'] as $purok) {
         echo "
         <div class='col'>
                <div class='card mt-1 mb-1'>
                    <div class='card-body p-4'>
                        <div class='bs-icon-md bs-icon-rounded bs-icon-semi-white d-flex justify-content-center align-items-center d-inline-block mb-3 bs-icon'><svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' fill='currentColor' viewBox='0 0 16 16' class='bi bi-bar-chart'>
                                <path d='M4 11H2v3h2zm5-4H7v7h2zm5-5v12h-2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1z'></path>
                            </svg></div>
                        <div>
                            <h4 class='text-center'>".htmlspecialchars($purok['purok'])."</h4>
                            <p class='text-center'>Population</p>
                            <div></div>
                            <div class='d-xl-flex justify-content-xl-center'>
                            <span class='badge bg-dark fs-5 mx-1 mt-1'>Population ".htmlspecialchars(number_format($purok['population_count'], 0))."</span>
                            <span class='badge bg-dark fs-5 mx-1 mt-1'>Predicted ". htmlspecialchars(number_format($purok['predicted_population'], 0)) ."</span></div>
                            <div class='mb-3 mt-3'>
                                <div class='row'>
                                    <div class='col'>
                                        <div class='d-flex'>
                                            <div class='bs-icon-sm bs-icon-circle bs-icon-primary-light d-flex justify-content-center align-items-center d-inline-block mb-3 bs-icon mx-1'><svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' fill='currentColor' viewBox='0 0 16 16' class='bi bi-gender-male'>
                                                    <path fill-rule='evenodd' d='M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8'></path>
                                                </svg></div>
                                            <div class='text-center'>
                                                <p class='fw-bold mb-0'>Male</p><span class='badge bg-primary'>Population ".htmlspecialchars(number_format($purok['total_male'], 0))."</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col'>
                                        <div class='d-flex'>
                                            <div class='bs-icon-sm bs-icon-circle bs-icon-primary-light d-flex justify-content-center align-items-center d-inline-block mb-3 bs-icon mx-1'><svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' fill='currentColor' viewBox='0 0 16 16' class='bi bi-gender-female'>
                                                    <path fill-rule='evenodd' d='M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8M3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5'></path>
                                                </svg></div>
                                            <div class='text-center'>
                                                <p class='fw-bold mb-0'>Female</p><span class='badge bg-danger'>Population ".htmlspecialchars(number_format($purok['total_female'], 0))."</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><button class='btn btn-primary w-100' type='button' data-bs-target='#predict-modal' data-bs-toggle='modal' data-id='".htmlspecialchars($purok['purok'])."'>Predict</button>
                        </div>
                    </div>
                </div>
            </div>
         ";
}

echo "</ul>";
?>
       
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="view-table">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Table Population</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                    <div class="table-responsive table mt-2"  role="grid" aria-describedby="dataTable_info">
                        <table class="table table-striped nowrap" cellspacing="0" id="dataTable">
                            <thead>
                                <tr>
                                    <th>PUROK</th>
                                    <th>POPULATION</th>
                                    <th>PREDICTED POPULATION</th>
                                    <th>POPULATION MALE</th>
                                    <th>PREDICTED MALE</th>
                                    <th>POPULATION FEMALE</th>
                                    <th>PREDICTED FEMALE</th>
                                    <th>GROWTH RATE</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>PUROK</th>
                                    <th>POPULATION</th>
                                    <th>PREDICTED POPULATION</th>
                                    <th>POPULATION MALE</th>
                                    <th>PREDICTED MALE</th>
                                    <th>POPULATION FEMALE</th>
                                    <th>PREDICTED FEMALE</th>
                                    <th>GROWTH RATE</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button">Save</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="predict-modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Manual Prediction</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" name="purok_name">
                        <p>Here you can manually predict. (ambot ikaw na butang unsa description diri)</p>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3"><input class="form-control form-control" placeholder="Confirm Password" name="start_date" type="date"><label class="form-label" for="floatingInput">Starting Date</label></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3"><input class="form-control form-control" placeholder="New Password" name="end_date" type="date"><label class="form-label" for="floatingInput">End Date</label></div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-center" id="title_purok_name">ORCHIDS</h4>
                            <p class="text-center">Population</p>
                            <div class="d-flex justify-content-xl-center">
                                <div class="bs-icon-sm bs-icon-circle bs-icon-primary-light d-flex justify-content-center align-items-center d-inline-block mb-3 bs-icon mx-1"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-pie-chart-fill">
                                    <path d="M15.985 8.5H8.207l-5.5 5.5a8 8 0 0 0 13.277-5.5zM2 13.292A8 8 0 0 1 7.5.015v7.778l-5.5 5.5zM8.5.015V7.5h7.485A8.001 8.001 0 0 0 8.5.015z"></path>
                                </svg></div>
                                <div class="text-center">
                                    <p class="fw-bold mb-0">Predicted Population</p><span class="badge bg-primary fs-4" id="predicted_total">Population 0</span>
                                </div>
                            </div>
                            <div></div>
                            <div class="mb-3 mt-3"></div>
                            <div class="mb-3 mt-3">
                                <div class="row">
                                    <div class="col">
                                        <div class="d-flex justify-content-xl-center">
                                            <div class="bs-icon-sm bs-icon-circle bs-icon-primary-light d-flex justify-content-center align-items-center d-inline-block mb-3 bs-icon mx-1"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-gender-male">
                                                <path fill-rule="evenodd" d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8"></path>
                                            </svg></div>
                                            <div class="text-center">
                                                <p class="fw-bold mb-0">Male</p><span class="badge bg-primary" id="predicted_male">Population 0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="d-flex justify-content-xl-center">
                                            <div class="bs-icon-sm bs-icon-circle bs-icon-primary-light d-flex justify-content-center align-items-center d-inline-block mb-3 bs-icon mx-1"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-gender-female">
                                                <path fill-rule="evenodd" d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8M3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5"></path>
                                                </svg></div>
                                            <div class="text-center">
                                                <p class="fw-bold mb-0">Female</p><span class="badge bg-danger" id="predicted_female">Population 0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><button class="btn btn-primary w-100" type="submit">Predict</button>
                    </form>
                    </div>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>


    
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script src="assets/js/jszip.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/sweetalert2.all.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        $(document).ready(function() {
            
            $('form').submit(function(event) {
                event.preventDefault();
                var formDataArray = $(this).serializeArray();
                var formData = {};

                $.each(formDataArray, function(index, field) {
                    formData[field.name] = field.value;
                });

                var jsonData = JSON.stringify(formData);
                console.log(jsonData);

                $.ajax({
                    url: 'http://127.0.0.1:5000/predicted_purok_sex',
                    type: 'POST',
                    data: jsonData,
                    contentType: 'application/json',
                    success: function(response) {
                        console.log(response);

                        var predictedPopulation = response.predicted_population;
                        
                        var malePopulation = predictedPopulation.find(function(item) {
                            return item.sex === "Male";
                        });

                        var femalePopulation = predictedPopulation.find(function(item) {
                            return item.sex === "Female";
                        });

                        if (predictedPopulation.length > 0) {
                            if (malePopulation) {
                                $('#predicted_male').text("Population " + formatNumber(malePopulation.predicted_population));
                            }
    
                            if (femalePopulation) {
                                $('#predicted_female').text("Population " + formatNumber(femalePopulation.predicted_population));
                            }
                            var totalPopulation = (femalePopulation.predicted_population + malePopulation.predicted_population);
                            $('#predicted_total').text("Population " + formatNumber(totalPopulation));
                        } else {
                            swal.fire({
                                title: 'Error',
                                text: 'An error occurred while predicting the population',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(error) {
                        swal.fire({
                            title: 'Error',
                            text: 'An error occurred while predicting the population',
                            icon: 'error'
                        });
                    }
                });
            });

            


                $(document).on("click", 'button[data-bs-target="#predict-modal"]', function () {
                    var id = $(this).data("id");
                    $('input[name="purok_name"]').val(id);
                    $('#title_purok_name').text(id);
                    $('#predicted_female').text("Population 0");
                    $('#predicted_male').text("Population 0");
                    $('#predicted_total').text("Population 0")
                    console.log(id);
                });
                
                function formatNumber(number) {
                    try {
                        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    } catch (error) {
                        swal.fire({
                            title: 'Error',
                            text: 'An error occurred while predicting the population base on your input',
                            icon: 'error'
                        });
                    }
                }



                $(document).on("click", 'a[data-bs-target="#view-table"]', function () {
                    if (typeof table !== 'undefined' && $.fn.DataTable.isDataTable(table)) {
                        table.destroy();
                    }
                    table = new DataTable("#dataTable", {
                        ajax: 'http://localhost:5000/predicted_population_table/2029',
                        processing: true,
                        serverSide: true,
                        pageLength: 50,
                        dom: '<"top"Bfrtip<"clear">',
                        buttons: [
                            {
                                extend: "excel",
                                title:
                                    "UMLTFIPG - Utilizing Machine Learning Technique to Forecast the Influence of Population Growth on the Budget of Barangay Begong",
                                className: "btn btn-primary",
                                text: '<i class="fa fa-file-excel"></i> EXCEL',
                            },
                            {
                                extend: "pdf",
                                title:
                                    "UMLTFIPG - Utilizing Machine Learning Technique to Forecast the Influence of Population Growth on the Budget of Barangay Begong",
                                className: "btn btn-primary",
                                text: '<i class="fa fa-file-pdf"></i> PDF',
                            },
                            {
                                extend: "print",
                                className: "btn btn-primary",
                                text: '<i class="fa fa-print"></i> Print',
                                title:
                                    "UMLTFIPG - Utilizing Machine Learning Technique to Forecast the Influence of Population Growth on the Budget of Barangay Begong",
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
                                        return 'Details for ' + data[0];
                                    }
                                }),
                                renderer: DataTable.Responsive.renderer.tableAll({
                                    tableClass: 'table'
                                })
                            }
                        },
                        initComplete: function () {
                            $('#dataTable').show();
                        },
                        drawCallback: function () {
                            $('#dataTable').show();
                        },
                        preDrawCallback: function () {
                            $('#dataTable').hide();
                        }
                    });
                });



            });
    </script>
    
</body>

</html>
