<script type="text/javascript">
    var dtConversion;
    var dtRequisas = '';

    $(document).ready(function() {

        id_orden = $("#id_num_orden").text()

        $('#tbl_search_producto').on('keyup', function() {
            var table = $('#tblProductos').DataTable();
            table.search(this.value).draw();
        });
        $('#tbl_search_materia_prima').on('keyup', function() {
            var table = $('#tblMateriaPrima').DataTable();
            table.search(this.value).draw();
        });

        $.getJSON("../jsonInfoOrder/" + id_orden, function(json) {
            $.each(json, function(i, item) {
                switch (item['tipo']) {
                    case 'dtaOrden':

                        $("#id_peso_porcent").text(item['data'].peso_procent)
                        $("#id_nombre_articulos").text(item['data'].nombre)
                        $("#id_fecha_inicial").text(item['data'].fecha_inicio)
                        $("#id_hora_inicial").text(item['data'].hora_inicio)
                        $("#id_fecha_final").text(item['data'].fecha_final)
                        $("#id_hora_final").text(item['data'].hora_final);
                        $("#id_hrs_trabajadas").text(item['data'].hrs_trabajadas);
                        $("#id_total_bultos_und").text(item['data'].total_bultos_und);
                        $("#id_hrs_total_trabajadas").text(item['data'].hrs_total_trabajadas);
                        $("#comentario").text(item['data'].comentario);

                        break;
                    case 'dtaMateria':
                        let table_materia = $('#tblMateriaPrima').DataTable({
                            "data": item['data'],
                            "destroy": true,
                            "info": false,
                            "bPaginate": false,
                            "order": [
                                [7, "asc"]
                            ],
                            "lengthMenu": [
                                [100, -1],
                                [100, "Todo"]
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
                                    "title": "ARTICULO",
                                    "data": "ARTICULO"
                                },
                                {
                                    "title": "DESCRIPCION_CORTA",
                                    "data": "DESCRIPCION_CORTA",
                                    "render": function(data, type, row, meta) {
                                        return '<u class="dotted">' + data + '</u>'

                                    }
                                },
                                {
                                    "title": "REQUISA",
                                    "data": "REQUISA"
                                },
                                {
                                    "title": "PISO",
                                    "data": "PISO"
                                },
                                {
                                    "title": "CONSUMO",
                                    "data": "PERSO_PORCENT"
                                },
                                {
                                    "title": "MERMA",
                                    "data": "MERMA"
                                },
                                {
                                    "title": "%",
                                    "data": "MERMA_PORCENT"
                                },
                                {
                                    "title": "ID_ARTICULO",
                                    "data": "ID_ARTICULO"
                                },

                            ],
                            "columnDefs": [{
                                    "className": "dt-center",
                                    "targets": []
                                },
                                {
                                    "className": "dt-right",
                                    "targets": [2, 3, 4, 5, 6]
                                },
                                {
                                    "visible": false,
                                    "searchable": false,
                                    "targets": [7]
                                },
                                {
                                    "width": "10%",
                                    "targets": [2, 3, 4, 5, 6]
                                },
                                {
                                    "width": "15%",
                                    "targets": [2]
                                },
                            ],
                        });
                        $("#tblMateriaPrima_length").hide();
                        $("#tblMateriaPrima_filter").hide();
                        $('#tblMateriaPrima tbody').on('click', "tr", function() {
                            $('#mdlMatPrima').modal('show');


                            var data = table_materia.row(this).data();
                            var id_articulo = data['ID_ARTICULO'];
                            var articulo = data['ARTICULO'];
                            var descripcion = data['DESCRIPCION_CORTA'];
                            var num_orden = $('#id_num_orden').text();
                            clearRequisas();
                            mostrarRequisado(num_orden, id_articulo, 2);
                            getRequisadoMP(num_orden, id_articulo);
                            $("#id_articulo").html("- [ " + data.ARTICULO + " ]");
                            $("#id_descripcion").text(data.DESCRIPCION_CORTA);
                            $('#id_elemento').text(id_articulo);

                            $('#tbRequisas tbody').on('click', "td", function(event) {
                                var visIdx = $(this).index();
                                var tipo_requisa, id_requisa, cantidad, nombre;
                                var data = dtRequisas.row(this).data();

                                var visIdx = $(this).index()

                                var cantidad = data['cantidad'];
                                var id_requisa = data['id'];
                                tipo_requisa = 2;
                                cantidad = cantidad.replace(/[',]+/g, '');

                                nombre = 'REQUISADO';
                                if (visIdx == 1) {
                                    Swal.fire({
                                        title: nombre,
                                        text: "Ingrese la cantidad",
                                        input: 'text',
                                        inputPlaceholder: 'Digite la cantidad',
                                        target: document.getElementById('mdlMatPrima'),
                                        inputAttributes: {
                                            id: 'cantidad',
                                            required: 'true',
                                            onkeypress: 'soloNumeros(event.keyCode, event, $(this).val())'
                                        },
                                        showCancelButton: true,
                                        confirmButtonText: 'Guardar',
                                        showLoaderOnConfirm: true,
                                        inputValue: cantidad,
                                        inputValidator: (value) => {
                                            if (!value) {
                                                return 'Digita la cantidad por favor';
                                            }
                                            value = value.replace(/[',]+/g, '');
                                            if (isNaN(value)) {
                                                return 'Formato incorrecto';
                                            } else {
                                                $.ajax({
                                                    url: "../actualizarMP",
                                                    data: {
                                                        cantidad: value,
                                                        num_orden: num_orden,
                                                        id_articulo: id_articulo,
                                                        tipo: tipo_requisa,
                                                        id_requisa: id_requisa,
                                                    },
                                                    type: 'post',
                                                    async: true,
                                                    success: function(response) {
                                                        swal("Exito!", "Guardado exitosamente", "success");
                                                    },
                                                    error: function(response) {
                                                        swal("Oops", "No se ha podido guardar!", "error");
                                                    }
                                                }).done(function(data) {
                                                    mostrarRequisado(num_orden, id_articulo, 2);
                                                });
                                            }
                                        }
                                    })
                                }
                            });
                        });
                        break;
                    case 'dtaProducto':
                        let table_producto = $('#tblProductos').DataTable({
                            "data": item['data'],
                            "destroy": true,
                            "info": false,
                            "bPaginate": false,
                            "order": [
                                [5, "asc"]
                            ],
                            "lengthMenu": [
                                [100, -1],
                                [100, "Todo"]
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
                                    "title": "ARTICULO",
                                    "data": "ARTICULO"
                                },
                                {
                                    "title": "DESCRIPCION_CORTA",
                                    "data": "DESCRIPCION_CORTA",
                                    "render": function(data, type, row, meta) {
                                        return '<u class="dotted">' + data + '</u>'

                                    }
                                },
                                {
                                    "title": "BULTO",
                                    "data": "BULTO"
                                },
                                {
                                    "title": "PESO %",
                                    "data": "PERSO_PORCENT"
                                },
                                {
                                    "title": "KG",
                                    "data": "KG"
                                },
                                {
                                    "title": "ID_ARTICULO",
                                    "data": "ID_ARTICULO"
                                },

                            ],
                            "columnDefs": [{
                                    "className": "dt-center",
                                    "targets": []
                                },
                                {
                                    "className": "dt-right",
                                    "targets": [2, 3, 4]
                                },
                                {
                                    "visible": false,
                                    "searchable": false,
                                    "targets": [5]
                                },
                                {
                                    "width": "10%",
                                    "targets": []
                                },
                                {
                                    "width": "15%",
                                    "targets": []
                                },
                            ],
                            "footerCallback": function(row, data, start, end, display) {
                                var api = this.api();
                                var intVal = function(i) {
                                    return typeof i === 'string' ?
                                        i.replace(/[^0-9.]/g, '') * 1 :
                                        typeof i === 'number' ?
                                        i : 0;
                                };
                                Total = api.column(4).data().reduce(function(a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                                $('#id_jr_total').text(numeral(Total).format('0,0.00'));
                            }
                        });
                        $("#tblProductos_length").hide();
                        $("#tblProductos_filter").hide();

                        $('#tblProductos tbody').on('click', "tr", function(event) {
                            var data = table_producto.row(this).data();
                            let cantidad = data['BULTO'];
                            let id_articulo = data['ID_ARTICULO'];
                            let num_orden = $('#id_num_orden').text();
                            cantidad = cantidad.replace(/[',]+/g, '');

                            Swal.fire({
                                title: data.DESCRIPCION_CORTA,
                                text: "Ingrese la cantidad ",
                                input: 'text',
                                inputPlaceholder: 'Digite la cantidad',
                                inputAttributes: {
                                    id: 'cantidad',
                                    required: 'true',
                                    onkeypress: 'soloNumeros(event.keyCode, event, $(this).val())'
                                },
                                showCancelButton: true,
                                confirmButtonText: 'Guardar',
                                showLoaderOnConfirm: true,
                                inputValue: cantidad,
                                inputValidator: (value) => {
                                    if (!value) {
                                        return 'Digita la cantidad por favor';
                                    }
                                    value = value.replace(/[',]+/g, '');
                                    if (isNaN(value)) {
                                        return 'Formato incorrecto';
                                    } else {
                                        $.ajax({
                                            url: "../actualizarCantidad",
                                            data: {
                                                cantidad: value,
                                                num_orden: num_orden,
                                                id_articulo: id_articulo
                                            },
                                            type: 'post',
                                            async: true,
                                            success: function(response) {
                                                swal("Exito!", "Guardado exitosamente", "success");
                                            },
                                            error: function(response) {
                                                swal("Oops", "No se ha podido guardar!", "error");
                                            }
                                        }).done(function(data) {
                                            setTimeout(function() {
                                                location.reload();
                                            }, 2000);
                                        });
                                    }
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {}
                            })


                        });
                        break;
                    case 'dtaTiemposParos':
                        let table_horas_paro = $('#tblTiemposParos').DataTable({
                            "data": item['data'],
                            "destroy": true,
                            "info": false,
                            "bPaginate": false,
                            "lengthMenu": [
                                [100, -1],
                                [100, "Todo"]
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
                            "order": [
                                [0, "asc"]
                            ],
                            'columns': [{
                                    "title": "ID",
                                    "data": "ID_ROW"
                                }, {
                                    "title": "DESCRIPCION DE LA ACTIVIDAD",
                                    "data": "ARTICULO",
                                    "render": function(data, type, row, meta) {
                                        return '<u class="dotted">' + data + '</u>'

                                    }
                                },
                                {
                                    "title": "DIA",
                                    "data": "Dia"
                                },

                                {
                                    "title": "NOCHE",
                                    "data": "Noche"
                                },
                                {
                                    "title": "TOTAL HRS",
                                    "data": "Total_Hrs"
                                },
                                {
                                    "title": "No. Personas",
                                    "data": "num_personas"
                                },


                            ],
                            "columnDefs": [{
                                    "className": "dt-center",
                                    "targets": []
                                },
                                {
                                    "className": "dt-right",
                                    "targets": [2, 3, 4, 5]
                                },
                                {
                                    "className": "dt-left",
                                    "targets": []
                                },
                                {
                                    "visible": false,
                                    "searchable": false,
                                    "targets": [0]
                                },
                                {
                                    "width": "10%",
                                    "targets": []
                                },
                                {
                                    "width": "15%",
                                    "targets": []
                                },
                            ],
                            "footerCallback": function(row, data, start, end, display) {

                            }
                        });

                        $("#tblTiemposParos_length").hide();
                        $("#tblTiemposParos_filter").hide();

                        $('#tblTiemposParos tbody').on('click', "td", function(event) {

                            var data = table_horas_paro.row(this).data();
                            let id_articulo = data['ID_ROW'];
                            let cantidad = data['num_personas'];
                            let num_orden = $('#id_num_orden').text();
                            cantidad = cantidad.replace(/[',]+/g, '');

                            Swal.fire({
                                title: "Nº de Personas",
                                text: "Ingrese la cantidad ",
                                input: 'text',
                                inputPlaceholder: 'Digite la cantidad',
                                inputAttributes: {
                                    id: 'cantidad',
                                    required: 'true',
                                    onkeypress: 'soloNumeros(event.keyCode, event, $(this).val())'
                                },
                                showCancelButton: true,
                                confirmButtonText: 'Guardar',
                                showLoaderOnConfirm: true,
                                inputValue: cantidad,
                                inputValidator: (value) => {
                                    if (!value) {
                                        return 'Digita la cantidad por favor';
                                    }
                                    value = value.replace(/[',]+/g, '');
                                    if (isNaN(value)) {
                                        return 'Formato incorrecto';
                                    } else {
                                        $.ajax({
                                            url: "../GuardarNumeroPersona",
                                            data: {
                                                cantidad: value,
                                                num_orden: num_orden,
                                                id_articulo: id_articulo
                                            },
                                            type: 'post',
                                            async: true,
                                            success: function(response) {
                                                swal("Exito!", "Guardado exitosamente", "success");
                                            },
                                            error: function(response) {
                                                swal("Oops", "No se ha podido guardar!", "error");
                                            }
                                        }).done(function(data) {
                                            setTimeout(function() {
                                                location.reload();
                                            }, 2000);
                                        });
                                    }
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {}
                            })


                        });

                        break;

                    default:
                        console.log('Lo lamentamos, por el momento no disponemos de ');
                }
            });
        });

        inicializaControlFecha();
    });

    function clearFields() {
        $('#fecha_inicial').val('');
        $('#num_orden').val('');
        $('#hora_inicial').val('');
        $('#id_select_producto').val('');
    }

    function soloNumeros(caracter, e, numeroVal) {
        var numero = numeroVal;
        if (String.fromCharCode(caracter) === "." && numero.length === 0) {
            e.preventDefault();
            swal.showValidationError('No se puede iniciar con un punto');
        } else if (numero.includes(".") && String.fromCharCode(caracter) === ".") {
            e.preventDefault();
            swal.showValidationError('No puede haber mas de dos puntos');
        } else {
            const soloNumeros = new RegExp("^[0-9]+$");
            if (!soloNumeros.test(String.fromCharCode(caracter)) && !(String.fromCharCode(caracter) === ".")) {
                e.preventDefault();
                swal.showValidationError(
                    'No se pueden escribir letras, solo se permiten datos númericos'
                );
            }
        }
    }

    function detalles_tiempos_paros() {
        $.getJSON("../jsonInfoOrder/" + id_orden, function(json) {
            $('#tbl_modal_TiemposParos').DataTable({
                "data": json[3]['data'],
                "destroy": true,
                "info": false,
                "bPaginate": false,
                "lengthMenu": [
                    [100, -1],
                    [100, "Todo"]
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
                "order": [
                    [0, "asc"]
                ],
                'columns': [{
                        "title": "ID",
                        "data": "ID_ROW"
                    },
                    {
                        "title": "DESCRIPCION DE LA ACTIVIDAD",
                        "data": "ARTICULO"
                    },
                    {
                        "title": "DIA",
                        "data": "Dia"
                    },
                    {
                        "title": "NOCHE",
                        "data": "Noche"
                    },
                ],
                "columnDefs": [{
                        "className": "dt-center",
                        "targets": []
                    },
                    {
                        "className": "dt-right",
                        "targets": [2, 3, ]
                    },
                    {
                        "className": "dt-left",
                        "targets": []
                    },
                    {
                        "visible": false,
                        "searchable": false,
                        "targets": [0]
                    },
                    {
                        "width": "10%",
                        "targets": []
                    },
                    {
                        "width": "15%",
                        "targets": []
                    },
                ]
            });
            $("#tbl_modal_TiemposParos_length").hide();
            $("#tbl_modal_TiemposParos_filter").hide();
            $('#tbl_modal_TiemposParos tbody').on('click', "td", function(event) {

                var tbl_mdl_tiempos_paro = $('#tbl_modal_TiemposParos').DataTable();

                var dtaRow = tbl_mdl_tiempos_paro.row(this).data();
                var visIdx = $(this).index()

                if (visIdx != 0 && visIdx != 3) {


                    var valor = $(this).html().trim();
                    var valor_columna = $('#tbl_modal_TiemposParos thead tr th').eq($(this).index()).html().trim();
                    var num_orden = $('#id_num_orden').text();
                    var ARTICULO = dtaRow['ARTICULO'];
                    var idturno = (valor_columna == 'DIA') ? 1 : 2


                    valor = valor.replace(/[',]+/g, '');

                    Swal.fire({
                        title: ARTICULO,
                        text: "Para el Turno de " + valor_columna,
                        input: 'text',
                        target: document.getElementById('mdlHorasParo'),
                        inputPlaceholder: 'Digite la cantidad',
                        inputAttributes: {
                            id: 'cantidad',
                            required: 'true',
                            onkeypress: 'soloNumeros(event.keyCode, event, $(this).val())'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Guardar',
                        showLoaderOnConfirm: true,
                        inputValue: valor,
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Digita la cantidad por favor';
                            }

                            if (isNaN(value)) {
                                return 'Formato incorrecto';
                            } else {
                                $.ajax({
                                    url: "../GuardarTiempoParo",
                                    data: {
                                        id_tipo_tiempo_paro: dtaRow['ID_ROW'],
                                        num_orden: num_orden,
                                        cantidad: value,
                                        idturno: idturno
                                    },
                                    type: 'post',
                                    async: true,
                                    success: function(response) {
                                        detalles_tiempos_paros()
                                    },
                                    error: function(response) {
                                        swal("Oops", "No se ha podido guardar!", "error");
                                    }
                                }).done(function(data) {
                                    setTimeout(function() {
                                        detalles_tiempos_paros()
                                    }, 2000);
                                });
                            }
                        }
                    })
                }

            })

        })
    }

    $('#id_btn_add_hrs_paro').on('click', function() {
        $('#mdlHorasParo').modal('show');
        detalles_tiempos_paros()
    })

    function mostrarRequisado(numOrden, id_articulo, tipo) {
        dtRequisas = $('#tbRequisas').DataTable({ // Costos por ORDEN
            "ajax": {
                "url": '../getRequisadosMP/' + numOrden + '/' + id_articulo + '/' + tipo,
                'dataSrc': '',
            },
            "destroy": true,
            "ordering": false,
            "info": false,
            "bPaginate": false,
            "bfilter": false,
            "searching": false,
            "language": {
                "emptyTable": `<p class="text-center">AGREGUE UNA REQUISA</p>`
            },
            "columns": [{
                    "title": "ID",
                    "data": "id"
                },
                {
                    "title": "Fecha",
                    "data": "fecha_creacion"
                },
                {
                    "title": "Cantidad",
                    "data": "cantidad",
                },
                {
                    "title": "Eliminar",
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return '<div class="row justify-content-center">' +
                            '<div class="col-3 d-flex justify-content-center"><i class="feather icon-x text-c-red f-30 m-r-10" onclick="Eliminar(' + row.id + ',event)"></i></div>' +
                            '</div>'
                    }
                },
            ],
            "columnDefs": [{
                "targets": [1, 2],
                "width": '45%',
                "className": "dt-center",
            }, {
                "targets": [0],
                "visible": false
            }, {
                "targets": [3],
                "width": '10%',
                "className": "dt-center",
            }]
        });

        $("#tbRequisas_filter").hide();
        $("#tbRequisas_length").hide();
    }

    function getRequisadoMP(numOrden, id_articulo) {

        $.ajax({
            url: '../getRequisadosAll/' + numOrden + '/' + id_articulo,
            data: {},
            type: 'get',
            async: true,
            success: function(data) {
                data.forEach(element => {
                    if (element.ID_TIPO_REQUISA == 1) {
                        $('#lp_inicial').val(numeral(element.CANTIDAD).format('00.00'));
                    } else if (element.ID_TIPO_REQUISA == 3) {
                        $('#lp_final').val(numeral(element.CANTIDAD).format('00.00'));
                    } else if (element.ID_TIPO_REQUISA == 4) {
                        $('#merma').val(numeral(element.CANTIDAD).format('00.00'));
                    }
                });
            },
            error: function(response) {
                mensaje(response.responseText, 'error');
            }
        }).done(function(data) {});

    }

    function clearRequisas() {
        $('#lp_inicial').val('');
        $('#lp_final').val('');
        $('#merma').val('');
    }


    $('#btnAddReq').on('click', function() {
        var num_orden = $('#id_num_orden').text(),
            tipo_requisa = 2,
            id_articulo = $('#id_elemento').text();


        Swal.fire({
            title: 'Nueva Requisa',
            text: "Ingrese la cantidad",
            input: 'text',
            inputPlaceholder: 'Digite la cantidad',
            inputAttributes: {
                id: 'cantidad',
                required: 'true',
                onkeypress: 'soloNumeros(event.keyCode, event, $(this).val())'
            },
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            showLoaderOnConfirm: true,
            target: document.getElementById('mdlMatPrima'),
            inputValue: $('#cantidad').text(),
            inputValidator: (value) => {
                if (!value) {
                    return 'Digita la cantidad por favor';
                }
                value = value.replace(/[',]+/g, '');
                if (isNaN(value)) {
                    return 'Formato incorrecto';
                } else {
                    $.ajax({
                        url: "../addRequisa",
                        data: {
                            cantidad: value,
                            num_orden: num_orden,
                            id_articulo: id_articulo,
                            tipo: tipo_requisa,
                        },
                        type: 'post',
                        async: true,
                        success: function(response) {

                            swal("Exito!", "Guardado exitosamente", "success");
                        },
                        error: function(response) {
                            swal("Oops", "No se ha podido guardar!", "error");
                        }
                    }).done(function(data) {
                        mostrarRequisado(num_orden, id_articulo, 2);
                    });
                }
            }
        })

    });
    $('#btnSave').on('click', function() {
        var data = [];
        var num_orden = $('#id_num_orden').text(),
            id_articulo = $('#id_elemento').text(),
            lp_inicial = $('#lp_inicial').val(),
            lp_final = $('#lp_final').val(),
            merma = $('#merma').val();

        data[0] = {
            num_orden: num_orden,
            tipo: 1,
            cantidad: lp_inicial,
            id_articulo: id_articulo,
        };

        data[1] = {
            num_orden: num_orden,
            tipo: 3,
            cantidad: lp_final,
            id_articulo: id_articulo,
        };
        data[2] = {
            num_orden: num_orden,
            tipo: 4,
            cantidad: merma,
            id_articulo: id_articulo,
        };

        $.ajax({
            url: "../guardarMatP",
            data: {
                data: data
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
    });

    function Eliminar(id, event) {
        let id_articulo = $('#id_elemento').text(),
            num_orden = $('#id_num_orden').text(),
            tipo = 2;

        Swal.fire({
            title: '¿Estas Seguro de eliminar la requisa?',
            text: "¡Esta acción no podrá ser revertida!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminalo!',
            target: document.getElementById('mdlMatPrima'),
            showLoaderOnConfirm: true,
            preConfirm: () => {
                $.ajax({
                    url: '../eliminarRequisaPC',
                    data: {
                        id: id
                    },
                    type: 'post',
                    async: true,
                    success: function(response) {
                        Swal.fire('Eliminado!', 'la requisa se ha eliminado', 'success')
                    },
                    error: function(response) {
                        mensaje(response.responseText, 'error');
                    }
                }).done(function(data) {
                    mostrarRequisado(num_orden, id_articulo, tipo);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    }

    $('#fecha_hora_final').on('mouseover', function() {
        $(this).addClass('color-focus');
    });

    $('#fecha_hora_final').on('mouseleave', function() {
        $(this).removeClass('color-focus');
    });

    $('#fecha_hora_final,#icon_fecha_final ').on('click', function() {
        let fecha_final, hora_final, num_orden;
        num_orden = $("#id_num_orden").text();

        Swal.fire({
            title: 'Fecha final',
            html: '<div class="form-row mt-4"><div class="form-group col-md-4"><p class="m-2 font-weight-bold">FECHA FINAL:</p></div>' +
                '<div class="form-group col-md-8"><input type="date" class="form-control" id="add_fecha_final"></div></div>' +
                '<div class="form-row"><div class="form-group col-md-4"><p class="m-2 font-weight-bold">HORA FINAL:</p></div>' +
                '<div class="form-group col-md-8"><input type="time" class="form-control mt-2" id="add_hora_final"></div></div>',
            stopKeydownPropagation: false,
            confirmButtonText: 'Guardar',
            showCancelButton: true,
            preConfirm: () => {
                fecha_final = $('#add_fecha_final').val();
                hora_final = $('#add_hora_final').val();

                if (fecha_final == '') {
                    return swal.showValidationError(
                        'Seleccione una fecha por favor'
                    );
                }
                if (hora_final == '') {
                    return swal.showValidationError(
                        'Seleccione una hora por favor'
                    );
                }

                $.ajax({
                    url: '../updateFechafinal',
                    data: {
                        num_orden: num_orden,
                        fecha_final: fecha_final,
                        hora_final: hora_final
                    },
                    type: 'post',
                    async: true,
                    success: function(response) {
                        Swal.fire('Saved!', 'la fecha se ha actualizado', 'success')
                    },
                    error: function(response) {
                        mensaje(response.responseText, 'error');
                    }
                }).done(function(data) {
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                });
            }
        })
    });

    $('#fecha_hora_final,#icon_fecha_final ').on('click', function() {
        let fecha_final, hora_final, num_orden;
        num_orden = $("#id_num_orden").text();

        Swal.fire({
            title: 'Fecha final',
            html: '<div class="form-row mt-4"><div class="form-group col-md-4"><p class="m-2 font-weight-bold">FECHA FINAL:</p></div>' +
                '<div class="form-group col-md-8"><input type="date" class="form-control" id="add_fecha_final"></div></div>' +
                '<div class="form-row"><div class="form-group col-md-4"><p class="m-2 font-weight-bold">HORA FINAL:</p></div>' +
                '<div class="form-group col-md-8"><input type="time" class="form-control mt-2" id="add_hora_final"></div></div>',
            stopKeydownPropagation: false,
            confirmButtonText: 'Guardar',
            showCancelButton: true,
            preConfirm: () => {
                fecha_final = $('#add_fecha_final').val();
                hora_final = $('#add_hora_final').val();

                if (fecha_final == '') {
                    return swal.showValidationError(
                        'Seleccione una fecha por favor'
                    );
                }
                if (hora_final == '') {
                    return swal.showValidationError(
                        'Seleccione una hora por favor'
                    );
                }

                $.ajax({
                    url: '../updateFechafinal',
                    data: {
                        num_orden: num_orden,
                        fecha_final: fecha_final,
                        hora_final: hora_final
                    },
                    type: 'post',
                    async: true,
                    success: function(response) {
                        Swal.fire('Guardado!', 'la fecha se ha actualizado', 'success')
                    },
                    error: function(response) {
                        mensaje(response.responseText, 'error');
                    }
                }).done(function(data) {
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                });
            }
        })
    });

    // Add Comment
    $('#btn_guardar_comment').on('click', function() {
        var comentario = $('#comentario').val(),
            num_orden = $("#id_num_orden").text();;
        if (comentario === '') {
            Swal.fire({
                title: '¡Comentario vacio!',
                text: "¿Desea guardarlo de todos modos?",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Continuar",
                closeOnConfirm: false,
            }).then((result) => {
                if (result.dismiss) {
                    Swal.fire('Cancelado!', 'Cambios no realizados', 'error')
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    addComment(num_orden, comentario);
                }
            });
        } else {
            addComment(num_orden, comentario);
        }
    });

    function addComment(num_orden, comentario) {
        $.ajax({
            url: '../addComment',
            data: {
                num_orden: num_orden,
                comentario: comentario,
            },
            type: 'post',
            async: true,
            success: function(response) {
                Swal.fire('Guardado!', 'Cambios Guardados', 'success')
            },
            error: function(response) {
                mensaje(response.responseText, 'error');
            }
        }).done(function(data) {
            setTimeout(function() {
                location.reload();
            }, 2000);
        });
    }

    function maxElement(element1, element2, array) {
        var index = element1 - element2;
        if (element1 > element2) {
            for (var i = 1; i <= index; i++) {
                array.push('0.00');
            }
        }
    }

    $('#fecha_hora_inicial').on('mouseover', function() {
        $(this).addClass('color-focus');
    });

    $('#fecha_hora_inicial').on('mouseleave', function() {
        $(this).removeClass('color-focus');
    });

    $('#fecha_hora_inicial').on('click', function() {
        let fecha_inicial, hora_incial, num_orden;
        num_orden = $("#id_num_orden").text();

        Swal.fire({
            title: 'Fecha inicial',
            html: '<div class="form-row mt-4"><div class="form-group col-md-4"><p class="m-2 font-weight-bold">FECHA INICIAL:</p></div>' +
                '<div class="form-group col-md-8"><input type="date" class="form-control" id="add_fecha_inicial"></div></div>' +
                '<div class="form-row"><div class="form-group col-md-4"><p class="m-2 font-weight-bold">HORA INICIAL:</p></div>' +
                '<div class="form-group col-md-8"><input type="time" class="form-control mt-2" id="add_hora_inicial"></div></div>',
            stopKeydownPropagation: false,
            confirmButtonText: 'Guardar',
            showCancelButton: true,
            preConfirm: () => {
                fecha_inicial = $('#add_fecha_inicial').val();
                hora_inicial = $('#add_hora_inicial').val();

                if (fecha_inicial == '') {
                    return swal.showValidationError(
                        'Seleccione una fecha por favor'
                    );
                }
                if (hora_inicial == '') {
                    return swal.showValidationError(
                        'Seleccione una hora por favor'
                    );
                }

                $.ajax({
                    url: '../updateFechaInicial',
                    data: {
                        num_orden: num_orden,
                        fecha_inicial: fecha_inicial,
                        hora_inicial: hora_inicial
                    },
                    type: 'post',
                    async: true,
                    success: function(response) {
                        Swal.fire('Guardado!', 'la fecha se ha actualizado', 'success')
                    },
                    error: function(response) {
                        mensaje(response.responseText, 'error');
                    }
                }).done(function(data) {
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                });
            }
        })
    });
    /**  detalles
     * 
     */
    $('#id_temp').on('click', function() {
        $('#mdlDetallesOrdes').modal('show');
        table = $('#tblMP');
        detalles_pc(table, 'tblMP');
        var periodo = $('#id_fecha_inicial').text() + ' ' + $('#id_hora_inicial').text() + ' Al ' + $('#id_fecha_final').text() + ' ' + $('#id_hora_final').text();
        $("#periodo").text(periodo);

    })
    $('nav .nav.nav-tabs a').click(function() {
        var idNav = $(this).attr('id');
        //console.log(idNav);
        switch (idNav) {
            case 'navMP':
                table = $('#tblMP');
                detalles_pc(table, 'tblMP');
                break;
            case 'navSbrEmpq':
                table = $('#tblSbrEmpq');
                detalles_pc(table, 'tblSbrEmpq');
                break;
            case 'navEP':
                table = $('#tblEP');
                detalles_pc(table, 'tblEP');
                break;
            case 'navQuimicos':
                table = $('#tblQuimicos');
                detalles_pc(table, 'tblQuimicos');
                break;
            default:
                alert('Al parecer alguio salio mal :(')
        }
    });

    function detalles_pc(table, name) {

        $.getJSON("../datos_detalles/" + id_orden, function(json) {


            /********************  @PRODUCTO  ******************************/
            var producto = Object.keys(json['producto']).map(key => {
                return json['producto'][key];
            });

            var id_producto = producto[0];
            
            if (id_producto == 2) {
                $('#navEP').hide();
                $('#nav-ep').hide();
            }

            table.empty();
            if (name === 'tblMP') {

                /******************  @JR AND @TUBOS_KRAFT  **********************/
                if (id_producto == 2) { // Papel generico
                    var producto_01 = Object.keys(json['ITEM14']).map(key => {
                        return json['ITEM14'][key];
                    })

                } else { // ecoplus //Vueno
                    var producto_01 = Object.keys(json['ITEM1']).map(key => {
                        return json['ITEM1'][key];
                    })
                }

                var producto_02 = Object.keys(json['ITEM2']).map(key => {
                    return json['ITEM2'][key];
                })

                index_p101 = producto_01.findIndex(x => x.ACTIVIDAD === "LP INICIAL");
                index_p102 = producto_01.findIndex(x => x.ACTIVIDAD === "REQUISADO");
                index_p103 = producto_01.findIndex(x => x.ACTIVIDAD === "MERMA");
                index_p104 = producto_01.findIndex(x => x.ACTIVIDAD === "LP FINAL");

                index_p201 = producto_02.findIndex(x => x.ACTIVIDAD === "LP INICIAL");
                index_p202 = producto_02.findIndex(x => x.ACTIVIDAD === "REQUISADO");
                index_p203 = producto_02.findIndex(x => x.ACTIVIDAD === "MERMA");
                index_p204 = producto_02.findIndex(x => x.ACTIVIDAD === "LP FINAL");

                var LP_INICIAL_row_1_p1 = producto_01[index_p101]['VALORES'];
                var REQUISADO_row_1_p1 = producto_01[index_p102]['VALORES'];
                var MERMA_row_1_p1 = producto_01[index_p103]['VALORES'];
                var LP_FINAL_row_1_p1 = producto_01[index_p104]['VALORES'];

                var LP_INICIAL_row_2_p2 = producto_02[index_p201]['VALORES'];
                var REQUISADO_row_2_p2 = producto_02[index_p202]['VALORES'];
                var MERMA_row_2_p2 = producto_02[index_p203]['VALORES'];
                var LP_FINAL_row_2_p2 = producto_02[index_p204]['VALORES'];

                var REQUISADOS_P1 = REQUISADO_row_1_p1.split(",");
                var REQUISADOS_P2 = REQUISADO_row_2_p2.split(",");

                var arrayRequisas = [];
                var totalRequisado1 = 0;
                var totalRequisado2 = 0;

                //Añadir elementos si algun Q es mayor
                maxElement(REQUISADOS_P1.length, REQUISADOS_P2.length, REQUISADOS_P2);
                maxElement(REQUISADOS_P2.length, REQUISADOS_P1.length, REQUISADOS_P1);

                arrayRequisas[0] = {
                    row_1: REQUISADOS_P1,
                    row_2: REQUISADOS_P2,
                };

                arrayRequisas.forEach(element => {
                    for (var j = 0; j < element.row_1.length; j++) {
                        totalRequisado1 += parseFloat(element.row_1[j]);
                        totalRequisado2 += parseFloat(element.row_2[j]);
                    }
                });

                var consumoP1 = parseFloat(LP_INICIAL_row_1_p1) + parseFloat(totalRequisado1) - parseFloat(MERMA_row_1_p1) - parseFloat(LP_FINAL_row_1_p1);
                var consumoP2 = 0;

                id_producto == 2 ? consumoP2 = parseFloat(LP_INICIAL_row_2_p2) + parseFloat(totalRequisado2) - parseFloat(MERMA_row_2_p2) - parseFloat(LP_FINAL_row_2_p2) : consumoP2 = parseFloat(LP_INICIAL_row_2_p2) + parseFloat(totalRequisado2) - parseFloat(LP_FINAL_row_2_p2);

                var merma_porcentual_P1 = parseFloat(MERMA_row_1_p1) / (consumoP1 + parseFloat(MERMA_row_1_p1)) * 100;
                var merma_porcentual_P2 = parseFloat(MERMA_row_2_p2) / (consumoP2 + parseFloat(MERMA_row_2_p2)) * 100;

                var peso = $('#id_peso_porcent').text();
                var merma_kg = 0;
                id_producto == 2 ? merma_kg = parseFloat(MERMA_row_2_p2) / 0.20 : merma_kg = parseFloat(MERMA_row_2_p2) * 0.20;
                console.log(LP_FINAL_row_1_p1);
                LP_INICIAL_row_1_p1 = numeral(LP_INICIAL_row_1_p1).format('0,0.00');
                LP_INICIAL_row_2_p2 = numeral(LP_INICIAL_row_2_p2).format('0,0.00');

                LP_FINAL_row_1_p1 = numeral(LP_FINAL_row_1_p1).format('0,0.00');
                LP_FINAL_row_2_p2 = numeral(LP_FINAL_row_2_p2).format('0,0.00');

                MERMA_row_1_p1 = numeral(MERMA_row_1_p1).format('0,0.00');
                MERMA_row_2_p2 = numeral(MERMA_row_2_p2).format('0,0.00');

                merma_kg = numeral(merma_kg).format('0,0.00');

                merma_porcentual_P1 = numeral(merma_porcentual_P1).format('0,0.00');
                merma_porcentual_P2 = numeral(merma_porcentual_P2).format('0,0.00');

                consumoP1 = numeral(consumoP1).format('0,0.00');
                consumoP2 = numeral(consumoP2).format('0,0.00');

                var data = [
                    ["ACTIVIDAD", "JUMBO ROLL", "TUBOS KRAFT"],
                    ["LP INICIAL ", LP_INICIAL_row_1_p1, LP_INICIAL_row_2_p2],
                    [arrayRequisas],
                    ["LP FINAL ", LP_FINAL_row_1_p1, LP_FINAL_row_2_p2],
                    ["MERMA (KG)", MERMA_row_1_p1, merma_kg],
                    ["MERMA (UND) ", '0.00', MERMA_row_2_p2],
                    ["MERMA (%)", merma_porcentual_P1, merma_porcentual_P2],
                    ["CONSUMO ", consumoP1, consumoP2],
                    ["PESO ", peso, '0.00'],
                ]

                var cityTable = makeTable(table, data, 1);
            } else if (name == 'tblSbrEmpq') {
                /******************  @SOBREEMPAQUE  **********************/


                var producto_03 = Object.keys(json['ITEM3']).map(key => {
                    return json['ITEM3'][key];
                })

                var producto_04 = Object.keys(json['ITEM8']).map(key => {
                    return json['ITEM8'][key];
                })

                var producto_05 = Object.keys(json['ITEM9']).map(key => {
                    return json['ITEM9'][key];
                })

                index_p301 = producto_03.findIndex(x => x.ACTIVIDAD === "LP INICIAL");
                index_p302 = producto_03.findIndex(x => x.ACTIVIDAD === "REQUISADO");
                index_p303 = producto_03.findIndex(x => x.ACTIVIDAD === "MERMA");
                index_p304 = producto_03.findIndex(x => x.ACTIVIDAD === "LP FINAL");

                index_p401 = producto_04.findIndex(x => x.ACTIVIDAD === "LP INICIAL");
                index_p402 = producto_04.findIndex(x => x.ACTIVIDAD === "REQUISADO");
                index_p403 = producto_04.findIndex(x => x.ACTIVIDAD === "MERMA");
                index_p404 = producto_04.findIndex(x => x.ACTIVIDAD === "LP FINAL");

                index_p501 = producto_05.findIndex(x => x.ACTIVIDAD === "LP INICIAL");
                index_p502 = producto_05.findIndex(x => x.ACTIVIDAD === "REQUISADO");
                index_p503 = producto_05.findIndex(x => x.ACTIVIDAD === "MERMA");
                index_p504 = producto_05.findIndex(x => x.ACTIVIDAD === "LP FINAL");

                var LP_INICIAL_row_1_p3 = producto_03[index_p301]['VALORES'];
                var REQUISADO_row_1_p3 = producto_03[index_p302]['VALORES'];
                var MERMA_row_1_p3 = producto_03[index_p303]['VALORES'];
                var LP_FINAL_row_1_p3 = producto_03[index_p304]['VALORES'];

                var LP_INICIAL_row_2_p4 = producto_04[index_p401]['VALORES'];
                var REQUISADO_row_2_p4 = producto_04[index_p402]['VALORES'];
                var MERMA_row_2_p4 = producto_04[index_p403]['VALORES'];
                var LP_FINAL_row_2_p4 = producto_04[index_p404]['VALORES'];

                var LP_INICIAL_row_3_p5 = producto_05[index_p501]['VALORES'];
                var REQUISADO_row_3_p5 = producto_05[index_p502]['VALORES'];
                var MERMA_row_3_p5 = producto_05[index_p503]['VALORES'];
                var LP_FINAL_row_3_p5 = producto_05[index_p504]['VALORES'];

                var REQUISADOS_P3 = REQUISADO_row_1_p3.split(",");
                var REQUISADOS_P4 = REQUISADO_row_2_p4.split(",");
                var REQUISADOS_P5 = REQUISADO_row_3_p5.split(",");

                var arrayRequisas2 = [];

                //Añadir elementos si P3 es mayor
                maxElement(REQUISADOS_P3.length, REQUISADOS_P4.length, REQUISADOS_P4);
                maxElement(REQUISADOS_P3.length, REQUISADOS_P5.length, REQUISADOS_P5);
                //Añadir elementos si P4 es mayor
                maxElement(REQUISADOS_P4.length, REQUISADOS_P3.length, REQUISADOS_P5);
                maxElement(REQUISADOS_P4.length, REQUISADOS_P5.length, REQUISADOS_P5);
                //Añadir elementos si P5 es mayor
                maxElement(REQUISADOS_P5.length, REQUISADOS_P3.length, REQUISADOS_P3);
                maxElement(REQUISADOS_P5.length, REQUISADOS_P4.length, REQUISADOS_P4);

                arrayRequisas2[0] = {
                    row_1: REQUISADOS_P3,
                    row_2: REQUISADOS_P4,
                    row_3: REQUISADOS_P5
                }

                var totalRequisadoP3 = 0,
                    totalRequisadoP4 = 0,
                    totalRequisadoP5 = 0;

                arrayRequisas2.forEach(element => {
                    for (var j = 0; j < element.row_1.length; j++) {
                        totalRequisadoP3 += parseFloat(element.row_1[j]);
                        totalRequisadoP4 += parseFloat(element.row_2[j]);
                        totalRequisadoP5 += parseFloat(element.row_3[j]);
                        // console.log('Cantidades= ' + element.row_1[j] + ' ' + element.row_2[j] + ' ' + element.row_3[j]);
                    }
                });

                var total_bultos = $("#id_total_bultos_und").text().replace(/[',]+/g, '');
                var consumoP3 = parseFloat(LP_INICIAL_row_1_p3) + totalRequisadoP3 - parseFloat(MERMA_row_1_p3) - parseFloat(LP_FINAL_row_1_p3);
                var consumoP4 = parseFloat(LP_INICIAL_row_2_p4) + totalRequisadoP4 - parseFloat(MERMA_row_2_p4) - parseFloat(LP_FINAL_row_2_p4);
                var consumoP5 = parseFloat(LP_INICIAL_row_3_p5) + totalRequisadoP5 - parseFloat(MERMA_row_3_p5) - parseFloat(LP_FINAL_row_3_p5);

                var merma_porcentual_P3 = parseFloat(MERMA_row_1_p3) / (consumoP3 + parseFloat(MERMA_row_1_p3)) * 100;
                var merma_porcentual_P4 = parseFloat(MERMA_row_2_p4) / (consumoP4 + parseFloat(MERMA_row_2_p4)) * 100;
                var merma_porcentual_P5 = parseFloat(MERMA_row_3_p5) / (consumoP5 + parseFloat(MERMA_row_3_p5)) * 100;

                var consumoTotal_SE = consumoP3 + consumoP4 + consumoP5;
                var merma_porcentual_total = merma_porcentual_P3 + merma_porcentual_P4 + merma_porcentual_P5;
                var merma_total = parseFloat(MERMA_row_1_p3) + parseFloat(MERMA_row_2_p4) + parseFloat(MERMA_row_3_p5);
                var lp_final_total = parseFloat(LP_FINAL_row_1_p3) + parseFloat(LP_FINAL_row_2_p4) + parseFloat(LP_FINAL_row_3_p5);
                var lp_inicial_total = parseFloat(LP_INICIAL_row_1_p3) + parseFloat(LP_INICIAL_row_2_p4) + parseFloat(LP_INICIAL_row_3_p5);

                var faltante_P3 = consumoP3 - parseFloat(total_bultos);
                var faltante_P4 = consumoP4 - parseFloat(total_bultos);
                console.log(Math.sign(parseFloat(faltante_P3)));

                var sobrante_P3 = parseFloat(total_bultos) - consumoP3;
                var sobrante_P4 = parseFloat(total_bultos) - consumoP4;

                var faltante_total = faltante_P3 + faltante_P4;
                var sobrante_total = sobrante_P3 + sobrante_P4;

                consumoP3 = numeral(consumoP3).format('0,0.00');
                consumoP4 = numeral(consumoP4).format('0,0.00');
                consumoP5 = numeral(consumoP5).format('0,0.00');

                merma_porcentual_P3 = numeral(merma_porcentual_P3).format('0,0.00');
                merma_porcentual_P4 = numeral(merma_porcentual_P4).format('0,0.00');
                merma_porcentual_P5 = numeral(merma_porcentual_P5).format('0,0.00');

                consumoTotal_SE = numeral(consumoTotal_SE).format('0,0.00');
                merma_porcentual_total = numeral(merma_porcentual_total).format('0,0.00')
                merma_total = numeral(merma_total).format('0,0.00');
                lp_final_total = numeral(lp_final_total).format('0,0.00');
                lp_inicial_total = numeral(lp_inicial_total).format('0,0.00');

                LP_INICIAL_row_1_p3 = numeral(LP_INICIAL_row_1_p3).format('0,0.00');
                LP_INICIAL_row_2_p4 = numeral(LP_INICIAL_row_2_p4).format('0,0.00');
                LP_INICIAL_row_3_p5 = numeral(LP_INICIAL_row_3_p5).format('0,0.00');

                LP_FINAL_row_1_p3 = numeral(LP_FINAL_row_1_p3).format('0,0.00');
                LP_FINAL_row_2_p4 = numeral(LP_FINAL_row_2_p4).format('0,0.00');
                LP_FINAL_row_3_p5 = numeral(LP_FINAL_row_3_p5).format('0,0.00');

                MERMA_row_1_p3 = numeral(MERMA_row_1_p3).format('0,0.00');
                MERMA_row_2_p4 = numeral(MERMA_row_2_p4).format('0,0.00');
                MERMA_row_3_p5 = numeral(MERMA_row_3_p5).format('0,0.00');

                faltante_P3 = numeral(faltante_P3).format('0,0.00');
                faltante_P4 = numeral(faltante_P4).format('0,0.00');
                sobrante_P3 = numeral(sobrante_P3).format('0,0.00');
                sobrante_P4 = numeral(sobrante_P4).format('0,0.00');


                faltante_P3 = (Math.sign(parseFloat(faltante_P3)) == '-1' ? faltante_P3.replace("-", "(") + ')' : faltante_P3);
                faltante_P4 = (Math.sign(parseFloat(faltante_P4)) == '-1' ? faltante_P4.replace("-", "(") + ')' : faltante_P4);

                sobrante_P3 = (Math.sign(parseFloat(sobrante_P3)) == '-1' ? sobrante_P3.replace("-", "(") + ')' : sobrante_P3);
                sobrante_P4 = (Math.sign(parseFloat(sobrante_P4)) == '-1' ? sobrante_P4.replace("-", "(") + ')' : sobrante_P4);

                faltante_total = numeral(faltante_total).format('0,0.00');
                sobrante_total = numeral(sobrante_total).format('0,0.00');

                faltante_total = (Math.sign(parseFloat(faltante_total)) == '-1' ? faltante_total.replace("-", "(") + ')' : faltante_total);
                sobrante_total = (Math.sign(parseFloat(sobrante_total)) == '-1' ? sobrante_total.replace("-", "(") + ')' : sobrante_total);



                data = [
                    ["ACTIVIDAD", "COG. 114", "COG. 67 ", "COG.92", "TOTAL BOLSAS"],
                    ["LP INICIAL ", LP_INICIAL_row_1_p3, LP_INICIAL_row_2_p4, LP_INICIAL_row_3_p5, lp_inicial_total],
                    [arrayRequisas2],
                    ["LP FINAL ", LP_FINAL_row_1_p3, LP_FINAL_row_2_p4, LP_FINAL_row_3_p5, lp_final_total],
                    ["MERMA (UND)", MERMA_row_1_p3, MERMA_row_2_p4, MERMA_row_3_p5, merma_total],
                    ["MERMA (%)", merma_porcentual_P3, merma_porcentual_P4, merma_porcentual_P5, merma_porcentual_total],
                    ["CONSUMO ", consumoP3, consumoP4, consumoP5, consumoTotal_SE],
                    ["FALTANTE ", faltante_P3, faltante_P4, '-', faltante_total],
                    ["SOBRANTE ", sobrante_P3, sobrante_P4, '-', sobrante_total],
                ]

                cityTable = makeTable(table, data, 2);
            } else if (name === 'tblEP') {
                /*************************************  @EMPAQUE_PRIMARIO  **********************/
                if (id_producto == 1 || id_producto == 7) {
                    var producto_06 = Object.keys(json['ITEM4']).map(key => {
                        return json['ITEM4'][key];
                    })

                    var producto_07 = Object.keys(json['ITEM11']).map(key => {
                        return json['ITEM11'][key];
                    })

                    var producto_08 = Object.keys(json['ITEM10']).map(key => {
                        return json['ITEM10'][key];
                    })

                    var producto_09 = Object.keys(json['ITEM5']).map(key => {
                        return json['ITEM5'][key];
                    })

                    var producto_10 = Object.keys(json['ITEM6']).map(key => { // PAPEL VUENO COD.141
                        return json['ITEM6'][key];
                    })

                    index_p601 = producto_06.findIndex(x => x.ACTIVIDAD === "LP INICIAL");
                    index_p602 = producto_06.findIndex(x => x.ACTIVIDAD === "REQUISADO");
                    index_p603 = producto_06.findIndex(x => x.ACTIVIDAD === "MERMA");
                    index_p604 = producto_06.findIndex(x => x.ACTIVIDAD === "LP FINAL");

                    index_p701 = producto_07.findIndex(x => x.ACTIVIDAD === "LP INICIAL");
                    index_p702 = producto_07.findIndex(x => x.ACTIVIDAD === "REQUISADO");
                    index_p703 = producto_07.findIndex(x => x.ACTIVIDAD === "MERMA");
                    index_p704 = producto_07.findIndex(x => x.ACTIVIDAD === "LP FINAL");

                    index_p801 = producto_08.findIndex(x => x.ACTIVIDAD === "LP INICIAL");
                    index_p802 = producto_08.findIndex(x => x.ACTIVIDAD === "REQUISADO");
                    index_p803 = producto_08.findIndex(x => x.ACTIVIDAD === "MERMA");
                    index_p804 = producto_08.findIndex(x => x.ACTIVIDAD === "LP FINAL");

                    index_p901 = producto_09.findIndex(x => x.ACTIVIDAD === "LP INICIAL");
                    index_p902 = producto_09.findIndex(x => x.ACTIVIDAD === "REQUISADO");
                    index_p903 = producto_09.findIndex(x => x.ACTIVIDAD === "MERMA");
                    index_p904 = producto_09.findIndex(x => x.ACTIVIDAD === "LP FINAL");

                    index_p10_01 = producto_10.findIndex(x => x.ACTIVIDAD === "LP INICIAL");
                    index_p10_02 = producto_10.findIndex(x => x.ACTIVIDAD === "REQUISADO");
                    index_p10_03 = producto_10.findIndex(x => x.ACTIVIDAD === "MERMA");
                    index_p10_04 = producto_10.findIndex(x => x.ACTIVIDAD === "LP FINAL");

                    var LP_INICIAL_row_1_p6 = producto_06[index_p601]['VALORES'];
                    var REQUISADO_row_1_p6 = producto_06[index_p602]['VALORES'];
                    var MERMA_row_1_p6 = producto_06[index_p603]['VALORES'];
                    var LP_FINAL_row_1_p6 = producto_06[index_p604]['VALORES'];

                    var LP_INICIAL_row_2_p7 = producto_07[index_p701]['VALORES'];
                    var REQUISADO_row_2_p7 = producto_07[index_p702]['VALORES'];
                    var MERMA_row_2_p7 = producto_07[index_p703]['VALORES'];
                    var LP_FINAL_row_2_p7 = producto_07[index_p704]['VALORES'];

                    var LP_INICIAL_row_3_p8 = producto_08[index_p801]['VALORES'];
                    var REQUISADO_row_3_p8 = producto_08[index_p802]['VALORES'];
                    var MERMA_row_3_p8 = producto_08[index_p803]['VALORES'];
                    var LP_FINAL_row_3_p8 = producto_08[index_p804]['VALORES'];

                    var LP_INICIAL_row_4_p9 = producto_09[index_p901]['VALORES'];
                    var REQUISADO_row_4_p9 = producto_09[index_p902]['VALORES'];
                    var MERMA_row_4_p9 = producto_09[index_p903]['VALORES'];
                    var LP_FINAL_row_4_p9 = producto_09[index_p904]['VALORES'];

                    var LP_INICIAL_row_5_p10 = producto_10[index_p10_01]['VALORES'];
                    var REQUISADO_row_5_p10 = producto_10[index_p10_02]['VALORES'];
                    var MERMA_row_5_p10 = producto_10[index_p10_03]['VALORES'];
                    var LP_FINAL_row_5_p10 = producto_10[index_p10_04]['VALORES'];

                    var REQUISADOS_P6 = REQUISADO_row_1_p6.split(",");
                    var REQUISADOS_P7 = REQUISADO_row_2_p7.split(",");
                    var REQUISADOS_P8 = REQUISADO_row_3_p8.split(",");
                    var REQUISADOS_P9 = REQUISADO_row_4_p9.split(",");
                    var REQUISADOS_P10 = REQUISADO_row_5_p10.split(",");

                    var arrayRequisas3 = [];

                    //Añadir elementos si P6 es mayor
                    maxElement(REQUISADOS_P6.length, REQUISADOS_P7.length, REQUISADOS_P7);
                    maxElement(REQUISADOS_P6.length, REQUISADOS_P8.length, REQUISADOS_P8);
                    maxElement(REQUISADOS_P6.length, REQUISADOS_P9.length, REQUISADOS_P9);
                    maxElement(REQUISADOS_P6.length, REQUISADOS_P10.length, REQUISADOS_P10);
                    //Añadir elementos si P7 es mayor
                    maxElement(REQUISADOS_P7.length, REQUISADOS_P6.length, REQUISADOS_P6);
                    maxElement(REQUISADOS_P7.length, REQUISADOS_P8.length, REQUISADOS_P8);
                    maxElement(REQUISADOS_P7.length, REQUISADOS_P9.length, REQUISADOS_P9);
                    maxElement(REQUISADOS_P7.length, REQUISADOS_P10.length, REQUISADOS_P10);
                    //Añadir elementos si P8 es mayor
                    maxElement(REQUISADOS_P8.length, REQUISADOS_P6.length, REQUISADOS_P6);
                    maxElement(REQUISADOS_P8.length, REQUISADOS_P7.length, REQUISADOS_P7);
                    maxElement(REQUISADOS_P8.length, REQUISADOS_P9.length, REQUISADOS_P9);
                    maxElement(REQUISADOS_P8.length, REQUISADOS_P10.length, REQUISADOS_P10);

                    //Añadir elementos si P9 es mayor
                    maxElement(REQUISADOS_P9.length, REQUISADOS_P6.length, REQUISADOS_P6);
                    maxElement(REQUISADOS_P9.length, REQUISADOS_P7.length, REQUISADOS_P7);
                    maxElement(REQUISADOS_P9.length, REQUISADOS_P8.length, REQUISADOS_P8);
                    maxElement(REQUISADOS_P9.length, REQUISADOS_P10.length, REQUISADOS_P10);

                    //Añadir elementos si P10 es mayor
                    maxElement(REQUISADOS_P10.length, REQUISADOS_P6.length, REQUISADOS_P6);
                    maxElement(REQUISADOS_P10.length, REQUISADOS_P7.length, REQUISADOS_P7);
                    maxElement(REQUISADOS_P10.length, REQUISADOS_P8.length, REQUISADOS_P8);
                    maxElement(REQUISADOS_P10.length, REQUISADOS_P9.length, REQUISADOS_P9);

                    arrayRequisas3[0] = {
                        row_1: REQUISADOS_P6,
                        row_2: REQUISADOS_P7,
                        row_3: REQUISADOS_P8,
                        row_4: REQUISADOS_P9,
                        row_5: REQUISADOS_P10

                    }

                    //console.log(arrayRequisas3);
                    var totalRequisadoP6 = 0,
                        totalRequisadoP7 = 0,
                        totalRequisadoP8 = 0,
                        totalRequisadoP9 = 0;
                    totalRequisadoP10 = 0;

                    arrayRequisas3.forEach(element => {
                        for (var j = 0; j < element.row_1.length; j++) {
                            totalRequisadoP6 += parseFloat(element.row_1[j]);
                            totalRequisadoP7 += parseFloat(element.row_2[j]);
                            totalRequisadoP8 += parseFloat(element.row_3[j]);
                            totalRequisadoP9 += parseFloat(element.row_4[j]);
                            totalRequisadoP10 += parseFloat(element.row_5[j]);

                        }
                    });

                    var consumoP6 = parseFloat(LP_INICIAL_row_1_p6) + totalRequisadoP6 - parseFloat(LP_FINAL_row_1_p6);
                    var consumoP7 = parseFloat(LP_INICIAL_row_2_p7) + totalRequisadoP7 - parseFloat(LP_FINAL_row_2_p7);
                    var consumoP8 = parseFloat(LP_INICIAL_row_3_p8) + totalRequisadoP8 - parseFloat(MERMA_row_3_p8) - parseFloat(LP_FINAL_row_3_p8);
                    var consumoP9 = parseFloat(LP_INICIAL_row_4_p9) + totalRequisadoP9 - parseFloat(MERMA_row_4_p9) - parseFloat(LP_FINAL_row_4_p9);
                    var consumoP10 = parseFloat(LP_INICIAL_row_5_p10) + totalRequisadoP10 - parseFloat(MERMA_row_5_p10) - parseFloat(LP_FINAL_row_5_p10);

                    var merma_porcentual_P6 = parseFloat(MERMA_row_1_p6) / (consumoP6 + parseFloat(MERMA_row_1_p6)) * 100;
                    var merma_porcentual_P7 = parseFloat(MERMA_row_2_p7) / (consumoP7 + parseFloat(MERMA_row_2_p7)) * 100;
                    var merma_porcentual_P8 = parseFloat(MERMA_row_3_p8) / (consumoP8 + parseFloat(MERMA_row_3_p8)) * 100;
                    var merma_porcentual_P9 = parseFloat(MERMA_row_4_p9) / (consumoP9 + parseFloat(MERMA_row_4_p9)) * 100;
                    var merma_porcentual_P10 = parseFloat(MERMA_row_5_p10) / (consumoP10 + parseFloat(MERMA_row_5_p10)) * 100;

                    /********************************************************************************************************** */
                    if (id_producto == 1) { //PAPEL HIGIENICO ECOPLUS
                        //PAPIEL EXOPLIUS COG.27
                        var rollos_esperados_P6 = consumoP6 / 0.0035;
                        var bolsones_producir_P6 = parseFloat(rollos_esperados_P6 / 24);
                        var No_bolsones_P6 = $('#tblProductos > tbody > tr:nth-child(2) > td:nth-child(3)').text().replace(/[',]+/g, '');
                        var diferencial_P6 = (parseFloat(bolsones_producir_P6) - parseFloat(No_bolsones_P6));
                        //CHOLIN COD.52 PRODUCTO 7
                        var No_bolsones_P7 = $('#tblProductos > tbody > tr:nth-child(3) > td:nth-child(3)').text().replace(/[',]+/g, '');
                        var rollos_esperados_P7 = consumoP7 / 0.003;
                        var bolsones_producir_P7 = rollos_esperados_P7 / 24;
                        var diferencial_P7 = (parseFloat(bolsones_producir_P7) - parseFloat(No_bolsones_P7));
                        //FOURPACK COD.100 
                        var No_bolsones_P8 = $('#tblProductos > tbody > tr:nth-child(1) > td:nth-child(3)').text().replace(/[',]+/g, '');;
                        var rollos_esperados_P8 = consumoP8 / 70;
                        var bolsones_producir_P8 = rollos_esperados_P8 / 24;
                        var diferencial_P8 = (parseFloat(bolsones_producir_P8) - parseFloat(No_bolsones_P8));
                        //CHOLIN 6 PACK COG.103
                        var No_bolsones_P9 = $('#tblProductos > tbody > tr:nth-child(8) > td:nth-child(3)').text().replace(/[',]+/g, '');
                        var rollos_esperados_P9 = No_bolsones_P9 / 4;
                        var bolsones_producir_P9 = No_bolsones_P9 * 4;
                        var diferencial_P9 = (consumoP9 - parseFloat(bolsones_producir_P9));
                        //PAPEL VUENO COD.141
                        var No_bolsones_P10 = $('#tblProductos > tbody > tr:nth-child(9) > td:nth-child(3)').text().replace(/[',]+/g, '');
                        var rollos_esperados_P10 = No_bolsones_P10 / 4;
                        var bolsones_producir_P10 = No_bolsones_P10 * 4;
                        var diferencial_P10 = (consumoP10 - parseFloat(bolsones_producir_P10));

                        var EP_bolson_P8 = 6;
                        var EP_utilizado_P8 = EP_bolson_P8 * 24;

                        var EP_bolson_P9 = 4;
                        var EP_utilizado_P9 = EP_bolson_P9 * 24;

                        var faltante_P8 = consumoP8 - (EP_bolson_P8 * No_bolsones_P8);
                        var sobrante_P8 = (EP_bolson_P8 * No_bolsones_P8) - consumoP8;

                        var faltante_P9 = consumoP9 - (EP_bolson_P9 * No_bolsones_P9);
                        var Sobrante_P9 = (EP_bolson_P9 * No_bolsones_P9) - consumoP9;

                        consumoP6 = numeral(consumoP6).format('0,0.00');
                        consumoP7 = numeral(consumoP7).format('0,0.00');
                        consumoP8 = numeral(consumoP8).format('0,0.00');
                        consumoP9 = numeral(consumoP9).format('0,0.00');
                        consumoP10 = numeral(consumoP10).format('0,0.00');

                        merma_porcentual_P6 = numeral(merma_porcentual_P6).format('0,0.00');
                        merma_porcentual_P7 = numeral(merma_porcentual_P7).format('0,0.00');
                        merma_porcentual_P8 = numeral(merma_porcentual_P8).format('0,0.00');
                        merma_porcentual_P9 = numeral(merma_porcentual_P9).format('0,0.00');
                        merma_porcentual_P10 = numeral(merma_porcentual_P10).format('0,0.00');

                        LP_INICIAL_row_1_p6 = numeral(LP_INICIAL_row_1_p6).format('0,0.00');
                        LP_INICIAL_row_2_p7 = numeral(LP_INICIAL_row_2_p7).format('0,0.00');
                        LP_INICIAL_row_3_p8 = numeral(LP_INICIAL_row_3_p8).format('0,0.00');
                        LP_INICIAL_row_4_p9 = numeral(LP_INICIAL_row_4_p9).format('0,0.00');
                        LP_INICIAL_row_5_p10 = numeral(LP_INICIAL_row_5_p10).format('0,0.00');

                        LP_FINAL_row_1_p6 = numeral(LP_FINAL_row_1_p6).format('0,0.00');
                        LP_FINAL_row_2_p7 = numeral(LP_FINAL_row_2_p7).format('0,0.00');
                        LP_FINAL_row_3_p8 = numeral(LP_FINAL_row_3_p8).format('0,0.00');
                        LP_FINAL_row_4_p9 = numeral(LP_FINAL_row_4_p9).format('0,0.00');
                        LP_FINAL_row_5_p10 = numeral(LP_FINAL_row_5_p10).format('0,0.00');

                        MERMA_row_1_p6 = numeral(MERMA_row_1_p6).format('0,0.00');
                        MERMA_row_2_p7 = numeral(MERMA_row_2_p7).format('0,0.00');
                        MERMA_row_3_p8 = numeral(MERMA_row_3_p8).format('0,0.00');
                        MERMA_row_4_p9 = numeral(MERMA_row_4_p9).format('0,0.00');
                        MERMA_row_5_p10 = numeral(MERMA_row_5_p10).format('0,0.00');

                        rollos_esperados_P6 = numeral(rollos_esperados_P6).format('0,0.00');
                        bolsones_producir_P6 = numeral(bolsones_producir_P6).format('0,0.00');
                        No_bolsones_P6 = numeral(No_bolsones_P6).format('0,0.00');
                        diferencial_P6 = numeral(diferencial_P6).format('0,0.00');

                        rollos_esperados_P7 = numeral(diferencial_P7).format('0,0.00');
                        bolsones_producir_P7 = numeral(bolsones_producir_P7).format('0,0.00');
                        No_bolsones_P7 = numeral(No_bolsones_P7).format('0,0.00');
                        diferencial_P7 = numeral(diferencial_P7).format('0,0.00');

                        rollos_esperados_P8 = numeral(rollos_esperados_P8).format('0,0.00');
                        bolsones_producir_P8 = numeral(bolsones_producir_P8).format('0,0.00');
                        No_bolsones_P8 = numeral(No_bolsones_P8).format('0,0.00');
                        diferencial_P8 = numeral(diferencial_P8).format('0,0.00');

                        EP_bolson_P8 = numeral(EP_bolson_P8).format('0,0.00');
                        EP_utilizado_P8 = numeral(EP_utilizado_P8).format('0,0.00');

                        rollos_esperados_P9 = numeral(rollos_esperados_P9).format('0,0.00');
                        bolsones_producir_P9 = numeral(bolsones_producir_P9).format('0,0.00');
                        No_bolsones_P9 = numeral(No_bolsones_P9).format('0,0.00');
                        diferencial_P9 = numeral(diferencial_P9).format('0,0.00');

                        EP_bolson_P9 = numeral(EP_bolson_P9).format('0,0.00');
                        EP_utilizado_P9 = numeral(EP_utilizado_P9).format('0,0.00');

                        rollos_esperados_P10 = numeral(rollos_esperados_P10).format('0,0.00');
                        bolsones_producir_P10 = numeral(bolsones_producir_P10).format('0,0.00');
                        No_bolsones_P10 = numeral(No_bolsones_P10).format('0,0.00');
                        diferencial_P10 = numeral(diferencial_P10).format('0,0.00');

                        faltante_P8 = numeral(faltante_P8).format('0,0.00');
                        sobrante_P8 = numeral(sobrante_P8).format('0,0.00');
                        faltante_P9 = numeral(faltante_P9).format('0,0.00');
                        Sobrante_P9 = numeral(Sobrante_P9).format('0,0.00');

                        faltante_P8 = (Math.sign(parseFloat(faltante_P8)) == '-1' ? faltante_P8.replace("-", "(") + ')' : faltante_P8);
                        faltante_P9 = (Math.sign(parseFloat(faltante_P9)) == '-1' ? faltante_P9.replace("-", "(") + ')' : faltante_P9);

                        sobrante_P8 = (Math.sign(parseFloat(sobrante_P8)) == '-1' ? sobrante_P8.replace("-", "(") + ')' : sobrante_P8);
                        Sobrante_P9 = (Math.sign(parseFloat(Sobrante_P9)) == '-1' ? Sobrante_P9.replace("-", "(") + ')' : Sobrante_P9);

                        data = [
                            ["ACTIVIDAD", "PAPIEL ECO. COG.27", "CHOLIN COG.52", "FOURPACK COG.100", "CHOLIN 6 PACK COG.103", "PAPEL VUENO COG.141"],
                            ["LP INICIAL ", LP_INICIAL_row_1_p6, LP_INICIAL_row_2_p7, LP_INICIAL_row_3_p8, LP_INICIAL_row_4_p9, LP_INICIAL_row_5_p10],
                            [arrayRequisas3],
                            ["LP FINAL ", LP_FINAL_row_1_p6, LP_FINAL_row_2_p7, LP_FINAL_row_3_p8, LP_FINAL_row_4_p9, LP_FINAL_row_5_p10],
                            ["MERMA (UND)", MERMA_row_1_p6, MERMA_row_2_p7, MERMA_row_3_p8, MERMA_row_4_p9, MERMA_row_5_p10],
                            ["MERMA (%)", merma_porcentual_P6, merma_porcentual_P7, merma_porcentual_P8, merma_porcentual_P9, merma_porcentual_P10],
                            ["CONSUMO ", consumoP6, consumoP7, consumoP8, consumoP9, consumoP10],
                            ["E/P - POR BOLSON", '0.00', '0.00', EP_bolson_P8, EP_bolson_P9, '0.00'],
                            ["E/P -UTILIZADO", '0.00', '0.00', EP_utilizado_P8, EP_utilizado_P9, '0.00'],
                            ["ROLLOS ESPERADOS ", rollos_esperados_P6, rollos_esperados_P7, rollos_esperados_P8, rollos_esperados_P9, rollos_esperados_P10],
                            ["BOLSONES A PRODUCIR ", bolsones_producir_P6, bolsones_producir_P7, bolsones_producir_P8, bolsones_producir_P9, bolsones_producir_P10],
                            ["No. BOLSONES", No_bolsones_P6, No_bolsones_P7, No_bolsones_P8, No_bolsones_P9, No_bolsones_P10],
                            ["DIFERENCIAL", diferencial_P6, diferencial_P7, '-', '-', '-'],
                            ["FALTANTE", '-', '-', faltante_P8, faltante_P9, '-'],
                            ["SOBRANTE", '-', '-', sobrante_P8, Sobrante_P9, '-'],

                        ]

                        cityTable = makeTable(table, data, 3);

                    } else if (id_producto == 7) {
                        //PAPEL VUENO COD.141
                        var No_bolsones_P10 = $('#tblProductos > tbody > tr:nth-child(1) > td:nth-child(3)').text().replace(/[',]+/g, '');
                        var rollos_esperados_P10 = No_bolsones_P10 / 4;
                        var bolsones_producir_P10 = No_bolsones_P10 * 4;

                        var EP_bolson_P10 = 24;
                        var EP_utilizado_P10 = EP_bolson_P10 * No_bolsones_P10;
                        var diferencial_P10 = (consumoP10 - parseFloat(bolsones_producir_P10));

                        //PAPIEL ECOPLIUS COG.27
                        var rollos_esperados_P6 = consumoP6 / 0.0035;
                        var bolsones_producir_P6 = parseFloat(rollos_esperados_P6 / 24);
                        var No_bolsones_P6 = $('#tblProductos > tbody > tr:nth-child(3) > td:nth-child(3)').text().replace(/[',]+/g, '');
                        var diferencial_P6 = (parseFloat(bolsones_producir_P6) - parseFloat(No_bolsones_P6));
                        //CHOLIN COD.52
                        var No_bolsones_P7 = $('#tblProductos > tbody > tr:nth-child(4) > td:nth-child(3)').text().replace(/[',]+/g, '');
                        var rollos_esperados_P7 = consumoP7 / 0.003;
                        var bolsones_producir_P7 = rollos_esperados_P7 / 24;
                        var diferencial_P7 = (parseFloat(bolsones_producir_P7) - parseFloat(No_bolsones_P7));
                        //FOURPACK COD.100 
                        var No_bolsones_P8 = $('#tblProductos > tbody > tr:nth-child(2) > td:nth-child(3)').text().replace(/[',]+/g, '');;
                        var rollos_esperados_P8 = consumoP8 / 70;
                        var bolsones_producir_P8 = rollos_esperados_P8 / 24;
                        var EP_bolson_P8 = 6;
                        var EP_utilizado_P8 = EP_bolson_P8 * No_bolsones_P8;
                        var diferencial_P8 = consumoP8 - EP_utilizado_P8;
                        //CHOLIN 6 PACK COG.103
                        var No_bolsones_P9 = $('#tblProductos > tbody > tr:nth-child(9) > td:nth-child(3)').text().replace(/[',]+/g, '');
                        var rollos_esperados_P9 = No_bolsones_P9 / 4;
                        var bolsones_producir_P9 = No_bolsones_P9 * 4;
                        var EP_bolson_P9 = 4;
                        var EP_utilizado_P9 = EP_bolson_P9 * No_bolsones_P9;
                        var diferencial_P9 = consumoP9 - EP_utilizado_P9;

                        var faltante_P8 = consumoP8 - (EP_bolson_P8 * No_bolsones_P8);
                        var sobrante_P8 = (EP_bolson_P8 * No_bolsones_P8) - consumoP8;

                        var faltante_P9 = consumoP9 - (EP_bolson_P9 * No_bolsones_P9);
                        var Sobrante_P9 = (EP_bolson_P9 * No_bolsones_P9) - consumoP9;

                        var faltante_P9 = consumoP9 - (EP_bolson_P9 * No_bolsones_P9);
                        var Sobrante_P9 = (EP_bolson_P9 * No_bolsones_P9) - consumoP9;

                        var faltante_P10 = consumoP10 - (EP_bolson_P10 * No_bolsones_P10);
                        var Sobrante_P10 = (EP_bolson_P10 * No_bolsones_P10) - consumoP10;

                        consumoP6 = numeral(consumoP6).format('0,0.00');
                        consumoP7 = numeral(consumoP7).format('0,0.00');
                        consumoP8 = numeral(consumoP8).format('0,0.00');
                        consumoP9 = numeral(consumoP9).format('0,0.00');
                        consumoP10 = numeral(consumoP10).format('0,0.00');

                        merma_porcentual_P6 = numeral(merma_porcentual_P6).format('0,0.00');
                        merma_porcentual_P7 = numeral(merma_porcentual_P7).format('0,0.00');
                        merma_porcentual_P8 = numeral(merma_porcentual_P8).format('0,0.00');
                        merma_porcentual_P9 = numeral(merma_porcentual_P9).format('0,0.00');
                        merma_porcentual_P10 = numeral(merma_porcentual_P10).format('0,0.00');

                        LP_INICIAL_row_1_p6 = numeral(LP_INICIAL_row_1_p6).format('0,0.00');
                        LP_INICIAL_row_2_p7 = numeral(LP_INICIAL_row_2_p7).format('0,0.00');
                        LP_INICIAL_row_3_p8 = numeral(LP_INICIAL_row_3_p8).format('0,0.00');
                        LP_INICIAL_row_4_p9 = numeral(LP_INICIAL_row_4_p9).format('0,0.00');
                        LP_INICIAL_row_5_p10 = numeral(LP_INICIAL_row_5_p10).format('0,0.00');

                        LP_FINAL_row_1_p6 = numeral(LP_FINAL_row_1_p6).format('0,0.00');
                        LP_FINAL_row_2_p7 = numeral(LP_FINAL_row_2_p7).format('0,0.00');
                        LP_FINAL_row_3_p8 = numeral(LP_FINAL_row_3_p8).format('0,0.00');
                        LP_FINAL_row_4_p9 = numeral(LP_FINAL_row_4_p9).format('0,0.00');
                        LP_FINAL_row_5_p10 = numeral(LP_FINAL_row_5_p10).format('0,0.00');

                        MERMA_row_1_p6 = numeral(MERMA_row_1_p6).format('0,0.00');
                        MERMA_row_2_p7 = numeral(MERMA_row_2_p7).format('0,0.00');
                        MERMA_row_3_p8 = numeral(MERMA_row_3_p8).format('0,0.00');
                        MERMA_row_4_p9 = numeral(MERMA_row_4_p9).format('0,0.00');
                        MERMA_row_5_p10 = numeral(MERMA_row_5_p10).format('0,0.00');

                        rollos_esperados_P6 = numeral(rollos_esperados_P6).format('0,0.00');
                        bolsones_producir_P6 = numeral(bolsones_producir_P6).format('0,0.00');
                        No_bolsones_P6 = numeral(No_bolsones_P6).format('0,0.00');
                        diferencial_P6 = numeral(diferencial_P6).format('0,0.00');

                        rollos_esperados_P7 = numeral(rollos_esperados_P7).format('0,0.00');
                        bolsones_producir_P7 = numeral(bolsones_producir_P7).format('0,0.00');
                        No_bolsones_P7 = numeral(No_bolsones_P7).format('0,0.00');
                        diferencial_P7 = numeral(diferencial_P7).format('0,0.00');

                        rollos_esperados_P8 = numeral(rollos_esperados_P8).format('0,0.00');
                        bolsones_producir_P8 = numeral(bolsones_producir_P8).format('0,0.00');
                        No_bolsones_P8 = numeral(No_bolsones_P8).format('0,0.00');
                        diferencial_P8 = numeral(diferencial_P8).format('0,0.00');

                        EP_bolson_P8 = numeral(EP_bolson_P8).format('0,0.00');
                        EP_utilizado_P8 = numeral(EP_utilizado_P8).format('0,0.00');

                        rollos_esperados_P9 = numeral(rollos_esperados_P9).format('0,0.00');
                        bolsones_producir_P9 = numeral(bolsones_producir_P9).format('0,0.00');
                        No_bolsones_P9 = numeral(No_bolsones_P9).format('0,0.00');
                        diferencial_P9 = numeral(diferencial_P9).format('0,0.00');

                        EP_bolson_P9 = numeral(EP_bolson_P9).format('0,0.00');
                        EP_utilizado_P9 = numeral(EP_utilizado_P9).format('0,0.00');

                        rollos_esperados_P10 = numeral(rollos_esperados_P10).format('0,0.00');
                        bolsones_producir_P10 = numeral(bolsones_producir_P10).format('0,0.00');
                        No_bolsones_P10 = numeral(No_bolsones_P10).format('0,0.00');
                        diferencial_P10 = numeral(diferencial_P10).format('0,0.00');

                        EP_bolson_P10 = numeral(EP_bolson_P10).format('0,0.00');
                        EP_utilizado_P10 = numeral(EP_utilizado_P10).format('0,0.00');

                        faltante_P8 = numeral(faltante_P8).format('0,0.00');
                        sobrante_P8 = numeral(sobrante_P8).format('0,0.00');
                        faltante_P9 = numeral(faltante_P9).format('0,0.00');
                        Sobrante_P9 = numeral(Sobrante_P9).format('0,0.00');
                        faltante_P10 = numeral(faltante_P10).format('0,0.00');
                        Sobrante_P10 = numeral(Sobrante_P10).format('0,0.00');

                        faltante_P8 = (Math.sign(parseFloat(faltante_P8)) == '-1' ? faltante_P8.replace("-", "(") + ')' : faltante_P8);
                        faltante_P9 = (Math.sign(parseFloat(faltante_P9)) == '-1' ? faltante_P9.replace("-", "(") + ')' : faltante_P9);
                        faltante_P10 = (Math.sign(parseFloat(faltante_P10)) == '-1' ? faltante_P10.replace("-", "(") + ')' : faltante_P10);

                        sobrante_P8 = (Math.sign(parseFloat(sobrante_P8)) == '-1' ? sobrante_P8.replace("-", "(") + ')' : sobrante_P8);
                        Sobrante_P9 = (Math.sign(parseFloat(Sobrante_P9)) == '-1' ? Sobrante_P9.replace("-", "(") + ')' : Sobrante_P9);
                        Sobrante_P10 = (Math.sign(parseFloat(Sobrante_P10)) == '-1' ? Sobrante_P10.replace("-", "(") + ')' : Sobrante_P10);

                        diferencial_P6 = (Math.sign(parseFloat(diferencial_P6)) == '-1' ? diferencial_P6.replace("-", "(") + ')' : diferencial_P6);
                        diferencial_P7 = (Math.sign(parseFloat(diferencial_P7)) == '-1' ? diferencial_P7.replace("-", "(") + ')' : diferencial_P7);

                        data = [
                            ["ACTIVIDAD", "PAPIEL ECO. COG.27", "CHOLIN COG.52", "FOURPACK COG.100", "CHOLIN 6 PACK COG.103", "PAPEL VUENO COG.141"],
                            ["LP INICIAL ", LP_INICIAL_row_1_p6, LP_INICIAL_row_2_p7, LP_INICIAL_row_3_p8, LP_INICIAL_row_4_p9, LP_INICIAL_row_5_p10],
                            [arrayRequisas3],
                            ["LP FINAL ", LP_FINAL_row_1_p6, LP_FINAL_row_2_p7, LP_FINAL_row_3_p8, LP_FINAL_row_4_p9, LP_FINAL_row_5_p10],
                            ["MERMA (UND)", MERMA_row_1_p6, MERMA_row_2_p7, MERMA_row_3_p8, MERMA_row_4_p9, MERMA_row_5_p10],
                            ["MERMA (%)", merma_porcentual_P6, merma_porcentual_P7, merma_porcentual_P8, merma_porcentual_P9, merma_porcentual_P10],
                            ["CONSUMO ", consumoP6, consumoP7, consumoP8, consumoP9, consumoP10],
                            ["E/P - POR BOLSON", '0.00', '0.00', EP_bolson_P8, EP_bolson_P9, EP_bolson_P10],
                            ["E/P -UTILIZADO", '0.00', '0.00', EP_utilizado_P8, EP_utilizado_P9, EP_utilizado_P10],
                            ["ROLLOS ESPERADOS ", rollos_esperados_P6, rollos_esperados_P7, '-', '-', '-'],
                            ["BOLSONES A PRODUCIR ", bolsones_producir_P6, bolsones_producir_P7, '-', '-', '-'],
                            ["No. BOLSONES", No_bolsones_P6, No_bolsones_P7, No_bolsones_P8, No_bolsones_P9, No_bolsones_P10],
                            ["DIFERENCIAL", diferencial_P6, diferencial_P7, '-', '-', '-'],
                            ["FALTANTE", '-', '-', faltante_P8, faltante_P9, faltante_P10],
                            ["SOBRANTE", '-', '-', sobrante_P8, Sobrante_P9, Sobrante_P10],

                        ]

                        cityTable = makeTable(table, data, 3);
                    }

                }
            } else if (name === 'tblQuimicos') {
                /******************  @QUIMICOS  **********************/

                var quimico_01 = Object.keys(json['ITEM7']).map(key => {
                    return json['ITEM7'][key];
                })

                var quimico_02 = Object.keys(json['ITEM13']).map(key => {
                    return json['ITEM13'][key];
                })

                index_q101 = quimico_01.findIndex(x => x.ACTIVIDAD === "LP INICIAL");
                index_q102 = quimico_01.findIndex(x => x.ACTIVIDAD === "REQUISADO");
                index_q103 = quimico_01.findIndex(x => x.ACTIVIDAD === "MERMA");
                index_q104 = quimico_01.findIndex(x => x.ACTIVIDAD === "LP FINAL");

                index_q201 = quimico_02.findIndex(x => x.ACTIVIDAD === "LP INICIAL");
                index_q202 = quimico_02.findIndex(x => x.ACTIVIDAD === "REQUISADO");
                index_q203 = quimico_02.findIndex(x => x.ACTIVIDAD === "MERMA");
                index_q204 = quimico_02.findIndex(x => x.ACTIVIDAD === "LP FINAL");

                var LP_INICIAL_row_1_q1 = quimico_01[index_q101]['VALORES'];
                var REQUISADO_row_1_q1 = quimico_01[index_q102]['VALORES'];
                var MERMA_row_1_q1 = quimico_01[index_q103]['VALORES'];
                var LP_FINAL_row_1_q1 = quimico_01[index_q104]['VALORES'];

                var LP_INICIAL_row_2_q2 = quimico_02[index_q201]['VALORES'];
                var REQUISADO_row_2_q2 = quimico_02[index_q202]['VALORES'];
                var MERMA_row_2_q2 = quimico_02[index_q203]['VALORES'];
                var LP_FINAL_row_2_q2 = quimico_02[index_q204]['VALORES'];

                var REQUISADOS_Q1 = REQUISADO_row_1_q1.split(",");
                var REQUISADOS_Q2 = REQUISADO_row_2_q2.split(",");

                var totalRequisadoQ1 = 0;
                var totalRequisadoQ2 = 0;
                var arrayRequisasQ = [];

                //Añadir elementos si algun Q es mayor
                maxElement(REQUISADOS_Q1.length, REQUISADOS_Q2.length, REQUISADOS_Q2);
                maxElement(REQUISADOS_Q2.length, REQUISADOS_Q1.length, REQUISADOS_Q1);

                arrayRequisasQ[0] = {
                    row_1: REQUISADOS_Q1,
                    row_2: REQUISADOS_Q2,
                };

                arrayRequisasQ.forEach(element => {
                    for (var j = 0; j < element.row_1.length; j++) {
                        totalRequisadoQ1 += parseFloat(element.row_1[j]);
                        totalRequisadoQ2 += parseFloat(element.row_2[j]);

                    }
                });

                var consumoQ1 = parseFloat(LP_INICIAL_row_1_q1) + parseFloat(totalRequisadoQ1) - parseFloat(MERMA_row_1_q1) - parseFloat(LP_FINAL_row_1_q1);
                var consumoQ2 = parseFloat(LP_INICIAL_row_2_q2) + parseFloat(totalRequisadoQ2) - parseFloat(MERMA_row_2_q2) - parseFloat(LP_FINAL_row_2_q2);

                var merma_porcentual_Q1 = (parseFloat(MERMA_row_1_q1)) / (consumoQ1 + parseFloat(MERMA_row_1_q1)) * 100;
                var merma_porcentual_Q2 = (parseFloat(MERMA_row_2_q2)) / (consumoQ2 + parseFloat(MERMA_row_2_q2)) * 100;

                LP_INICIAL_row_1_q1 = numeral(LP_INICIAL_row_1_q1).format('0,0.00');
                LP_INICIAL_row_2_q2 = numeral(LP_INICIAL_row_2_q2).format('0,0.00');

                LP_FINAL_row_1_q1 = numeral(LP_FINAL_row_1_q1).format('0,0.00');
                LP_FINAL_row_2_q2 = numeral(LP_FINAL_row_2_q2).format('0,0.00');

                MERMA_row_1_q1 = numeral(MERMA_row_1_q1).format('0,0.00');
                MERMA_row_2_q2 = numeral(MERMA_row_2_q2).format('0,0.00');

                merma_porcentual_Q1 = numeral(merma_porcentual_Q1).format('0,0.00');
                merma_porcentual_Q2 = numeral(merma_porcentual_Q2).format('0,0.00');

                consumoQ1 = numeral(consumoQ1).format('0,0.00');
                consumoQ2 = numeral(consumoQ2).format('0,0.00');


                //¿COMO REALIZAN Y A QUE ITEM CORRESPONDE LO DEL PESO DEL GLN(KG)
                var data = [
                    ["ACTIVIDAD", "ACEITE (Gln)", "PAM"],
                    ["LP INICIAL ", LP_INICIAL_row_1_q1, LP_INICIAL_row_2_q2],
                    [arrayRequisasQ],
                    ["LP FINAL ", LP_FINAL_row_1_q1, LP_FINAL_row_2_q2],
                    ["MERMA", MERMA_row_1_q1, MERMA_row_2_q2],
                    ["MERMA (%)", merma_porcentual_Q1, merma_porcentual_Q2],
                    ["CONSUMO ", consumoQ1, consumoQ2],
                    ["PESO DEL GLN(KG)", '-', '-'],
                ]
                var cityTable = makeTable(table, data, 4);

            }
        })
    }

    function makeTable(container, data, tipo_requisa) {
        var row2, j = 0,
            requisas;
        var table = container;

        $.each(data, function(rowIndex, r) {
            var row = $("<tr/>");
            row2 = '';
            if (rowIndex != 2) {
                $.each(r, function(colIndex, c) {
                    if (rowIndex != 0) {
                        if (colIndex != 0) {
                            c == '0.00' ? row.append($("<td" + "/>").text('-')) : row.append($("<td" + "/>").text(c));
                        } else {
                            row.append($("<td" + "/>").text(c));
                        }
                    } else {
                        row.append($("<t" + (rowIndex == 0 ? "h" : "d") + "/>").text(c));
                    }
                });
            } else if (rowIndex === 2) { //requisados
                if (tipo_requisa == 1) { //JR + TUBOS KRAFT
                    //   table.append(`<thead><tr><th colspan="3" class="bg-gray text-white text-center"><h6>MATERIA PRIMA</h6></th></tr></thead>`);

                    $.each(r, function(index, item) {
                        item.forEach(element => {
                            for (j; j < element.row_1.length; j++) {
                                requisas += `<tr>` +
                                    `<td>` + (element.row_1[j] == '0.00' ? "-" : numeral(element.row_1[j]).format('0,0.00')) + `</td>` +
                                    `<td>` + (element.row_2[j] == '0.00' ? "-" : numeral(element.row_2[j]).format('0,0.00')) + `</td>`;
                            }
                        });
                    });
                    row2 += `<tr><td rowspan=` + (j + 1) + `>REQUISA</td></tr>`;
                    row2 += requisas;
                } else if (tipo_requisa === 2) { // SOBREEMPAQUE
                    //  table.append(`<thead><tr><th colspan="5" class="bg-gray text-white text-center"><h6>SOBREMPAQUE</h6></th></tr></thead>`);
                    $.each(r, function(index, item) {
                        item.forEach(element => {
                            for (j; j < element.row_1.length; j++) {
                                requisas += `<tr>` +
                                    `<td>` + (element.row_1[j] == '0.00' ? "-" : numeral(element.row_1[j]).format('0,0.00')) + `</td>` +
                                    `<td>` + (element.row_2[j] == '0.00' ? "-" : numeral(element.row_2[j]).format('0,0.00')) + `</td>` + `</td>` +
                                    `<td>` + (element.row_3[j] == '0.00' ? "-" : numeral(element.row_3[j]).format('0,0.00')) + `</td>` + `</td>` +
                                    `<td>` + numeral(parseFloat(element.row_1[j]) + parseFloat(element.row_2[j]) + parseFloat(element.row_3[j])).format('0,0.00') + `</td>` + `</td>
                                      </tr>`;
                            }
                        });
                    });
                    row2 += `<tr><td rowspan=` + (j + 1) + `>REQUISA</td></tr>`;
                    row2 += requisas;

                } else if (tipo_requisa === 3) { // EMPAQUE PRIMARIO
                    // table.append(`<thead><tr><th colspan="6" class="bg-gray text-white text-center"><h6>EMPAQUE PRIMARIO</h6></th></tr></thead>`);
                    $.each(r, function(index, item) {
                        item.forEach(element => {
                            for (j; j < element.row_1.length; j++) {
                                requisas += `<tr>` +
                                    `<td>` + (element.row_1[j] == '0.00' ? "-" : numeral(element.row_1[j]).format('0,0.00')) + `</td>` +
                                    `<td>` + (element.row_2[j] == '0.00' ? "-" : numeral(element.row_2[j]).format('0,0.00')) + `</td>` + `</td>` +
                                    `<td>` + (element.row_3[j] == '0.00' ? "-" : numeral(element.row_3[j]).format('0,0.00')) + `</td>` + `</td>` +
                                    `<td>` + (element.row_4[j] == '0.00' ? "-" : numeral(element.row_4[j]).format('0,0.00')) + `</td>` + `</td> ` +
                                    `<td>` + (element.row_5[j] == '0.00' ? "-" : numeral(element.row_5[j]).format('0,0.00')) + `</td>` + `</td> +
                                      </tr>`;
                            }
                        });
                    });
                    row2 += `<tr><td rowspan=` + (j + 1) + `>REQUISA</td></tr>`;
                    row2 += requisas;
                } else if (tipo_requisa === 4) { //  QUIMICOS
                    // table.append(`<thead><tr><th colspan="5" class="bg-gray text-white text-center"><h6>QUIMICOS</h6></th></tr></thead>`);
                    $.each(r, function(index, item) {
                        item.forEach(element => {
                            for (j; j < element.row_1.length; j++) {
                                requisas += `<tr>` +
                                    `<td>` + (element.row_1[j] == '0.00' ? "-" : numeral(element.row_1[j]).format('0,0.00')) + `</td>` +
                                    `<td>` + (element.row_2[j] == '0.00' ? "-" : numeral(element.row_2[j]).format('0,0.00')) + `</td>` + `</td>
                                 </tr>`;
                            }
                        });
                    });
                    row2 += `<tr><td rowspan=` + (j + 1) + `>REQUISA</td></tr>`;
                    row2 += requisas;
                }
            }
            table.append(row);
            table.append(row2);
            // table.find('thead th').addClass('bg-blue');
            table.find('tr:nth-child(1)').addClass('bg-blue text-light');
        });
        return container.append(table);
    }
</script>