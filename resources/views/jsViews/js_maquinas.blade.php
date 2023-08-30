<script type="text/javascript">
	$(document).ready(function() {
		//inicializaControlFecha();
		$('#tbl_maquinas').DataTable({
			"destroy" : true,
			"info":    false,
			"lengthMenu": [[10,-1], [10,"Todo"]],
			"language": {
				"zeroRecords": "NO HAY COINCIDENCIAS",
				"paginate": {
					"first":      "Primera",
					"last":       "Última ",
					"next":       "Siguiente",
					"previous":   "Anterior"
				},
				"lengthMenu": "MOSTRAR _MENU_",
				"emptyTable": "REALICE UNA BUSQUEDA",
				"search":     "BUSCAR"
			},
		})
		$("#tbl_maquinas_filter").hide();
	  $("#tbl_maquinas_length").hide();

	});
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