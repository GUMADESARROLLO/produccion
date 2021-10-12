<script type="text/javascript">
$(document).ready(function() {
    alert('hola mundo');
});

$("#btnactualizar").click( function(e) {
    var data = new Array();
    var i = 0;

    tabla = $('#dtInventario').DataTable();

    tabla.rows().data().each( function (index,value) {
        data[i] = tabla.row(i).data();
        i++;
    });

    /*if (data_1.length==0) {
        mensaje("Ups...al parecer ha ocurrido un problema", "error");
    }else {
        var form_data = {
            data : data_1
        }
        $.ajax({
          url: base_url+'index.php/cal_ir',
          data: form_data,
          type: 'POST',
          async: true,
          success: function (resultado) {
              if (resultado) {
                mensaje("Se generó correctamente el proceso", "success");
                $("#loader-1").append(`<p class="font-italic" style="color:green; font-size: 18px">Se generó correctamente el proceso</p>`);
              }else {
                mensaje("ups... ocurrio un problema al guardar", "error");
              }
          }
        }).done(function(data) {
            loadingPage(false);
        });
    }*/
});

</script>