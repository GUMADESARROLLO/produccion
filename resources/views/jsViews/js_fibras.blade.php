<script type="text/javascript">

$(document).ready(function() {

});


function deleteFibra(idFibra) {
    swal({
      title: 'Eliminar esta Fibra',
      text: "¿Desea eliminar esta Fibra?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Si, eliminar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      mensaje('Actualizado con exito', 'success');
      if (result.value) {
        $.getJSON("fibras/eliminar/"+idFibra, function(json) { 
            if (json==true) {
                location.reload();                
            }
        })
      }
    })
}


</script>