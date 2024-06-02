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

  var table = new DataTable("#dataTable", {
    ajax: "functions/scripts/server_residents.php",
    processing: true,
    serverSide: true,
    pageLength: 20,
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

  $(document).on("click", 'button[data-bs-target="#update"]', function () {
    var id = $(this).data("id");
    var firstname = $(this).data("firstname");
    var lastname = $(this).data("lastname");
    var middlename = $(this).data("middlename");
    var suffix = $(this).data("suffix");
    var birthdate = $(this).data("birthdate");
    var phone = $(this).data("phone");
    var sex = $(this).data("sex");
    var address = $(this).data("address");
    var purok = $(this).data("purok");

    $('input[name="data_id"]').val(id);
    $('input[name="firstname"]').val(firstname);
    $('input[name="lastname"]').val(lastname);
    $('input[name="middlename"]').val(middlename);
    $('input[name="suffix"]').val(suffix);
    $('input[name="birthdate"]').val(birthdate);
    $('input[name="phone"]').val(phone);
    $('input[name="sex"]').val(sex);
    $('input[name="address"]').val(address);
    $('select[name="purok"]').val(purok);

    console.log(id, purok);
  });

  $(document).on("click", 'button[data-bs-target="#remove"]', function () {
    var id = $(this).data("id");
    $('input[name="data_id"]').val(id);
    console.log(id);
  });
});
