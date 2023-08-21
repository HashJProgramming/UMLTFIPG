// Hash'J Programming - https://github.com/HashJProgramming
/*  ==========================================
    SHOW UPLOADED IMAGE
* ========================================== */
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imageResult')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imageResult2')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$(function () {
    $('#upload').on('change', function () {
        readURL(input);
        uploadimage('upload')
    });
    $('#upload2').on('change', function () {
        readURL2(input2);
        uploadimage('upload2')
    });
});

// Hash'J Programming - https://github.com/HashJProgramming
/*  ==========================================
    SHOW UPLOADED IMAGE NAME
* ========================================== */
var input = document.getElementById( 'upload' );
var infoArea = document.getElementById( 'upload-label' );
var urllink = document.getElementById( 'urllink' );

var input2 = document.getElementById( 'upload2' );
var infoArea2 = document.getElementById( 'upload-label2' );
var urllink2 = document.getElementById( 'urllink2' );


input.addEventListener( 'change', showFileName );
input2.addEventListener( 'change', showFileName2 );

function showFileName( event ) {
  var input = event.srcElement;
  var fileName = input.files[0].name;
  infoArea.textContent = 'File name: ' + fileName;
}

function showFileName2( event ) {
    var input = event.srcElement;
    var fileName = input.files[0].name;
    infoArea2.textContent = 'File name: ' + fileName;
  }

function uploadimage(input_tag) {

var file = document.getElementById(input_tag);
var form = new FormData();
form.append("image", file.files[0])
}


$(document).on('dragstart dragenter dragover', function(event) {    
        $('#image-drag-drop').removeClass('d-none');     // Show the drop zone
    dropZoneVisible= true;
    
}).on('drop dragleave dragend', function (event) {

    
    dropZoneTimer= setTimeout( function(){
        if( !dropZoneVisible ) {
            $('#image-drag-drop').addClass('d-none'); 
        }
    }, 50   ); // dropZoneHideDelay= 70, but anything above 50 is better
    clearTimeout(dropZoneTimer);
        

});