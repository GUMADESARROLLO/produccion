<script type="text/javascript">
    var dtHP;
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

        

       indexCosto();
       costoOrden();



        $("#numOrden").hide();

        $(document).on('click', '#btnNuevoCostoO', function() {
            var numOrden = $("#numOrden").val();
            const URLlast = "/produccion/costo-orden/nuevo/" + numOrden;
            $('#btnNuevoCostoO').attr('href', "/produccion/costo-orden/nuevo/" + numOrden);
            console.log(URLlast);
        });
    });


    function indexCosto(){
        
        $.ajax({
            url: "getCostos",
            type: 'get',
            async: false,
            success: function(response) {
                $('#dtOrder').DataTable({
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
                        "emptyTable": "REALICE UNA BUSQUEDA UTILIZANDO LOS FILTROS DE FECHA",
                        "search":     "BUSCAR"
                    },
                    "columns": [{
                            "data": "codigo", "render": function(data, type, row, meta) {

                            return  `<div class="text-center" width="1000px">
                                                <h6 class="mb-0 fw-semi-bold">`+row.codigo+`</h6>
                                        </div>`
                            }
                        },
                        {
                            "data": "descripcion", "render": function(data, type, row, meta) {

                                return  `   <div class="d-flex align-items-center position-relative">
                                                <div class="flex-1 ms-3" style="text-align: center;">
                                                    <h6 class="mb-0 fw-semi-bold"><div class="stretched-link text-dark">`+row.descripcion+`</div></h6>
                                                </div>
                                            </div>`
                                }
                        },
                        {
                            "data": "unidad_medida",
                            "render": function(data, type, row) {
                                return '<div class="text-center">'+row.unidad_medida+'</div>'                               
                            }
                        },
                        {
                            "data": "id",
                            "render": function(data, type, row) {
                                return '<div class="text-center"><a href="costos/editar/' + data + '">' +
                                    '<i class="far fa-edit" style="font-size:24px"></i></a></div>';
                            }
                        },
                    ],
                });
            }
        });

        $("#dtOrder_filter").hide();
        $("#dtOrder_length").hide();
        //$('#cont_search').show();
        /*$('#InputBuscar').on('keyup', function() {
            var table = $('#dtOrder').DataTable();
            table.search(this.value).draw();
        });*/
    }

    function costoOrden(){
        $.ajax({
            url: "getCostoOrden",
            type: 'get',
            async: false,
            success: function(response) {
                $('#dtCostoOrden').DataTable({
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
                        "emptyTable": "REALICE UNA BUSQUEDA UTILIZANDO LOS FILTROS DE FECHA",
                        "search":     "BUSCAR"
                    },
                    "columns": [{
                        "data": "numOrden", "render": function(data, type, row, meta) {
                            return  `<div class="text-center">
                                                <h6 class="mb-0 fw-semi-bold">`+row.numOrden+`</h6>
                                        </div>`
                            }
                        },
                        {
                            "data": "producto", "render": function(data, type, row, meta) {

                            return  `   <div class="d-flex align-items-center position-relative">
                                            <div class="flex-1 ms-3" style="text-align: center;">
                                                <h5 class="mb-0 fw-semi-bold"><div class="stretched-link text-dark">`+row.producto+`</div></h5>
                                            </div>
                                        </div>`
                        }},
                        {
                            "data": "fechaInicio", "render": function(data, type, row) {
                                return '<div class="text-center">'+row.fechaInicio+'</div>'                               
                            }
                        },
                        {
                            "data": "fechaFinal", "render": function(data, type, row) {
                                return '<div class="text-center">'+row.fechaFinal+'</div>'                               
                            }
                        },
                        {
                            "data": "numOrden",
                            "render": function(data, type, row) {
                                return '<div class="text-center"><a href="costo-orden/detalle/' + data + '" target="_blank"><i class="fa fa-eye text-c-black f-30 m-r-10"></i></a></div>';
                            }
                        },
                    ],
                });
            }
        });

        $("#dtCostoOrden_filter").hide();
        $("#dtCostoOrden_length").hide();
        $('#cont_search').show();
        $('#InputBuscar').on('keyup', function() {
            var table = $('#dtCostoOrden').DataTable();
            table.search(this.value).draw();
        });
    }


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
