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
    var barangay = $(this).data("barangay");
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
    $('select[name="barangay"]').val(barangay).trigger('change');

    console.log(`Setting purok to: ${purok}`);
    if ($('select[name="purok"] option[value="' + purok + '"]').length > 0) {
        $('select[name="purok"]').val(purok).trigger('change');
    } else {
        // Add options to the purok select based on the selected barangay
        populatePurokOptions(barangay, purok);
    }

    console.log(id, barangay, purok);
  });

  $(document).on("click", 'button[data-bs-target="#remove"]', function () {
    var id = $(this).data("id");
    $('input[name="data_id"]').val(id);
    console.log(id);
  });

  const purokMapping = {
    "Nilo": ["Purok 1", "Purok 2", "Purok 3", "Purok 4", "Purok 5", "Purok 6", "Purok 7"],
    "Longmot": ["Paghimakas", "Pagbangon", "Pag-asa", "Pagkakaisa", "Pagpupunyagi", "Pagmamahal", "Paglinang", "Paglingap", "Pagdiriwang", "Pagkakaisa"],
    "Caluma": ["Masipag", "Masagana", "Mataas", "Matatag", "Maunlad", "Magalang", "Magiliw", "Makisig", "Malakas", "Malusog"],
    "Mate": ["Katapatan", "Karangalan", "Kagitingan", "Kalayaan", "Kabayanihan", "Kasipagan", "Kaalaman", "Kabaitan", "Kasaysayan", "Katotohanan"],
    "Timolan": ["Dalandan", "Kalabasa", "Pakwan", "Melon", "Pinya", "Saging", "Lanzones", "Mangosteen", "Chico", "Bayabas"],
    "Libayoy": ["Kalapati", "Maya", "Lawin", "Agila", "Tagak", "Ibon", "Pugo", "Kuwago", "Itik", "Bibe"],
    "Guinlin": ["Alitaptap", "Paruparo", "Tutubi", "Gagamba", "Salagubang", "Lamok", "Bubuyog", "Tipaklong", "Langgam", "Uod"],
    "Limas": ["Talon", "Batis", "Ilog", "Lawa", "Sapa", "Bukal", "Baybay", "Dalampasigan", "Tubig", "Buruwisan"],
    "Maragang": ["Tala", "Bituin", "Araw", "Buwan", "Sinag", "Kalangitan", "Alapaap", "Ulap", "Silahis", "Hatinggabi"],
    "Busol": ["Dagohoy", "Silang", "Luna", "Mabini", "Rizal", "Bonifacio", "Sakay", "Kudarat", "Tamblot", "Sulayman"],
    "Diana Countryside": ["Buhay", "Liwanag", "Tahimik", "Kapayapaan", "Pagkakaisa", "Matatag", "Malaya", "Sipag", "Tiwala", "Pag-ibig"],
    "Lacupayan": ["Banaba", "Kamagong", "Narra", "Molave", "Yakal", "Tindalo", "Mahogany", "Gmelina", "Mangga", "Santol"],
    "Upper Nilo": ["Ilang-ilang", "Rosas", "Dama de Noche", "Rosal", "Magnolia", "Camia", "Santan", "Gumamela", "Sampaguita", "Kalachuchi"],
    "Lacarayan": ["Silangan", "Kanluran", "Sikatuna", "Caraballo", "Pinatubo", "Apo", "Sierra Madre", "Banahaw", "Makiling", "Halcon"],
    "Nangan-Nangan": ["Magsaysay", "Rizal", "Quezon", "Mabini", "Bonifacio", "Jacinto", "Luna", "Burgos", "Gomburza", "Del Pilar"],
    "New Tuboran": ["Bulaklak", "Kaunlaran", "Kabataan", "Mayon", "Waling-waling", "Sinagtala", "Lakambini", "Haribon", "Sampaguita", "Salamat"],
    "Tigbao": ["Maligaya", "Pag-asa", "Maharlika", "Masagana", "Kalikasan", "Mabuhay", "Bayanihan", "Katipunan", "Luntian", "Bagong Silang"]
};

  document.getElementById('barangay-select').addEventListener('change', function() {
      const selectedBarangay = this.value;
      const purokSelect = document.getElementById('purok-select');

      purokSelect.innerHTML = '';

      if (purokMapping[selectedBarangay]) {
          purokMapping[selectedBarangay].forEach(purok => {
              const option = document.createElement('option');
              option.value = purok;
              option.textContent = purok;
              purokSelect.appendChild(option);
          });
      }
  });

  document.getElementById('barangay-select-update').addEventListener('change', function() {
    const selectedBarangay = this.value;
    const purokSelect = document.getElementById('purok-select-update');

    purokSelect.innerHTML = '';

    if (purokMapping[selectedBarangay]) {
        purokMapping[selectedBarangay].forEach(purok => {
            const option = document.createElement('option');
            option.value = purok;
            option.textContent = purok;
            purokSelect.appendChild(option);
        });
    }
});

function populatePurokOptions(barangay, selectedPurok) {
  const purokSelect = document.getElementById('purok-select-update');
  purokSelect.innerHTML = '';

  if (purokMapping[barangay]) {
      purokMapping[barangay].forEach(purok => {
          const option = document.createElement('option');
          option.value = purok;
          option.textContent = purok;
          purokSelect.appendChild(option);
      });

      // Set the purok value after options are populated
      purokSelect.value = selectedPurok;
  }
}

});
