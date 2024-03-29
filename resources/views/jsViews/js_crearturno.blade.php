<script type="text/javascript">
$(document).ready(function() {
		$('#tbl_turno').DataTable({
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
		$("#tbl_turno_filter").hide();
	  $("#tbl_turno_length").hide();

  $(function () {
    $('.datetimepicker_').datetimepicker({
      format: 'LT'
    });
  });
});


/*function deleteTurno() {
    swal({
      title: '¿Desea eliminar este turno?',
      text: "(Quedara un espacio libre si elimina este registro)",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, eliminar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      if (result.value) {
        alert('eliminado')
      }
    })
}*/

function deleteTurno(idTurno) {
    swal({
      title: 'Eliminar este turno',
      text: "¿Desea eliminar este registro?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Si, eliminar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      mensaje('Actualizado con exito', 'success');
      if (result.value) {
        $.getJSON("turno/eliminar/"+idTurno, function(json) {
            if (json==true) {
                location.reload();
            }
        })
      }
    })
}


</script>
