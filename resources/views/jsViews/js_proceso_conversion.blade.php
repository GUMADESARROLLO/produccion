<script type="text/javascript">
    var dtConversion;
    $(document).ready(function() {

        $('#InputBuscar').on('keyup', function() {
            var table = $('#tblConversion').DataTable();
            table.search(this.value).draw();
        });
        

        inicializaControlFecha();
        getOrdenes();
       
        $("#id_search").on('click', function() {
            getOrdenes();
        })
    });

    function getOrdenes(){

        f1  = $("#id_fecha_desde").val();
        f2  = $("#id_fecha_hasta").val();

        $('#tblConversion').DataTable({            
            'ajax':{
            'url':'getOrdenes',
            'dataSrc': '',
                data: {
                    'f1' : f1,
                    'f2' : f2,
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
                    "title": "id",
                    "data": "id"
                },
                {
                    "title": "N° ORDEN",
                    "data": "num_orden",
                    "render": function(data, type, row, meta) {
                        return '<span class="text-primary" onclick="Editar(' + row.id + ')">'+data+'</span>' 

                    }
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
                    "data": "Hrs_trabajadas",
                    "render": $.fn.dataTable.render.number(',', '.', 2)
                },
                {
                    "title": "PESO %",
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
                    "title": "TOTAL DE BULTOS (UNDS)",
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
                    "title": "ACCIONES",
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return '<div class="row justify-content-center">' +
                            '<div class="col-3 d-flex justify-content-center"><i class="material-icons text-danger" onclick="Eliminar(' + row.id + ')">delete</i></div>' +
                            '<div class="col-3 d-flex justify-content-center"><i class="material-icons text-danger" onclick="Printer(' + row.id + ')">picture_as_pdf</i></div>' +
                            '</div>'
                    }
                },
            ],
            "columnDefs": [{
                    "className": "dt-center",
                    "targets": [1, 2, 3, 4]
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
                    "width": "11%",
                    "targets": [1,5,6]
                },
            ],
        });

        $("#tblConversion_length").hide();
        $("#tblConversion_filter").hide();
    }
    function Printer(gPosition){
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
        if (jumborroll == 75) {
            producto = 2;
        } else if (jumborroll == 53) {
            producto = 1;
        } else if (jumborroll == 94){
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
                    mensaje('Orden duplicada, por favor verifique el N°. Orden', 'warning');
                   
                } else {
                    mensaje(response.responseText, 'success');
                    $('#mdlAddOrden').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(response) {
                mensaje(response.responseText, 'error');
            }
        }).done(function(data) {
            location.reload();
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