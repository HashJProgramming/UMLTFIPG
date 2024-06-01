<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link href="assets/css/datatables.min.css" rel="stylesheet">

    
</head>
<body>
    <div class="container-fluid">
        <div class="table-responsive">
        <table class="table table-bordered table-striped nowrap" cellspacing="0" id="dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Lastname</th>
                        <th>Firstname</th>
                        <th>Middlename</th>
                        <th>Suffix</th>
                        <th>Phone</th>
                        <th>Purok</th>
                        <th>Phone</th>
                        <th>Sex</th>
                        <th>Age</th>
                        <th>Birthdate</th>
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
                        <th>Purok</th>
                        <th>Phone</th>
                        <th>Sex</th>
                        <th>Age</th>
                        <th>Birthdate</th>
                        <th class="text-center">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script>

        $(document).ready(function() {

            var table = new DataTable("#dataTable", {
                ajax: 'functions/scripts/server_residents.php',
                processing: true,
                serverSide: true,
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
                                return 'Details for ' + data[1];
                            }
                        }),
                        renderer: DataTable.Responsive.renderer.tableAll({
                            tableClass: 'table'
                        })
                    }
                }
            });
        });

    </script>
</body>
</html>