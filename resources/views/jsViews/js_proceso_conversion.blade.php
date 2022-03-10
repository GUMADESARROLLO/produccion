<script type="text/javascript">
    var dtConversion;
    $(document).ready(function() {

        $('#InputBuscar').on('keyup', function() {
            var table = $('#tblConversion').DataTable();
            table.search(this.value).draw();
        });
        $('#tblConversion').DataTable({
            'ajax': {
                "url": "getOrdenes",
                'dataSrc': '',
            },
            "destroy": true,
            "info": false,
            "language": {
                "zeroRecords": "NO HAY COINCIDENCIAS",
                "paginate": {
                    "first": "Primera",
                    "last": "Última ",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "lengthMenu": "MOSTRAR _MENU_",
                "emptyTable": "REALICE UNA BUSQUEDA UTILIZANDO LOS FILTROS DE FECHA",
                "search": "BUSCAR"
            },
            'columns': [{
                    "title": "id",
                    "data": "id"
                },
                {
                    "title": "N° ORDEN",
                    "data": "num_orden"
                },
                {
                    "title": "PRODUCTO",
                    "data": "nombre"
                },
                {
                    "title": "FECHA INICIAL",
                    "data": "fecha_hora_inicio"
                },
                {
                    "title": "FECHA FINAL",
                    "data": "fecha_hora_final"
                },
                {
                    "title": "HORAS TRABAJADAS",
                    "data": "Hrs_trabjadas",
                    "render": $.fn.dataTable.render.number(',', '.', 2)

                },
                {
                    "title": "PESO %",
                    "data": "PESO_PORCENT",
                    "render": function(data, type, row) {
                        if (data == null) {
                            return $.fn.dataTable.render.number(',', '.', 2).display(0);
                        }else{
                            return $.fn.dataTable.render.number(',', '.', 2).display(data);

                        }
                    }

                },
                {
                    "title": "TOTAL DE BULTOS (UNDS)",
                    "data": "TOTAL_BULTOS_UNDS",
                    "render": function(data, type, row) {
                        if (data == null) {
                            return $.fn.dataTable.render.number(',', '.', 2).display(0);
                        }else{
                            return $.fn.dataTable.render.number(',', '.', 2).display(data);
                        }
                    }

                },
                {
                    "title": "ACCIONES",
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return '<div class="row justify-content-center">' +
                            '<div class="col-3 d-flex justify-content-center"><i class="feather icon-eye text-c-blue f-30 m-r-10" onclick="Mostrar(' + row.id + ')"></i></div>' +
                            '<div class="col-3 d-flex justify-content-center"><i class="feather icon-edit-2 text-c-purple f-30 m-r-10" onclick="Editar(' + row.id + ')"></i></div>' +
                            '<div class="col-3 d-flex justify-content-center"><i class="feather icon-trash-2 text-c-red f-30 m-r-10" onclick="Eliminar(' + row.id + ')"></i></div>' +
                            '</div>'
                    }
                },
            ],
            "columnDefs": [{
                    "className": "dt-center",
                    "targets": [1, 2, 3, 4, 8]
                },
                {
                    "className": "dt-right",
                    "targets": [5, 6, 7]
                },
                {
                    "visible": false,
                    "searchable": false,
                    "targets": [0]
                },
                {
                    "width": "10%",
                    "targets": [0, 1, 6]
                },
                {
                    "width": "15%",
                    "targets": [2]
                },
                {
                    "width": "10%",
                    "targets": [8]
                }
            ],
        });

        $("#tblConversion_length").hide();
        $("#tblConversion_filter").hide();

        inicializaControlFecha();
        // $('#tblConversion > thead').addClass('bg-primary text-white');
    });

    $('#btnAdd').on('click', function() {
        clearFields();
        $('#mdlAddOrden').modal('show');
    });

    $('#btnSave').on('click', function() {
        let fechaInicial = $('#fecha_inicial').val(),
            numOrden = $('#num_orden').val(),
            hora = $('#hora_inicial').val(),
            jumborroll = $('#id_select_producto').val(),
            producto,
            fecha_hora_inicio;
        let array = [];
        if (jumborroll == 0) {
            return mensaje('Por favor seleccione el producto', 'error');
        }
        if (jumborroll == '' || jumborroll == null) {
            return mensaje('Por favor seleccione el producto', 'error');
        }
        if (numOrden == '') {
            return mensaje('Por favor digite el numero de orden', 'error');
        }
        if (hora == '') {
            return mensaje('Por favor indique la hora inical', 'error');
        }
        if (fechaInicial == '') {
            return mensaje('Por favor seleccione la fecha inicial', 'error');
        }
        if (jumborroll == 35) {
            producto = 2;
        } else if (jumborroll == 13) {
            producto = 1;
        }

        fecha_hora_inicio = fechaInicial + ' ' + hora + ':00';
        array[0] = {
            num_orden: numOrden,
            id_productor: producto,
            id_jr: jumborroll,
            fecha_hora_inicio: fecha_hora_inicio,
            fecha_hora_final: fecha_hora_inicio
        };
        $.ajax({
            url: "guardar",
            data: {
                data: array,
                num_orden: numOrden
            },
            type: 'post',
            async: true,
            success: function(response) {
                if (response == 1) {
                    mensaje('Orden duplicada, por favor verifique el N°. Orden', 'warning');
                } else {
                    mensaje(response.responseText, 'success');
                    $('#mdlAddOrden').modal('hide');
                }
            },
            error: function(response) {
                mensaje(response.responseText, 'error');
            }
        }).done(function(data) {

        });
    });

    function clearFields() {

        $('#fecha_inicial').val('');
        $('#num_orden').val('');
        $('#hora_inicial').val('');
        $('#id_select_producto').val('');

    }
</script>