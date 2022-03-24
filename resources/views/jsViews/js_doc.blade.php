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
    $('#id_temp').on('click', function() {
        $('#mdlDetallesOrdes').modal('show');
        $.getJSON("../datos_detalles/" + id_orden, function(json) {

            /******************  @JR AND @TUBOS_KRAFT  **********************/

            var producto_01 = Object.keys(json['ITEM1']).map(key => {
                return json['ITEM1'][key];
            })

            var producto_02 = Object.keys(json['ITEM2']).map(key => {
                return json['ITEM2'][key];
            })

            index_01 = producto_01.findIndex(x => x.ACTIVIDAD === "LP INICIAL");
            index_03 = producto_01.findIndex(x => x.ACTIVIDAD === "MERMA");
            index_04 = producto_01.findIndex(x => x.ACTIVIDAD === "LP FINAL");
            index_07 = producto_01.findIndex(x => x.ACTIVIDAD === "REQUISADO");

            var LP_INICIAL_row_1 = producto_01[index_01]['VALORES'];
            var MERMA_row_1 = producto_01[index_03]['VALORES'];
            var LP_FINAL_row_1 = producto_01[index_04]['VALORES'];
            var REQUISADO_row_1 = producto_01[index_07]['VALORES'];


            index_02 = producto_02.findIndex(x => x.ACTIVIDAD === "LP INICIAL");
            index_05 = producto_02.findIndex(x => x.ACTIVIDAD === "MERMA");
            index_06 = producto_02.findIndex(x => x.ACTIVIDAD === "LP FINAL");
            index_08 = producto_02.findIndex(x => x.ACTIVIDAD === "REQUISADO");


            var LP_INICIAL_row_2 = producto_02[index_02]['VALORES'];
            var MERMA_row_2 = producto_02[index_05]['VALORES'];
            var LP_FINAL_row_2 = producto_02[index_06]['VALORES'];
            var REQUISADO_row_2 = producto_02[index_08]['VALORES'];

            var REQUISADOS_P1 = REQUISADO_row_1.split(",");
            var REQUISADOS_P2 = REQUISADO_row_2.split(",");

            arrayRequisas = [];
            var totalRequisado1 = 0;
            var totalRequisado2 = 0;

            //console.log(REQUISADOS_P1.length);
            //console.log(REQUISADOS_P2.length);

            var fila = '';
            var i = 0;
            if (REQUISADOS_P1.length > REQUISADOS_P2.length) {
                $.each(REQUISADOS_P1, function(rowIndex1, r1) { //8
                    $.each(REQUISADOS_P2, function(rowIndex2, r2) { //8*6 = 48/6
                        if (rowIndex1 == rowIndex2) {
                            arrayRequisas[i] = {
                                row: r1 + ',' + r2
                            }
                            i++;
                            totalRequisado2 += parseFloat(r2);

                        }
                    });
                    if (rowIndex1 >= REQUISADOS_P2.length) {
                        arrayRequisas[rowIndex1] = {
                            row: r1 + ',' + 0
                        }
                    }
                    totalRequisado1 += parseFloat(r1);
                });
            } else if (REQUISADOS_P1.length < REQUISADOS_P2.length) {
                $.each(REQUISADOS_P2, function(rowIndex1, r1) {
                    $.each(REQUISADOS_P1, function(rowIndex2, r2) {
                        if (rowIndex2 == rowIndex1) {
                            arrayRequisas[i] = {
                                row: r2 + ',' + r1
                            }
                            i++;
                            totalRequisado1 += parseFloat(r2);
                        }
                    });
                    if (rowIndex1 >= REQUISADOS_P1.length) {
                        arrayRequisas[rowIndex1] = {
                            row: 0 + ',' + r1
                        }
                    }
                    totalRequisado2 += parseFloat(r1);
                });
            } else {
                $.each(REQUISADOS_P1, function(rowIndex1, r1) { //8
                    $.each(REQUISADOS_P2, function(rowIndex2, r2) { //8*6 = 48
                        if (rowIndex1 == rowIndex2) {
                            arrayRequisas[i] = {
                                row: r1 + ',' + r2
                            }
                            i++;
                            totalRequisado2 += parseFloat(r2);
                        }
                    });
                    totalRequisado1 += parseFloat(r1);

                });
            }

            var consumoP1 = parseFloat(LP_INICIAL_row_1) + parseFloat(totalRequisado1) - parseFloat(MERMA_row_1) - parseFloat(LP_FINAL_row_1);
            var merma_porcentual_P1 = parseFloat(MERMA_row_1) / (consumoP1 + parseFloat(MERMA_row_1)) * 100;
            var peso = $('#id_peso_porcent').text();
            var consumoP2 = parseFloat(LP_INICIAL_row_2) + parseFloat(totalRequisado2) - parseFloat(LP_FINAL_row_2);
            var merma_porcentual_P2 = (parseFloat(MERMA_row_2)) / (consumoP2 + parseFloat(MERMA_row_2)) * 100;
            var merma_kg = parseFloat(MERMA_row_2) * 0.20;

            LP_INICIAL_row_1 = numeral(LP_INICIAL_row_1).format('0,0.00');
            LP_INICIAL_row_2 = numeral(LP_INICIAL_row_2).format('0,0.00');
            LP_FINAL_row_1 = numeral(LP_FINAL_row_1).format('0,0.00');
            LP_FINAL_row_2 = numeral(LP_FINAL_row_2).format('0,0.00');
            MERMA_row_1 = numeral(MERMA_row_1).format('0,0.00');
            MERMA_row_2 = numeral(MERMA_row_2).format('0,0.00');
            merma_kg = numeral(merma_kg).format('0,0.00');
            merma_porcentual_P1 = numeral(merma_porcentual_P1).format('0,0.00');
            merma_porcentual_P2 = numeral(merma_porcentual_P2).format('0,0.00');
            consumoP1 = numeral(consumoP1).format('0,0.00');
            consumoP2 = numeral(consumoP2).format('0,0.00');

            var data = [
                ["ACTIVIDAD", "JUMBO ROLL", "TUBOS KRAFT"],
                ["LP INICIAL ", LP_INICIAL_row_1, LP_INICIAL_row_2],
                [arrayRequisas],
                ["LP FINAL ", LP_FINAL_row_1, LP_FINAL_row_2],
                ["MERMA (KG)", MERMA_row_1, merma_kg],
                ["MERMA (UND) ", '0.00', MERMA_row_2],
                ["MERMA (%)", merma_porcentual_P1, merma_porcentual_P2],
                ["CONSUMO ", consumoP1, consumoP2],
                ["PESO ", peso, '0.00'],
            ]

            $("#id_tbl_temp").empty();
            var cityTable = makeTable($("#id_tbl_temp"), data, 1);
            // $("#id_tbl_temp > table > tr > th").addClass("bg-primary text-white");

            /******************  @SOBREEMPAQUE  **********************/


            var producto_03 = Object.keys(json['ITEM3']).map(key => {
                return json['ITEM3'][key];
            })

            var producto_04 = Object.keys(json['ITEM8']).map(key => {
                return json['ITEM8'][key];
            })

            var producto_05 = Object.keys(json['ITEM8']).map(key => {
                return json['ITEM8'][key];
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

            var indexMax, indexOut1, indexOut2;
            var P3_R_lenght = REQUISADOS_P3.length;
            var P4_R_lenght = REQUISADOS_P4.length;
            var P5_R_lenght = REQUISADOS_P5.length;

            if (P3_R_lenght > P4_R_lenght && P3_R_lenght > P5_R_lenght) {
                indexMax = P3_R_lenght; //4
                indexOut1 = indexMax - P4_R_lenght; //1
                indexOut2 = indexMax - P5_R_lenght; //1
                addElement(indexOut1, REQUISADOS_P4);
                addElement(indexOut2, REQUISADOS_P5);
                /*for (var i = 1; i <= indexOut1; i++) {REQUISADOS_P4.push('0.00');}
                for (var i = 1; i <= indexOut2; i++) {REQUISADOS_P5.push('0.00');}*/
            } else if (P4_R_lenght > P3_R_lenght && P4_R_lenght > P5_R_lenght) {
                indexMax = P4_R_lenght; //4
                indexOut1 = indexMax - P3_R_lenght;
                indexOut2 = indexMax - P5_R_lenght;
                addElement(indexOut1, REQUISADOS_P3);
                addElement(indexOut2, REQUISADOS_P5);

            } else if (P5_R_lenght > P3_R_lenght && P5_R_lenght > P4_R_lenght) {
                indexMax = P5_R_lenght; //4
                indexOut1 = indexMax - P3_R_lenght;
                indexOut2 = indexMax - P4_R_lenght;
                addElement(indexOut1, REQUISADOS_P3);
                addElement(indexOut2, REQUISADOS_P4);
            } else {}

            arrayRequisas2[0] = {
                row_1: REQUISADOS_P3,
                row_2: REQUISADOS_P4,
                row_3: REQUISADOS_P5
            }

            console.log(arrayRequisas2);
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

            var consumoP3 = parseFloat(LP_INICIAL_row_1_p3) + totalRequisadoP3 - parseFloat(MERMA_row_1_p3) - parseFloat(LP_FINAL_row_1_p3);
            var consumoP4 = parseFloat(LP_INICIAL_row_2_p4) + totalRequisadoP4 - parseFloat(MERMA_row_2_p4) - parseFloat(LP_FINAL_row_2_p4);
            var consumoP5 = parseFloat(LP_INICIAL_row_3_p5) + totalRequisadoP5 - parseFloat(MERMA_row_3_p5) - parseFloat(LP_FINAL_row_3_p5);

            consumoP3 = numeral(consumoP3).format('0,0.00');
            consumoP4 = numeral(consumoP4).format('0,0.00');
            consumoP5 = numeral(consumoP5).format('0,0.00');

            var merma_porcentual_P3 = parseFloat(MERMA_row_1_p3) / (consumoP3 + parseFloat(MERMA_row_1_p3)) * 100;
            var merma_porcentual_P4 = parseFloat(MERMA_row_2_p4) / (consumoP4 + parseFloat(MERMA_row_2_p4)) * 100;
            var merma_porcentual_P5 = parseFloat(MERMA_row_3_p5) / (consumoP5 + parseFloat(MERMA_row_3_p5)) * 100;

            merma_porcentual_P3 = numeral(merma_porcentual_P3).format('0,0.00');
            merma_porcentual_P4 = numeral(merma_porcentual_P4).format('0,0.00');
            merma_porcentual_P5 = numeral(merma_porcentual_P5).format('0,0.00');

            var consumoTotal_SE = consumoP3 + consumoP4 + consumoP5;
            var merma_porcentual_total = merma_porcentual_P3 + merma_porcentual_P4 + merma_porcentual_P5;
            var merma_total = parseFloat(MERMA_row_1_p3) + parseFloat(MERMA_row_2_p4) + parseFloat(MERMA_row_3_p5);
            var lp_final_total = parseFloat(LP_FINAL_row_1_p3) + parseFloat(LP_FINAL_row_2_p4) + parseFloat(LP_FINAL_row_3_p5);
            var lp_inicial_total = parseFloat(LP_INICIAL_row_1_p3) + parseFloat(LP_INICIAL_row_2_p4) + parseFloat(LP_INICIAL_row_3_p5);

            consumoTotal_SE = numeral(consumoTotal_SE).format('0,0.00');
            merma_porcentual_total = numeral(merma_porcentual_total).format('0,0.00')
            merma_total = numeral(merma_total).format('0,0.00');
            lp_final_total = numeral(lp_final_total).format('0,0.00');
            lp_inicial_total = numeral(lp_inicial_total).format('0,0.00');

            LP_INICIAL_row_1_p3 = numeral(LP_INICIAL_row_1_p3).format('0,0.00');
            LP_INICIAL_row_2_p4 = numeral(LP_INICIAL_row_2_p4).format('0,0.00');
            LP_INICIAL_row_3_p5 = numeral(LP_INICIAL_row_3_p5).format('0,0.00');

            LP_FINAL_row_1_p3 = numeral(LP_INICIAL_row_1_p3).format('0,0.00');
            LP_FINAL_row_2_p4 = numeral(LP_FINAL_row_2_p4).format('0,0.00');
            LP_FINAL_row_3_p5 = numeral(LP_FINAL_row_3_p5).format('0,0.00');

            MERMA_row_1_p3 = numeral(MERMA_row_1_p3).format('0,0.00');
            MERMA_row_2_p4 = numeral(MERMA_row_2_p4).format('0,0.00');
            MERMA_row_3_p5 = numeral(MERMA_row_3_p5).format('0,0.00');

            data = [
                ["ACTIVIDAD", "COG. 114", "COG. 67 ", "COG.92", "TOTAL BOLSAS"],
                ["LP INICIAL ", LP_INICIAL_row_1_p3, LP_INICIAL_row_2_p4, LP_INICIAL_row_3_p5, lp_inicial_total],
                [arrayRequisas2],
                ["LP FINAL ", LP_FINAL_row_1_p3, LP_FINAL_row_2_p4, LP_FINAL_row_3_p5, lp_final_total],
                ["MERMA (UND)", MERMA_row_1_p3, MERMA_row_2_p4, MERMA_row_3_p5, merma_total],
                ["MERMA (%)", merma_porcentual_P3, merma_porcentual_P4, merma_porcentual_P5, merma_porcentual_total],
                ["CONSUMO ", consumoP3, consumoP4, consumoP5, consumoTotal_SE],
            ]

            // $("#id_tbl_temp").empty();
            cityTable = makeTable($("#id_tbl_temp"), data, 2);
            //$("#id_tbl_temp > table > tr > th").addClass("bg-primary text-white");

            /******************  @EMPAQUE_PRIMARIO  **********************/

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

            var REQUISADOS_P6 = REQUISADO_row_1_p6.split(",");
            var REQUISADOS_P7 = REQUISADO_row_2_p7.split(",");
            var REQUISADOS_P8 = REQUISADO_row_3_p8.split(",");
            var REQUISADOS_P9 = REQUISADO_row_4_p9.split(",");

            var arrayRequisas3 = [];

            var indexMax, indexOut1, indexOut2, indexOut3;
            var P6_R_lenght = REQUISADOS_P6.length;
            var P7_R_lenght = REQUISADOS_P7.length;
            var P8_R_lenght = REQUISADOS_P8.length;
            var P9_R_lenght = REQUISADOS_P9.length;

            if (P6_R_lenght > P7_R_lenght && P6_R_lenght > P8_R_lenght && P6_R_lenght > P9_R_lenght) {
                indexMax = P6_R_lenght;
                indexOut1 = indexMax - P7_R_lenght;
                indexOut2 = indexMax - P8_R_lenght;
                indexOut3 = indexMax - P9_R_lenght;

                addElement(indexOut1, REQUISADOS_P7);
                addElement(indexOut2, REQUISADOS_P8);
                addElement(indexOut3, REQUISADOS_P9);

            } else if (P7_R_lenght > P6_R_lenght && P7_R_lenght > P8_R_lenght && P7_R_lenght > P9_R_lenght) {

                indexMax = P7_R_lenght;
                indexOut1 = indexMax - P6_R_lenght;
                indexOut2 = indexMax - P8_R_lenght;
                indexOut3 = indexMax - P9_R_lenght;

                addElement(indexOut1, REQUISADOS_P6);
                addElement(indexOut2, REQUISADOS_P8);
                addElement(indexOut3, REQUISADOS_P9);

            } else if (P8_R_lenght > P6_R_lenght && P8_R_lenght > P7_R_lenght && P8_R_lenght > P9_R_lenght) {
                indexMax = P8_R_lenght;
                indexOut1 = indexMax - P6_R_lenght;
                indexOut2 = indexMax - P7_R_lenght;
                indexOut3 = indexMax - P9_R_lenght;

                addElement(indexOut1, REQUISADOS_P6);
                addElement(indexOut2, REQUISADOS_P7);
                addElement(indexOut3, REQUISADOS_P9);

            } else if (P9_R_lenght > P6_R_lenght && P9_R_lenght > P7_R_lenght && P9_R_lenght > P8_R_lenght) {

                indexMax = P9_R_lenght;
                indexOut1 = indexMax - P6_R_lenght;
                indexOut2 = indexMax - P7_R_lenght;
                indexOut3 = indexMax - P8_R_lenght;

                addElement(indexOut1, REQUISADOS_P6);
                addElement(indexOut2, REQUISADOS_P7);
                addElement(indexOut3, REQUISADOS_P8);
            }

            arrayRequisas3[0] = {
                row_1: REQUISADOS_P6,
                row_2: REQUISADOS_P7,
                row_3: REQUISADOS_P8,
                row_4: REQUISADOS_P9

            }
            console.log('/**********************@EMPAQUE PRIMARIO ****************************/')
            console.log(arrayRequisas3);
            var totalRequisadoP6 = 0,
                totalRequisadoP7 = 0,
                totalRequisadoP8 = 0,
                totalRequisadoP9 = 0;

            arrayRequisas3.forEach(element => {
                for (var j = 0; j < element.row_1.length; j++) {
                    totalRequisadoP6 += parseFloat(element.row_1[j]);
                    totalRequisadoP7 += parseFloat(element.row_2[j]);
                    totalRequisadoP8 += parseFloat(element.row_3[j]);
                    totalRequisadoP9 += parseFloat(element.row_4[j]);

                    // console.log('Cantidades= ' + element.row_1[j] + ' ' + element.row_2[j] + ' ' + element.row_3[j]);
                }
            });

            var consumoP6 = parseFloat(LP_INICIAL_row_1_p6) + totalRequisadoP6 - parseFloat(LP_FINAL_row_1_p6);
            var consumoP7 = parseFloat(LP_INICIAL_row_2_p7) + totalRequisadoP7 - parseFloat(LP_FINAL_row_2_p7);
            var consumoP8 = parseFloat(LP_INICIAL_row_3_p8) + totalRequisadoP8 - parseFloat(LP_FINAL_row_3_p8);
            var consumoP9 = parseFloat(LP_INICIAL_row_4_p9) + totalRequisadoP9 - parseFloat(LP_FINAL_row_4_p9);

            console.log(totalRequisadoP9);


            var merma_porcentual_P6 = parseFloat(MERMA_row_1_p6) / (consumoP6 + parseFloat(MERMA_row_1_p6)) * 100;
            var merma_porcentual_P7 = parseFloat(MERMA_row_2_p7) / (consumoP7 + parseFloat(MERMA_row_2_p7)) * 100;
            var merma_porcentual_P8 = parseFloat(MERMA_row_3_p8) / (consumoP8 + parseFloat(MERMA_row_3_p8)) * 100;
            var merma_porcentual_P9 = parseFloat(MERMA_row_4_p9) / (consumoP9 + parseFloat(MERMA_row_4_p9)) * 100;

            consumoP6 = numeral(consumoP6).format('0,0.00');
            consumoP7 = numeral(consumoP7).format('0,0.00');
            consumoP8 = numeral(consumoP8).format('0,0.00');
            consumoP9 = numeral(consumoP9).format('0,0.00');

            merma_porcentual_P6 = numeral(merma_porcentual_P6).format('0,0.00');
            merma_porcentual_P7 = numeral(merma_porcentual_P7).format('0,0.00');
            merma_porcentual_P8 = numeral(merma_porcentual_P8).format('0,0.00');
            merma_porcentual_P9 = numeral(merma_porcentual_P9).format('0,0.00');

            LP_INICIAL_row_1_p6 = numeral(LP_INICIAL_row_1_p6).format('0,0.00');
            LP_INICIAL_row_2_p7 = numeral(LP_INICIAL_row_2_p7).format('0,0.00');
            LP_INICIAL_row_3_p8 = numeral(LP_INICIAL_row_3_p8).format('0,0.00');
            LP_INICIAL_row_4_p9 = numeral(LP_INICIAL_row_4_p9).format('0,0.00');


            LP_FINAL_row_1_p6 = numeral(LP_FINAL_row_1_p6).format('0,0.00');
            LP_FINAL_row_2_p7 = numeral(LP_FINAL_row_2_p7).format('0,0.00');
            LP_FINAL_row_3_p8 = numeral(LP_FINAL_row_3_p8).format('0,0.00');
            LP_FINAL_row_4_p9 = numeral(LP_FINAL_row_4_p9).format('0,0.00');


            MERMA_row_1_p6 = numeral(MERMA_row_1_p6).format('0,0.00');
            MERMA_row_2_p7 = numeral(MERMA_row_2_p7).format('0,0.00');
            MERMA_row_3_p8 = numeral(MERMA_row_3_p8).format('0,0.00');
            MERMA_row_4_p9 = numeral(MERMA_row_4_p9).format('0,0.00');


            data = [
                ["ACTIVIDAD", "PAPIEL ECO. COG.27", "CHOLIN COG.52", "FOURPACK COG.100", "CHOLIN 6 PACK COG.103"],
                ["LP INICIAL ", LP_INICIAL_row_1_p6, LP_INICIAL_row_2_p7, LP_INICIAL_row_3_p8, LP_INICIAL_row_4_p9],
                [arrayRequisas3],
                ["LP FINAL ", LP_FINAL_row_1_p6, LP_FINAL_row_2_p7, LP_FINAL_row_3_p8, LP_FINAL_row_4_p9],
                ["MERMA (UND)", MERMA_row_1_p6, MERMA_row_2_p7, MERMA_row_3_p8, MERMA_row_4_p9],
                ["MERMA (%)", merma_porcentual_P6, merma_porcentual_P7, merma_porcentual_P8, merma_porcentual_P9],
                ["CONSUMO ", consumoP6, consumoP7, consumoP8, consumoP9],
            ]
            
            cityTable = makeTable($("#id_tbl_temp"), data, 3);
            $("#id_tbl_temp > table > tr > th").addClass("bg-primary text-white");
        })
    })

    function makeTable(container, data, typeItem) {
        var row2
        var table = $("<table/>").addClass('table table-hover');
        $.each(data, function(rowIndex, r) {
            var row = $("<tr/>");
            row2 = '';
            if (rowIndex != 2) {
                $.each(r, function(colIndex, c) {
                    row.append($("<t" + (rowIndex == 0 ? "h" : "d") + "/>").text(c));
                });
            } else if (rowIndex === 2) { //requisados
                if (typeItem == 1) { //JR + TUBOS KRAFT
                    $.each(r, function(index, item) {
                        item.forEach(element => {
                            requisa = element.row.split(',');
                            // console.log('REQUISA ' + requisa[0] + requisa[1]);
                            row2 += `<tr>
                                <td> REQUISA</td> ` +
                                `<td>` + numeral(parseFloat(requisa[0])).format('0,0.00') + `</td>` +
                                `<td>` + numeral(requisa[1]).format('0,0.00') + `</td>` + `</td>
                                </tr>`;
                        });
                    });
                } else if (typeItem === 2) { // SOBREEMPAQUE
                    $.each(r, function(index, item) {
                        item.forEach(element => {
                            console.log(r);
                            for (var j = 0; j < element.row_1.length; j++) {
                                row2 += `<tr>
                                  <td> REQUISA</td> ` +
                                    `<td>` + numeral(parseFloat(element.row_1[j])).format('0,0.00') + `</td>` +
                                    `<td>` + numeral(element.row_2[j]).format('0,0.00') + `</td>` + `</td>` +
                                    `<td>` + numeral(element.row_3[j]).format('0,0.00') + `</td>` + `</td>` +
                                    `<td>` + numeral(parseFloat(element.row_1[j]) + parseFloat(element.row_2[j]) + parseFloat(element.row_3[j])).format('0,0.00') + `</td>` + `</td>
                                      </tr>`;
                            }
                        });
                    });
                }else if (typeItem === 3) { // EMPAQUE PRIMARIO
                    $.each(r, function(index, item) {
                        item.forEach(element => {
                            console.log(r);
                            for (var j = 0; j < element.row_1.length; j++) {
                                row2 += `<tr>
                                  <td> REQUISA</td> ` +
                                    `<td>` + numeral(parseFloat(element.row_1[j])).format('0,0.00') + `</td>` +
                                    `<td>` + numeral(element.row_2[j]).format('0,0.00') + `</td>` + `</td>` +
                                    `<td>` + numeral(element.row_3[j]).format('0,0.00') + `</td>` + `</td>` +
                                    `<td>` + numeral(element.row_4[j]).format('0,0.00') + `</td>` + `</td>
                                      </tr>`;
                            }
                        });
                    });
                }
            }
            //row.append(row2);
            table.append(row);
            table.append(row2);
            //   table.append(row2);
            //    console.log(row2);

        });
        return container.append(table);
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

    function addElement(index, array) {
        for (var i = 1; i <= index; i++) {
            array.push('0.00');
        }
    }
</script>