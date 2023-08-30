<script type="text/javascript">
	$(document).ready(function() {
		//inicializaControlFecha();
		$('#tbl_usuario').DataTable({
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
		$("#tbl_usuario_filter").hide();
	    $("#tbl_usuario_length").hide();

	});

	function deleteUser(idUser) {
		swal({
			title: 'Desactivar este usuario',
			text: "¿Desea Desactivar este usuario?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Si, eliminar',
			cancelButtonText: 'Cancelar',
		}).then((result) => {
			mensaje('Actualizado con exito', 'success');
			if (result.value) {
				$.getJSON("user/eliminar/" + idUser, function(json) {
					if (json == true) {
						location.reload();
					}
				})
			}
		})
	}


	function activeUser(idUser) {
		swal({
			title: 'Activar usuario',
			text: "¿Desea activar a este usuario?",
			type: 'question',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Si, Activar',
			cancelButtonText: 'Cancelar',
		}).then((result) => {
			mensaje('Actualizado con exito', 'success');
			if (result.value) {
				$.getJSON("user/activar/" + idUser, function(json) {
					if (json == true) {
						location.reload();
					}
				})
			}
		})
	}

</script>