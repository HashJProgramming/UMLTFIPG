// Hash'J Programming - https://github.com/HashJProgramming
$(document).ready(function() {
    const currentPath = window.location.pathname;
    const urlParams = new URLSearchParams(window.location.search);
    const type = urlParams.get('type');
    const message = urlParams.get('message');
    
new DataTable('table.table-display',{
    dom: '<"top"Bfrtip<"clear">',
    buttons: [
        
        { 
            extend: 'excel', 
            title: 'UMLTFIPG - Utilizing Machine Learning Technique to Forecast the Influence of Population Growth on the Budget of Barangay Begong', 
            className: 'btn btn-primary',
            text: '<i class="fa fa-file-excel"></i> EXCEL'
        },
        {
            extend: 'pdf',
            title: 'UMLTFIPG - Utilizing Machine Learning Technique to Forecast the Influence of Population Growth on the Budget of Barangay Begong', 
            className: 'btn btn-primary',
            text: '<i class="fa fa-file-pdf"></i> PDF'
        },
        { 
            extend: 'print', 
            className: 'btn btn-primary',
            text: '<i class="fa fa-print"></i> Print',
            title: 'UMLTFIPG - Utilizing Machine Learning Technique to Forecast the Influence of Population Growth on the Budget of Barangay Begong', 
            autoPrint: true,
            exportOptions: {
                columns: ':visible',
            },
            customize: function (win) {
                $(win.document.body).find('table').addClass('display').css('font-size', '9px');
                $(win.document.body).find('tr:nth-child(odd) td').each(function(index){
                    $(this).css('background-color','#D0D0D0');
                });
                $(win.document.body).find('h1').css('text-align','center');
            }
        }
    ]
});

// VANTA.WAVES({
//     el: "#bg-animation",
//     mouseControls: false,
//     touchControls: true,
//     gyroControls: false,
//     minHeight: 200.00,
//     minWidth: 200.00,
//     scale: 1.00,
//     scaleMobile: 1.00,
//     color: 0xb7b7c0,
//     waveSpeed: 1.00,
//     zoom: 0.60
//   })  
    
    if (type == 'success') {
        Swal.fire(
            'Success!',
             message,
            'success'
          )
    } else if (type == 'error') {
        Swal.fire(
            'Error!',
             message,
            'error'
          )
    }
    
    if (currentPath.includes("UMLTFIPG/residents.php")) {
        $('button[data-bs-target="#update"]').on('click', function() {
            var id = $(this).data('id');
            var firstname = $(this).data('firstname');
            var lastname = $(this).data('lastname');
            var middlename = $(this).data('middlename');
            var suffix = $(this).data('suffix');
            var birthdate = $(this).data('birthdate');
            var phone = $(this).data('phone');
            var sex = $(this).data('sex');
            var address = $(this).data('address');

            $('input[name="data_id"]').val(id);
            $('input[name="firstname"]').val(firstname);
            $('input[name="lastname"]').val(lastname);
            $('input[name="middlename"]').val(middlename);
            $('input[name="suffix"]').val(suffix);
            $('input[name="birthdate"]').val(birthdate);
            $('input[name="phone"]').val(phone);
            $('input[name="sex"]').val(sex);
            $('input[name="address"]').val(address);
            
            console.log(id);
        });
        $('button[data-bs-target="#remove"]').on('click', function() {
            var id = $(this).data('id');
            $('input[name="data_id"]').val(id); 
            console.log(id);
        });
      } else if (currentPath.includes("UMLTFIPG/project.php")) {
        $('button[data-bs-target="#update"]').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var description = $(this).data('description');
            
            $('input[name="data_id"]').val(id);
            $('input[name="name"]').val(name);
            $('textarea[name="description"]').val(description);
        });
        $('button[data-bs-target="#remove"]').on('click', function() {
            var id = $(this).data('id');
            $('input[name="data_id"]').val(id); 
            console.log(id);
        });
      } else {
        console.log("The URL is neither /customer nor /list");
      }



    // $('a[data-bs-target="#remove"]').on('click', function() {
    //     var id = $(this).data('id');
    //     console.log(id); 
    //     $('input[name="data_id"]').val(id);
    // });

} );
