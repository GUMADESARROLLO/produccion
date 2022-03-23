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

                        break;
                    case 'dtaMateria':
                        let table_materia = $('#tblMateriaPrima').DataTable({
                            "data": item['data'],
                            "destroy": true,
                            "info": false,
                            "bPaginate": false,
                            "order": [[ 7, "asc" ]],
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
                            "order": [[ 5, "asc" ]],
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
    
    function detalles_tiempos_paros(){
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

            var producto_01 = Object.keys(json['ITEM1']).map(key => {
                return json['ITEM1'][key];
            })

            var producto_02 = Object.keys(json['ITEM2']).map(key => {
                return json['ITEM2'][key];
            })
            
            index_01 = producto_01.findIndex(x => x.ACTIVIDAD ==="LP INICIAL");
            index_03 = producto_01.findIndex(x => x.ACTIVIDAD ==="MERMA");
            index_04 = producto_01.findIndex(x => x.ACTIVIDAD ==="LP FINAL");
            

            var LP_INICIAL_row_1 = producto_01[index_01]['VALORES'];
            var MERMA_row_1 = producto_01[index_03]['VALORES'];
            var LP_FINAL_row_1 = producto_01[index_04]['VALORES'];

            index_02 = producto_02.findIndex(x => x.ACTIVIDAD ==="LP INICIAL");
            index_05 = producto_02.findIndex(x => x.ACTIVIDAD ==="MERMA");
            index_06 = producto_02.findIndex(x => x.ACTIVIDAD ==="LP FINAL");

            var LP_INICIAL_row_2 = producto_02[index_02]['VALORES'];
            var MERMA_row_2 = producto_02[index_05]['VALORES'];
            var LP_FINAL_row_2 = producto_02[index_06]['VALORES'];

            var data = [
                ["ACTIVIDAD", "JUMBO ROLL", "TUBOS KRAFT"],
                ["LP INICIAL ", LP_INICIAL_row_1, LP_INICIAL_row_2],                
                ["LP FINAL ", LP_FINAL_row_1, LP_FINAL_row_2],
                ["MERMA ", MERMA_row_1, MERMA_row_2]]

            var cityTable = makeTable($("#id_tbl_temp"), data);

        })
        
    })
    function makeTable(container, data) {
        var table = $("<table/>").addClass('table table-hover');
        $.each(data, function(rowIndex, r) {
            var row = $("<tr/>");
            $.each(r, function(colIndex, c) { 
                row.append($("<t"+(rowIndex == 0 ?  "h" : "d")+"/>").text(c));
            });
            table.append(row);
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
</script>