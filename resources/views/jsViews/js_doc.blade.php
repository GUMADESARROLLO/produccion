<script type="text/javascript">
    var dtConversion;

    $(document).ready(function () {

        let id_orden = $("#id_num_orden").text()

        $('#tbl_search_producto').on('keyup', function () {
            var table = $('#tblProductos').DataTable();
            table.search(this.value).draw();
        });

        $('#tbl_search_materia_prima').on('keyup', function () {
            var table = $('#tblMateriaPrima').DataTable();
            table.search(this.value).draw();
        });

        $.getJSON("../jsonInfoOrder/" + id_orden, function (json) {
            $.each(json, function (i, item) {

                switch (item['tipo'])
                {

                    case 'dtaOrden':
                        $("#id_peso_porcent").text(item['data'].peso_procent)
                        $("#id_fecha_inicial").text(item['data'].fecha_inicio)
                        $("#id_hora_inicial").text(item['data'].hora_inicio)
                        $("#id_fecha_final").text(item['data'].fecha_final)
                        $("#id_hora_final").text(item['data'].hora_final);
                        $("#id_hrs_trabajadas").text(item['data'].hrs_trabajadas);
                        $("#id_total_bultos_und").text(item['data'].total_bultos_und);
                        break;

                    case 'dtaMateria':
                        var table_materia = $('#tblMateriaPrima').DataTable({
                            "data": item['data'],
                            "destroy": true,
                            "info": false,
                            "lengthMenu": [[100, -1], [100, "Todo"]],
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
                            'columns': [
                                {"title": "ARTICULO", "data": "ARTICULO"},
                                {"title": "DESCRIPCION", "data": "DESCRIPCION_CORTA"},
                                {"title": "REQUISA", "data": "REQUISA"},
                                {"title": "PISO", "data": "PISO"},
                                {"title": "PESO %", "data": "PERSO_PORCENT"},
                                {"title": "MERMA", "data": "MERMA"},
                                {"title": "MERMA %", "data": "MERMA_PORCENT"},
                            ],
                            "columnDefs": [
                                {"className": "dt-center", "targets": []},
                                {"className": "dt-right", "targets": [2, 3, 4, 5, 6]},
                                {"visible": false, "searchable": false, "targets": []},
                                {"width": "10%", "targets": [2, 3, 4, 5, 6]},
                                {"width": "15%", "targets": [2]},
                            ],
                        });

                        $("#tblMateriaPrima_length").hide();
                        $("#tblMateriaPrima_filter").hide();
                        $('#tblMateriaPrima tbody').on('click', "tr", function () {
                            mostrarReq();
                            //var data = table_materia.row(this).data();
                            /*var row = table_materia.row(this).data();
                            var listaD = Object.values(row);
                            var index = listaD.findIndex(mp => mp.id ==1)
                            row =row[index];*/
                            var data = table_materia.row(this).data();
                            var id_articulo = data['ID_ARTICULO'];
                            var num_orden = $('#id_num_orden').text();
                            var elemento = document.getElementById("id_elemento").value = id_articulo;

                            console.log(data);
                            console.log(num_orden);
                            console.log(id_articulo);
                            if (id_articulo == 13){
                                $('#mdlMatPrima').modal('show');
                                $('#cantidad').val('');
                                //clearFields();
                            }

                        });
                        break;

                    case 'dtaProducto':
                        let table_producto = $('#tblProductos').DataTable({
                            "data": item['data'],
                            "destroy": true,
                            "info": false,
                            "lengthMenu": [[100, -1], [100, "Todo"]],
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
                            'columns': [
                                {"title": "ARTICULO", "data": "ARTICULO"},
                                {"title": "DESCRIPCION", "data": "DESCRIPCION_CORTA"},
                                {"title": "BULTO", "data": "BULTO"},
                                {"title": "PESO %", "data": "PERSO_PORCENT"},
                                {"title": "KG", "data": "KG"},

                            ],
                            "columnDefs": [
                                {"className": "dt-center", "targets": []},
                                {"className": "dt-right", "targets": [2, 3, 4]},
                                {"visible": false, "searchable": false, "targets": []},
                                {"width": "10%", "targets": []},
                                {"width": "15%", "targets": []},
                            ],
                            "footerCallback": function (row, data, start, end, display) {
                                var api = this.api();
                                var intVal = function (i) {
                                    return typeof i === 'string' ?
                                        i.replace(/[^0-9.]/g, '') * 1 :
                                        typeof i === 'number' ?
                                            i : 0;
                                };
                                Total = api.column(4).data().reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                                $('#id_jr_total').text(numeral(Total).format('0,0.00'));
                            }
                        });

                        $("#tblProductos_length").hide();
                        $("#tblProductos_filter").hide();
                        $('#tblProductos tbody').on('click', "tr", function () {

                            var data = table_producto.row(this).data();
                            Swal.fire({
                                title: data.DESCRIPCION_CORTA,
                                text: "Ingrese la cantidad de Bultos",
                                input: 'text',
                                inputAttributes: {
                                    autocapitalize: 'off'
                                },
                                showCancelButton: true,
                                confirmButtonText: 'Guardar',
                                showLoaderOnConfirm: true,
                                preConfirm: (login) => {
                                    return fetch(`//api.github.com/users/${login}`)
                                        .then(response => {
                                            if (!response.ok) {
                                                throw new Error(response.statusText)
                                            }
                                            return response.json()
                                        })
                                        .catch(error => {
                                            Swal.showValidationMessage(
                                                `Request failed: ${error}`
                                            )
                                        })
                                },
                                allowOutsideClick: () => !Swal.isLoading()
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire({
                                        title: `${result.value.login}'s avatar`,
                                        imageUrl: result.value.avatar_url
                                    })
                                }
                            })
                        });
                        break;

                    default:
                        console.log('Lo lamentamos, por el momento no disponemos de ');
                }
            });
        });

        inicializaControlFecha();
        // $('#tblConversion > thead').addClass('bg-primary text-white');
    });

    $('#btnAdd').on('click', function () {

    });

    $('#btnSave').on('click', function () {
        let numOrden = $('#num_orden').val(),
            tipo = $('#requisadoE').val(),
            cantidad = $('#cantidad').val(),
            id_elemento = $('#id_elemento').val();

        console.log(numOrden);
        console.log(tipo);
        console.log(cantidad);
        console.log(id_elemento);
        $.ajax({
            url: "../guardarMatP",
            data: {
                num_orden: numOrden,
                tipo : tipo,
                cantidad: cantidad,
                id_elemento: id_elemento
            },
            type: 'post',
            async: true,
            success: function (response) {
                if (response == 1) {
                    mensaje('Orden duplicada, por favor verifique el N°. Orden', 'warning');
                } else {
                    mensaje(response.responseText, 'success');
                    $('#mdlMatPrima').modal('hide');
                }
            },
            error: function (response) {
                mensaje(response.responseText, 'error');
            }
        }).done(function (data) {
            //location.reload();
        });

    });

    function clearFields() {
        $('#fecha_inicial').val('');
        $('#num_orden').val('');
        $('#hora_inicial').val('');
        $('#id_select_producto').val('');

    }

    function mostrarReq(){
        var Articulos = '';
        $.ajax({
            url: '../getRequisados',
            type: 'get',
            dataType: 'json',
            success: function(response){
                console.log(response);
                $.each(response, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    Articulos += '<option  value="' + value.ID + '">' + value.NOMBRE + '</option>'

                });
                $('#requisadoE').empty().append(Articulos);
            }
        });
        $('#requisadoE').change(function () {
            $('#msg').text('Selected Item: ' + this.options[this.selectedIndex].value);
        });
        //var tipo_req = $('#requisadoE').val();


    }
</script>
