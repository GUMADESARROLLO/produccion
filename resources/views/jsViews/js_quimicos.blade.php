<script type="text/javascript">
    let dtQuimicos;
    $(document).ready(function () {
        $.ajax({
            url: "getQuimicos",
            type: 'get',
            async: false,
            success: function(response) {
                $('#tblQuimicos').DataTable({
                    "data":response,
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
                    "columns": [{
                        "data": "codigo", "render": function(data, type, row, meta) {
                          return  `<div class="text-center">
                                      <h6 class="mb-0 fw-semi-bold">`+row.codigo+`</h6>
                                    </div>`
                          }
                    },
                        {
                            "data": "descripcion"
                        },
                        {
                            "data": "unidad"
                        },
                        {
                            "data": "idQuimico",
                            "render": function (data, type, row) {
                                return '<div class="text-center"> <a href="#!" onclick="deleteQuimico(' + data + ')"><i class="far fa-trash-alt text-c-red f-20 m-r-10"></i></a>' +
                                    ' <a href="quimico/editar-quimico/' + data + '"><i class="far fa-edit text-c-blue f-20 m-r-10"></i></a></div>';
                            }
                        },
                    ],
                });
            }
        })
           

        $("#tblQuimicos_filter").hide();
        $("#tblQuimicos_length").hide();
        $('#cont_search').show();
        $('#InputBuscar').on('keyup', function () {
            var table = $('#tblQuimicos').DataTable();
            table.search(this.value).draw();
        });
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
                $.getJSON("quimico/eliminar-quimico/" + idQuimico, function (json) {
                    if (json == true) {
                        location.reload();
                    }
                })
            }
        })
    }
</script>
