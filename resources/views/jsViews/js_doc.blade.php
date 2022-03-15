<script type="text/javascript">
    var dtConversion;

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

                        break;
                    case 'dtaMateria':
                        let table_materia = $('#tblMateriaPrima').DataTable({
                            "data": item['data'],
                            "destroy": true,
                            "info": false,
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
                                        return '<span class="text-success"><sup>+</sup></span>' + data

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
                                    "title": "PESO %",
                                    "data": "PERSO_PORCENT"
                                },
                                {
                                    "title": "MERMA",
                                    "data": "MERMA"
                                },
                                {
                                    "title": "MERMA %",
                                    "data": "MERMA_PORCENT"
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
                                    "targets": []
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

                            /*var data = table_materia.row( this ).data();
                            clearFields();
                            
                            
                            $("#id_articulo").html("- [ " + data.ARTICULO + " ]");
                            $("#id_articulo_descripcion").text(data.DESCRIPCION_CORTA);*/

                            mostrarReq();

                            var data = table_materia.row(this).data();
                            let id_articulo = data['ID_ARTICULO'];
                            let articulo = data['ARTICULO'];
                            let descripcion = data['DESCRIPCION_CORTA'];

                            $('#nombre_mp').text(descripcion);
                            $('#codigo').text(articulo);


                            $("#id_articulo").html("- [ " + data.ARTICULO + " ]");
                            $("#id_articulo_descripcion").text(data.DESCRIPCION_CORTA);
                            let numOrden = $('#id_num_orden').val();
                            console.log(data);
                            //  clearFields();
                            $('#mdlAddOrden').modal('show');

                            var num_orden = $('#id_num_orden').text();
                            var elemento = document.getElementById("id_elemento").value = id_articulo;


                            $('#mdlMatPrima').modal('show');
                            $('#cantidad').val('');
                            getRequisadoMPBynumOrden(num_orden, id_articulo);

                            $('#tbJR tbody').on('click', "tr", function(event) {

                                //console.log($(this).children().next().attr('id'));

                                let tipo_requisa = $(this).children().next().attr('id');
                                let cantidad = $(this).children().next().text();
                                let nombre = '';

                                if (tipo_requisa == 1) {
                                    nombre = 'LP INICIAL';
                                } else if (tipo_requisa == 2) {
                                    nombre = 'REQUISADO';
                                } else if (tipo_requisa == 3) {
                                    nombre = 'LP FINAL';
                                } else if (tipo_requisa == 4) {
                                    nombre = 'MERMA';
                                }
                                $('#mdlAddOrden').modal('hide');

                                Swal.fire({
                                    title: nombre,
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
                                                url: "../requisado_jr",
                                                data: {
                                                    cantidad: value,
                                                    num_orden: numOrden,
                                                    id_articulo: id_articulo,
                                                    tipo: tipo_requisa,
                                                },
                                                type: 'post',
                                                async: true,
                                                success: function(response) {
                                                    console.log(response);
                                                    swal("Saved!", "Guardado exitosamente", "success");
                                                },
                                                error: function(response) {
                                                    swal("Oops", "No se ha podido guardar!", "error");
                                                }
                                            }).done(function(data) {
                                                setTimeout(function() {
                                                    location.reload();
                                                }, 2000);
                                                $('#mdlAddOrden').modal('show');

                                            });
                                        }
                                        $('#mdlAddOrden').modal('show');

                                    }
                                })

                            });


                            //soloNumeros(event.keyCode, event, $(this).val());

                        });
                        break;
                    case 'dtaProducto':
                        let table_producto = $('#tblProductos').DataTable({
                            "data": item['data'],
                            "destroy": true,
                            "info": false,
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
                                        return '<span class="text-success"><sup>+</sup></span>' + data

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
                                    "targets": []
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
                                text: "Ingrese la cantidad de Bultos",
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
                                                swal("Saved!", "Guardado exitosamente", "success");
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
                        $('#tblTiemposParos').DataTable({
                            "data": item['data'],
                            "destroy": true,
                            "info": false,
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
                                    "title": "DESCRIPCION DE LA ACTIVIDAD",
                                    "data": "DESCRIPCION_CORTA",
                                    "render": function(data, type, row, meta) {
                                        return '<span class="text-success"><sup>+</sup></span>' + data

                                    }
                                },
                                {
                                    "title": "DIA",
                                    "data": "BULTO"
                                },
                                {
                                    "title": "NOCHE",
                                    "data": "BULTO"
                                },
                                {
                                    "title": "TOTAL HRS",
                                    "data": "KG"
                                },
                                {
                                    "title": "No. Personas",
                                    "data": "KG"
                                },

                            ],
                            "columnDefs": [{
                                    "className": "dt-center",
                                    "targets": []
                                },
                                {
                                    "className": "dt-right",
                                    "targets": []
                                },
                                {
                                    "visible": false,
                                    "searchable": false,
                                    "targets": []
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
    $('#btnSave').on('click', function() {
        let numOrden = $('#id_num_orden').text(),
            tipo = $('#requisadoE').val(),
            cantidad = $('#cantidad').val(),
            id_elemento = $('#id_elemento').val();
        console.log(numOrden);
        $.ajax({
            url: "../guardarMatP",
            data: {
                num_orden: numOrden,
                tipo: tipo,
                cantidad: cantidad,
                id_elemento: id_elemento
            },
            type: 'post',
            async: true,
            success: function(response) {
                if (response == 1) {
                    mensaje('Orden duplicada, por favor verifique el N°. Orden', 'warning');
                } else {
                    mensaje(response.responseText, 'success');
                    $('#mdlMatPrima').modal('hide');
                }
            },
            error: function(response) {
                mensaje(response.responseText, 'error');
            }
        }).done(function(data) {
            location.reload();
        });

    });

    function mostrarReq() {
        var Articulos = '';
        $.ajax({
            url: '../getRequisados',
            type: 'get',
            dataType: 'json',
            success: function(response) {
                $.each(response, function(index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    Articulos += '<option  value="' + value.ID + '">' + value.NOMBRE + '</option>'

                });
                $('#requisadoE').empty().append(Articulos);
            }
        });
        $('#requisadoE').change(function() {
            $('#msg').text('Selected Item: ' + this.options[this.selectedIndex].value);
        });
        //var tipo_req = $('#requisadoE').val();


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

    function getRequisadoMPBynumOrden(numOrden, id_articulo) {
        var i = 0;
        $("#tbodyJR").empty();
        $.ajax({
            type: 'get',
            url: '../getRequisadosMP/' + numOrden + '/' + id_articulo,
            dataType: "json",
            data: {},
            success: function(data) {

                console.log(data);
                if (data == 0) {
                    const HTML = `
                        <tr>
                            <th>LEVANTAMIENTO DE PISO INCIAL</th>
                            <td id="1"></td></tr>
                        <tr>
                            <th>REQUISADO</th>
                        <td id="2"></td>
                        </tr>
                        <tr>
                            <th>LEVANTAMIENTO DE PISO FINAL</th>
                            <td id="3"></td>
                        </tr>
                        <tr>
                            <th>MERMA</th>
                            <td id="4"></td>
                        </tr>
                    `;
                    $("#tbodyJR").append(HTML);
                } else {
                    data.forEach(element => {
                        if (element.tipo == 1) { // LP INICIAL
                        }
                        if (element.tipo == 2) { // REQUISADO
                        }
                        if (element.tipo == 3) { // LP FINAL
                        }
                        if (element.tipo == 4) { // MERMA
                        }
                        const HTML = `
                        <tr>
                            <th>LEVANTAMIENTO DE PISO INCIAL</th>
                            <td id="1">` + element.cantidad + `</td>
                        </tr>
                    `;
                        $("#tbodyJR").append(HTML);
                    });
                    console.log('no es nulo');
                }
            },
            error: function(response) {
                mensaje(response.responseText, 'error');
            }
        });
    }
</script>