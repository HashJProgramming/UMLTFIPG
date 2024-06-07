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
      url: "functions/get-chart-barangay-population.php",
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
          text: "An error occurred while predicting the population",
          icon: "error",
        });
      },
    });

    $.ajax({
      url: "http://localhost:5000/predicted_barangay_sex",
      type: "POST",
      data: jsonData,
      contentType: "application/json",
      success: function (response) {
        console.log(response);

        var predictedPopulation = response.predicted_population;

        var malePopulation = predictedPopulation.find(function (item) {
          return item.sex === "Male";
        });

        var femalePopulation = predictedPopulation.find(function (item) {
          return item.sex === "Female";
        });

        if (predictedPopulation.length > 0) {
          if (malePopulation) {
            $("#predicted_male").text(
              "Population " + formatNumber(malePopulation.predicted_population)
            );
          }

          if (femalePopulation) {
            $("#predicted_female").text(
              "Population " +
                formatNumber(femalePopulation.predicted_population)
            );
          }
          var totalPopulation =
            femalePopulation.predicted_population +
            malePopulation.predicted_population;
          $("#predicted_total").text(
            "Population " + formatNumber(totalPopulation)
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
  });

  $(document).on(
    "click",
    'button[data-bs-target="#predict-modal"]',
    function () {
      var id = $(this).data("id");
      $('input[name="barangay_name"]').val(id);
      $("#title_barangay_name").text(id);
      $("#predicted_female").text("Population 0");
      $("#predicted_male").text("Population 0");
      $("#predicted_total").text("Population 0");
      console.log(id);
    }
  );

  function formatNumber(number) {
    try {
      return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
    const currentYear = new Date().getFullYear();
    const targetYear = currentYear + 5;
    table = new DataTable("#dataTable", {
      ajax: `http://localhost:5000/predicted_barangay_population_table/${targetYear}`,
      processing: true,
      serverSide: true,
      pageLength: 50,
      dom: '<"top"Bfrtip<"clear">',
      buttons: [
        {
          extend: "excel",
          title:
            "UMLTFIPG - Utilizing Machine Learning Technique to Forecast the Influence of Population Growth",
          className: "btn btn-primary",
          text: '<i class="fa fa-file-excel"></i> EXCEL',
        },
        {
          extend: "pdf",
          title:
            "UMLTFIPG - Utilizing Machine Learning Technique to Forecast the Influence of Population Growth",
          className: "btn btn-primary",
          text: '<i class="fa fa-file-pdf"></i> PDF',
        },
        {
          extend: "print",
          className: "btn btn-primary",
          text: '<i class="fa fa-print"></i> Print',
          title:
            "UMLTFIPG - Utilizing Machine Learning Technique to Forecast the Influence of Population Growth",
          autoPrint: true,
          exportOptions: {
            columns: ":visible",
          },
          customize: function (win) {
            $(win.document.body)
              .find("table")
              .addClass("display")
              .css("font-size", "5px");
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
          }),
        },
        modalCreated: function (modal) {
          $(modal).find('.modal-dialog').addClass('modal-dialog-centered');
        }
      },
      columnDefs: [
        {
          targets: 1,
          render: function (data, type, row) {
            return parseFloat(data)
              .toFixed(0)
              .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          },
        },
        {
          targets: 2,
          render: function (data, type, row) {
            return parseFloat(data)
              .toFixed(0)
              .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          },
        },
        {
          targets: 3,
          render: function (data, type, row) {
            return parseFloat(data)
              .toFixed(0)
              .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          },
        },
        {
          targets: 4,
          render: function (data, type, row) {
            return parseFloat(data)
              .toFixed(0)
              .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          },
        },
        {
          targets: 5,
          render: function (data, type, row) {
            return parseFloat(data)
              .toFixed(0)
              .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          },
        },
        {
          targets: 6,
          render: function (data, type, row) {
            return parseFloat(data)
              .toFixed(0)
              .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
