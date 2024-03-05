<script type="text/javascript">
    var dtConversion;
    $(document).ready(function() {

        $('#InputBuscar').on('keyup', function() {
            var table = $('#tblConversion').DataTable();
            table.search(this.value).draw();
        });

        inicializaControlFecha();
        const primerDiaDelMes = moment().startOf('month').format('YYYY-MM-DD');
        const ultimoDiaDelMes = moment().endOf('month').format('YYYY-MM-DD');
        $("#id_fecha_desde").val(primerDiaDelMes);
        $("#id_fecha_hasta").val(ultimoDiaDelMes);

        getOrdenes();

        $("#id_search").on('click', function() {
            getOrdenes();
        })
    });

    function getOrdenes() {

        f1 = $("#id_fecha_desde").val();
        f2 = $("#id_fecha_hasta").val();


        $('#tblConversion').DataTable({
            'ajax': {
                'url': 'getOrdenes',
                'dataSrc': '',
                data: {
                    'f1': f1,
                    'f2': f2,
                }
            },
            "destroy": true,
            "info": false,
            "order": [
                [1, "desc"]
            ],
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
                    "data": "id"
                },
                {
                    "data": "num_orden",
                    "render": function(data, type, row, meta) {
                        return '<span class="text-primary" onclick="Editar(' + row.id + ')">' + data + '</span>'

                    }
                },
                {
                    "data": "nombre"
                },
                {
                    "data": "fecha_hora_inicio"
                },
                {
                    "data": "fecha_hora_final"
                },
                {
                    "data": "Hrs_trabajadas",
                    "render": $.fn.dataTable.render.number(',', '.', 2)
                },
                {
                    "data": "PESO_PORCENT",
                    "render": function(data, type, row) {
                        if (data == null) {
                            return $.fn.dataTable.render.number(',', '.', 2).display(0);
                        } else {
                            return $.fn.dataTable.render.number(',', '.', 2).display(data);

                        }
                    }

                },
                {
                    "data": "TOTAL_BULTOS_UNDS",
                    "render": function(data, type, row) {
                        if (data == null) {
                            return $.fn.dataTable.render.number(',', '.', 2).display(0);
                        } else {
                            return $.fn.dataTable.render.number(',', '.', 2).display(data);
                        }
                    }
                },
                {
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return '<div class="row justify-content-center">' +
                            '<div class="col-3 d-flex justify-content-center"><i class="far fa-trash-alt text-c-red f-20 m-r-10" onclick="Eliminar(' + row.id + ')"></i></div>' +
                            '<div class="col-3 d-flex justify-content-center"><i class="fa fa-file-pdf text-c-blue f-20 m-r-10" onclick="Printer(' + row.id + ')"></i></div>' +
                            '</div>'
                    }
                },
            ],
            "columnDefs": [{
                    "visible": false,
                    "searchable": false,
                    "targets": [0]
                },                
            ],
        });

        $("#tblConversion_length").hide();
        $("#tblConversion_filter").hide();
    }

    function Printer(gPosition) {
        var table = $('#tblConversion').DataTable();
        var row = table.rows().data();

        const ArrayRows = Object.values(row);
        var index = ArrayRows.findIndex(s => s.id == gPosition)
        row = row[index]


        location.href = "doc_printer/" + row.num_orden;
    }

    function Editar(gPosition) {
        var table = $('#tblConversion').DataTable();
        var row = table.rows().data();

        const ArrayRows = Object.values(row);
        var index = ArrayRows.findIndex(s => s.id == gPosition)
        row = row[index]


        window.location = "doc/" + row.num_orden;
    }
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
        } else if (jumborroll == 50) {
            producto = 7;
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
                        mensaje('¡Orden duplicada!', 'warning');
                } else {
                    mensaje(response.responseText, 'success');
                    $('#mdlAddOrden').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
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

    function Eliminar(id) {
        $.ajax({
            url: 'eliminar',
            data: {
                id: id
            },
            type: 'post',
            async: true,
            success: function(response) {
                mensaje(response.responseText, 'success');
            },
            error: function(response) {
                mensaje(response.responseText, 'error');
            }
        }).done(function(data) {
            location.reload();
        });
    }
</script>