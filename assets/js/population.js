const currentPath = window.location.pathname;
const urlParams = new URLSearchParams(window.location.search);
const type = urlParams.get("type");
const message = urlParams.get("message");

$(document).ready(function () {
  if (type == "success") {
    Swal.fire("Success!", message, "success");
  } else if (type == "error") {
    Swal.fire("Error!", message, "error");
  }

  new DataTable("#dataTable-1", {
    ajax: "functions/scripts/server_population_male.php",
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
            return "Details for " + data[1];
          },
        }),
        renderer: DataTable.Responsive.renderer.tableAll({
          tableClass: "table",
        }),
      },
    },
  });

  new DataTable("#dataTable-2", {
    ajax: "functions/scripts/server_population_female.php",
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
            return "Details for " + data[1];
          },
        }),
        renderer: DataTable.Responsive.renderer.tableAll({
          tableClass: "table",
        }),
      },
    },
  });
});
