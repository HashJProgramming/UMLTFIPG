$(document).ready(function () {
  $("form").submit(function (event) {
    event.preventDefault();
    var formDataArray = $(this).serializeArray();
    var formData = {};

    $.each(formDataArray, function (index, field) {
      formData[field.name] = field.value;
    });

    var jsonData = JSON.stringify(formData);
    console.log(jsonData);

    $.ajax({
      url: "http://192.168.100.4:5000/predicted_budget_select",
      type: "POST",
      data: jsonData,
      contentType: "application/json",
      success: function (response) {
        console.log(response);

        var predictedTotal = response.predicted_budget;
        if (predictedTotal.length > 0) {
          $("#predicted_total").text(
            "Budget Predicted ₱" +
              formatNumber(
                predictedTotal[0].predicted_budget +
                  predictedTotal[0].current_budget
              )
          );
        } else {
          swal.fire({
            title: "Error",
            text: "An error occurred while predicting the population",
            icon: "error",
          });
        }
      },
      error: function (error) {
        swal.fire({
          title: "Error",
          text: "An error occurred while predicting the population",
          icon: "error",
        });
      },
    });

    $.ajax({
      url: "http://192.168.100.4/UMLTFIPG/functions/get-chart-budget.php",
      type: "POST",
      data: jsonData,
      contentType: "application/json",
      success: function (response) {
        // console.log(response);
        // Parse the JSON response
        var chartData = JSON.parse(response);

        // Update the chart's data and labels
        chart.data.labels = chartData.labels;
        chart.data.datasets[0].data = chartData.datasets[0].data;

        // Redraw the chart with the new data
        chart.update();
      },
      error: function (error) {
        swal.fire({
          title: "Error",
          text: "An error occurred while predicting the budget",
          icon: "error",
        });
      },
    });
  });

  $(document).on(
    "click",
    'button[data-bs-target="#predict-modal"]',
    function () {
      var id = $(this).data("id");
      var name = $(this).data("name");
      $('input[name="budget_id"]').val(id);
      $("#title_project_name").text(name);
      $("#predicted_total").text("Budget Predicted ₱0");
      console.log(id, name);
    }
  );

  function formatNumber(number) {
    try {
      return number.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    } catch (error) {
      swal.fire({
        title: "Error",
        text: "An error occurred while predicting the population base on your input",
        icon: "error",
      });
    }
  }

  $(document).on("click", 'a[data-bs-target="#view-table"]', function () {
    if (typeof table !== "undefined" && $.fn.DataTable.isDataTable(table)) {
      table.destroy();
    }
    table = new DataTable("#dataTable", {
      ajax: "http://192.168.100.4:5000/predicted_budget_table/2029",
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
              return "Details for " + data[0];
            },
          }),
          renderer: DataTable.Responsive.renderer.tableAll({
            tableClass: "table",
            modalClass: "modal-dialog-centered"
          }),
        },
      },
      columnDefs: [
        {
          targets: 2,
          render: function (data, type, row) {
            return (
              "₱" +
              parseFloat(data)
                .toFixed(2)
                .replace(/\d(?=(\d{3})+\.)/g, "$&,")
            );
          },
        },
        {
          targets: 3,
          render: function (data, type, row) {
            return (
              "₱" +
              parseFloat(data)
                .toFixed(2)
                .replace(/\d(?=(\d{3})+\.)/g, "$&,")
            );
          },
        },
      ],
      initComplete: function () {
        $("#dataTable").show();
      },
      drawCallback: function () {
        $("#dataTable").show();
      },
      preDrawCallback: function () {
        $("#dataTable").hide();
      },
    });
  });
});
