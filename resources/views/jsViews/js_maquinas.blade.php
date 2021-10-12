<script type="text/javascript">

function deleteMaquina(idMaquina) {
    swal({
      title: 'Eliminar esta Maquina',
      text: "¿Desea eliminar esta Maquina?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Si, eliminar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      if (result.value) {
        $.getJSON("maquina/eliminar/"+idMaquina, function(json) { 
            if (json==true) {
                mensaje('Actualizado con exito', 'success');
                location.reload();
            }
        })
      }
    })
}


</script>