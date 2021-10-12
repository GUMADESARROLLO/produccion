<script type="text/javascript">

function deleteProducto(idProducto) {
    swal({
      title: 'Eliminar este producto',
      text: "¿Desea eliminar este producto?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Si, eliminar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      mensaje('Actualizado con exito', 'success');
      if (result.value) {
        $.getJSON("producto/eliminar/"+idProducto, function(json) { 
            if (json==true) {
                location.reload();                
            }
        })
      }
    })
}


</script>