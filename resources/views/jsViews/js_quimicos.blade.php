<script type="text/javascript">

$(document).ready(function() {

});


function deleteQuimico(idQuimico) {
    swal({
      title: 'Eliminar este quimico',
      text: "¿Desea eliminar este quimico?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',   
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Si, eliminar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      mensaje('Actualizado con exito', 'success');
      if (result.value) {
        $.getJSON("quimico/eliminar-quimico/"+idQuimico, function(json) { 
            if (json==true) {
                location.reload();                
            }
        })
      }
    })
}


</script>