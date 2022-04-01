<script type="text/javascript">
    var dtHP, dtCostoOrden, dtOrder;
    var indicador_1 = 0;
    $(document).ready(function() {
        dtHP = $('#dtHrsProd').DataTable({
            "destroy": true,
            "ordering": false,
            "info": false,
            "bPaginate": false,
            "bfilter": false,
            "searching": false,
            "language": {
                "emptyTable": `<p class="text-center">Agrega horas productivas</p>`
            },
            "columnDefs": [{
                "targets": [0],
                "className": "dt-center",
                "visible": false
            }]
        });

        dtCostoOrden = $('#dtCostoOrden').DataTable({ // Costos por ORDEN
            "ajax": {
                "url": "getCostoOrden",
                'dataSrc': '',
            },
            "order": [
                [0, "desc"]
            ],
            "info": false,
            "destroy": true,
            "bPaginate": true,
            "pagingType": "full",
            "language": {
                "emptyTable": `<p class="text-center">Agrega horas productivas</p>`,
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "search": "BUSCAR",
                "oPaginate": {
                    sNext: " Siguiente ",
                    sPrevious: " Anterior ",
                    sFirst: "Primero ",
                    sLast: " Ultimo",
                },
            },
            "columns": [{
                    "title": "#Orden",
                    "data": "numOrden"
                },
                {
                    "title": "Producto",
                    "data": "producto"
                },
                {
                    "title": "Fecha Inicio",
                    "data": "fechaInicio"
                },
                {
                    "title": "Fecha Final",
                    "data": "fechaFinal"
                },
                {
                    "title": "Detalle",
                    "data": "numOrden",
                    "render": function(data, type, row) {
                        return '<a href="costo-orden/detalle/' + data + '" target="_blank"><i class="feather icon-eye text-c-black f-30 m-r-10"></i></a>';
                    }
                },
            ],
            "columnDefs": [{
                "targets": [0],
                "className": "dt-center",
            }, {
                "targets": [1],
                "width": '35%',
                "className": "dt-center",
            }]
        });

        $("#dtCostoOrden_filter").hide();
        $("#dtCostoOrden_length").hide();
        $('#cont_search').show();
        $('#InputBuscar').on('keyup', function() {
            var table = $('#dtCostoOrden').DataTable();
            table.search(this.value).draw();
        });

        dtOrder = $('#dtOrder').DataTable({ //SOLO COSTOS
            "ajax": {
                "url": "getCostos",
                'dataSrc': '',
            },
            "order": [
                [4, "desc"]
            ],
            "destroy": true,
            "bPaginate": true,
            "pagingType": "full",
            "info": false,
            "language": {
                "emptyTable": `<p class="text-center">Agrega horas productivas</p>`,
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "search": "BUSCAR",
                "oPaginate": {
                    sNext: " Siguiente ",
                    sPrevious: " Anterior ",
                    sFirst: "Primero ",
                    sLast: " Ultimo",
                },
            },
            "columns": [{
                    "title": "CODIGO",
                    "data": "codigo"
                },
                {
                    "title": "DESCRIPCION",
                    "data": "descripcion"
                },
                {
                    "title": "U/M",
                    "data": "unidad_medida"
                },
                {
                    "title": "Estado",
                    "data": "estado",
                    "render": function(data, type, row) {
                        if (data) {
                            return '<span class="badge badge-success">Activo</span>'
                        } else {
                            '<span class="badge badge-danger">Inactivo</span>'
                        }
                    }
                },
                {
                    "title": "Detalle",
                    "data": "id",
                    "render": function(data, type, row) {
                        return '<a href="#!" onclick="deleteCosto(' + data + ')"><i class="feather icon-x-circle text-c-red f-30 m-r-10"></i></a><a href="costos/editar/' + data + '">' +
                            '<i class="feather icon-edit text-c-blue f-30 m-r-10"></i></a>';
                    }
                },
            ],
            "columnDefs": [{
                "targets": [0],
                "className": "dt-center",
            }, {
                "targets": [1],
                "width": '35%',
                "className": "dt-center",
            }]
        });

        $("#dtOrder_filter").hide();
        $("#dtOrder_length").hide();
        $('#cont_search').show();
        $('#InputBuscar').on('keyup', function() {
            var table = $('#dtOrder').DataTable();
            table.search(this.value).draw();
        });



        $("#numOrden").hide();

        $(document).on('click', '#btnNuevoCostoO', function() {
            var numOrden = $("#numOrden").val();
            const URLlast = "/produccion/costo-orden/nuevo/" + numOrden;
            $('#btnNuevoCostoO').attr('href', "/produccion/costo-orden/nuevo/" + numOrden);
            console.log(URLlast);
        });
    });
    $(document).on('click', '#btnEditar', function() {
        var numOrden = $("#numOrden").val();
        const URLlast = "/produccion/costo-orden/nuevo/" + numOrden;
        $('#btnNuevoCostoO').attr('href', "/produccion/costo-orden/nuevo/" + numOrden);
        console.log(URLlast);
    });

    $(document).on('click', '#btnguardar', function() {
        var numOrden = $("#numOrden").val();
        var array = new Array();

        console.log(numOrden);
        var horaJY1 = $('#horaJY1').val();
        var horaLY1 = $('#horaLY1').val();
        var horaJY2 = $('#horaJY2').val();
        var horaLY2 = $('#horaLY2').val();

        if (horaJY1 != '' && horaLY1 != '' && horaJY2 != '' && horaLY2 != '') {
            $.ajax({
                url: "../guardarhrs-producidas",
                data: {
                    codigo: numOrden,
                    horaJY1: horaJY1,
                    horaLY1: horaLY1,
                    horaJY2: horaJY2,
                    horaLY2: horaLY2
                },
                type: 'post',
                async: true,
                success: function(resultado) {
                    mensaje("Las horas han sido agregadas correctamente", "success");
                }
            }).done(function(data) {
                $("#formdataord").submit();
            });
        } else {
            mensaje('Digite las horas trabajadas para cada yankee', 'info')
        }
    });

    $(document).on('click', '#btnTipoCambio', function(e) {
        //e.preventDefault();
        $("#modaltc").modal();
    })

    $('#fechatc').on('apply.daterangepicker', function(ev, picker) {
        var fecha_tc = $(this).val();
        // alert (fecha_tc);
        //console.log(fecha_tc);
        $.ajax({
            url: "../detalle/get-Tipo-Cambio/" + fecha_tc,
            type: 'get',
            async: true,
            datatype: 'json',
            data: {},
            success: function(data) {
                $('#tasaCambio').text(data[0]['TipoCambio']);
            },
            error: function() {

            }
        });

    });
    //botón guardar tasa de cambio
    $(document).on('click', '#btnguardarTC', function(e) {
        // variables

        var tasaCambio = parseFloat($('#tasaCambio').text());
        var costoTotalCord = parseFloat($('#ctCordobas').text());
        var numOrden = $('#numOrden').val();
        console.log($('#tasaCambio').text());
        console.log(costoTotalCord);

        $.ajax({
            url: "../detalle/actualizarTC",
            type: 'post',
            async: true,
            datatype: 'json',
            data: {
                numOrden: numOrden,
                tasaCambio: tasaCambio,
            },
            success: function(response) {
                //mensaje(response.responseText, 'success');
                $('#txtTasaCambio').text(tasaCambio);
                mensaje("El tipo de cambio ha sido agregado correctamente", "success");
            },
            error: function() {}
        })
    })

    $('#btn-guardar-tc').on('click')

    /******** Cargar funcion al inicio del DOM ************/
    $(document).ready(function() {
        $(function() {
            $('.datetimepicker_').datetimepicker({
                format: 'LT'
            });

        });

        inicializaControlFecha();
        /* $('input[name="fechatc"]').on('apply.daterangepicker', function(ev, picker) {
             console.log($(this).val());
         })*/
    });
</script>
