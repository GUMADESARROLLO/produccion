<script type="text/javascript">
    /** OCULTAR TABLAS */
    let dtQuimicos;
    let dtFibras;

    $('#cont_quimico').hide();
    $('#cont_fibra').hide();

    $(document).on('click', '#Quimico', function() {
        $('#title_material').text('LISTA DE QUIMICOS');
        $('#tblQuimicos').empty();
        $('#tblFibras').empty();
        $('#cont_quimico').hide();
        $('#cont_fibra').hide();
        getQuimicos();
        $('#tblQuimicos > thead').addClass('bg-info text-white');

    });

    $(document).on('click', '#Fibra', function() {
        $('#title_material_fb').text('LISTA DE FIBRAS');
        $('#tblQuimicos').empty();
        $('#tblFibras').empty();
        $('#cont_quimico').hide();
        $('#cont_fibra').hide();
        getFibra();
        $('#tblFibras > thead').addClass('bg-info text-white');


    });

    function getQuimicos() {
        dtQuimicos = $("#tblQuimicos").DataTable({
            responsive: true,
            // "autoWidth": false,
            "ajax": {
                "url": "../../getQuimicos",
                'dataSrc': '',
            },
            "info": false,
            "destroy": true,
            "pagingType": "full",
            "language": {
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "zeroRecords": "No hay coincidencias",
                "loadingRecords": "Cargando datos...",
                oPaginate: {
                    sNext: '<i class="fas fa-angle-right fa-2x mx-2 text-info"></i>',
                    sPrevious: '<i class="fas fa-angle-left fa-2x mx-2 text-info"></i>',
                    sFirst: '<i class="fas fa-angle-double-left fa-2x mx-2 text-info"></i>',
                    sLast: '<i class="fas fa-angle-double-right fa-2x mx-2 text-info"></i>',
                },
                "lengthMenu": "MOSTRAR _MENU_",
                "emptyTable": "NO HAY DATOS DISPONIBLES",
                "search": "BUSCAR"
            },

            "columns": [{
                    "title": "N°",
                    "data": "idQuimico"
                },
                {
                    "title": "CODIDO",
                    "data": "codigo"
                },
                {
                    "title": "DESCRIPCIÓN DEL ARTICULO",
                    "data": "descripcion"
                },
                {
                    "title": "UND/MEDIDA",
                    "data": "unidad"
                },
                {
                    "title": "CANTIDAD",
                    "defaultContent": "<input type='text' class='form-control' id='cantidad' name='cantidad'>"
                },
            ],
            "columnDefs": [{
                "className": "dt-center",
                "targets": [2, 3]
            }, ],
        });

        $("#tblQuimicos_filter").hide();
        $("#tblQuimicos_length").hide();
        $('#cont_quimico').show();
        $('#InputBuscar').on('keyup', function() {
            var table = $('#tblQuimicos').DataTable();
            table.search(this.value).draw();
        });
        $('#tblQuimicos_paginate');
    }

    function getFibra() {
        dtFibras = $("#tblFibras").DataTable({
            responsive: true,
            "destroy": true,

            // "autoWidth": false,
            "ajax": {
                "url": "../../fibra-data",
                'dataSrc': '',
            },
            "info": false,

            "pagingType": "full",
            "language": {
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "zeroRecords": "No hay coincidencias",
                "loadingRecords": "Cargando datos...",
                oPaginate: {
                    sNext: '<i class="fas fa-angle-right fa-2x mx-2 text-info"></i>',
                    sPrevious: '<i class="fas fa-angle-left fa-2x mx-2 text-info"></i>',
                    sFirst: '<i class="fas fa-angle-double-left fa-2x mx-2 text-info"></i>',
                    sLast: '<i class="fas fa-angle-double-right fa-2x mx-2 text-info"></i>',
                },
                "lengthMenu": "MOSTRAR _MENU_",
                "emptyTable": "NO HAY DATOS DISPONIBLES",
                "search": "BUSCAR"
            },

            "columns": [{
                    "title": "N°",
                    "data": "idFibra"
                },
                {
                    "title": "CODIDO",
                    "data": "codigo"
                },
                {
                    "title": "DESCRIPCIÓN DEL ARTICULO",
                    "data": "descripcion"
                },
                {
                    "title": "UND/MEDIDA",
                    "data": "unidad"
                },
                {
                    "title": "CANTIDAD",
                    "defaultContent": "<input type='text' class='form-control'  id='cantidad' name='cantidad'>"
                },
            ],
            "columnDefs": [{
                "className": "dt-center",
                "targets": [2, 3]
            }],
        });

        $("#tblFibras_filter").hide();
        $("#tblFibras_length").hide();
        $('#cont_fibra').show();
        $('#InputBuscarFibras').on('keyup', function() {
            var table = $('#tblFibras').DataTable();
            table.search(this.value).draw();
        });
    }

    $(document).on('click', '#btnGuardarDR', function() {
        let id_requisa = $('#codigo_req').val();
        let numOrden = $('#numOrden').val();
        //  console.log($(dtFibras).DataTable().rows( { filter : 'applied'} ).nodes());

        //Recorrer data table
        dtFibras.rows().eq(0).each(function(index) {
            var rowf = dtFibras.row(index);
            var dataf = rowf.data();
            //var posf = dataf['cantidad'];
            console.log(dataf);
            // var idf = posf;
        });

        let arrayRequisa = [];
        let i = 0;
        let typeOfReq = $('input:radio[name="flexRadioDefault"]');

        if (typeOfReq.is(':checked')) {
            let tipo = $('input:radio[name=flexRadioDefault]:checked').val();
            // if (typeOfReq.val() == 1) {
            console.log(tipo);
            if (tipo == 1) {
                $("#tblFibras tbody tr").each(function() {
                    let cantidad = $(this).closest("tr").find('input[name="cantidad"]').val();
                    let elemento_id = $(this).closest("tr").find('td:eq(0)').text();

                    console.log('This is the table fibra');
                    //let type = 1;
                    if (cantidad != "undefined" && cantidad != "") {
                        arrayRequisa[i] = {
                            numOrden: numOrden,
                            requisa_id: id_requisa,
                            elemento_id: elemento_id,
                            cantidad: cantidad,
                            tipo: tipo
                        };
                        i++;
                    } else {
                        mensaje("Por favor Ingrese la cantidad requisada", 'error');
                    }
                });
                console.log(arrayRequisa);
                if (arrayRequisa.length > 0) {
                    $.ajax({
                        url: "../../guardarDetalleReq",
                        data: {
                            data: arrayRequisa,
                        },
                        type: 'post',
                        async: true,
                        success: function(response) {
                            mensaje(response, 'success')
                        },
                        error: function(response) {
                            mensaje(response, 'error');
                        }
                    }).done(function(data) {
                        // location.reload();
                    });
                    //console.log('El arreglo esta vacio :(');
                } else {
                    return mensaje('No existen datos en la requisa:(', 'error');
                }
            } else {
                $("#tblQuimicos tbody tr").each(function() {
                    console.log('This is the table Quimico');

                    let cantidad = $(this).closest("tr").find('input[name="cantidad"]').val();
                    let elemento_id = $(this).closest("tr").find('td:eq(0)').text();

                    //let type = 1;


                    if (cantidad != "undefined" && cantidad != "") {
                        //  console.log(idFibra);   
                        //  console.log(cantidad);
                        arrayRequisa[i] = {
                            numOrden: numOrden,
                            requisa_id: id_requisa,
                            elemento_id: elemento_id,
                            cantidad: cantidad,
                            tipo: tipo
                        };
                        i++;
                    } else {
                        mensaje("Por favor Ingrese la cantidad requisada", 'error');
                    }
                });



                console.log(arrayRequisa);

                if (arrayRequisa.length > 0) {
                    $.ajax({
                        url: "../../guardarDetalleReq",
                        data: {
                            data: arrayRequisa,
                        },
                        type: 'post',
                        async: true,
                        success: function(response) {
                            mensaje('Los datos han sido ingresados correctamente', 'success');
                        },
                        error: function(response) {
                            mensaje('Ha ocurrido un error intentelo nuevamente', 'error');
                        }
                    }).done(function(data) {
                        // location.reload();
                    });
                    //console.log('El arreglo esta vacio :(');
                } else {
                    return mensaje('No existen datos en la requisa:(', 'error');
                }
            }



        } else {
            mensaje("No ha seleccionado el tipo de requisa");
        }


    });

    //Actualizar los datos del detalle de las requisas 

    let tblDetalleReq, cod_requisa, numOrden, tipo_requisa;

    cod_requisa = $('#codigo_req').val();
    numOrden = $('#numOrden').val();
    tipo_requisa = $('select[name="tipo_requisa"]').val();
    if (tipo_requisa == 1) {
        $('#title_Req').text("Lista de fibras");
    } else {
        $('#title_Req').text("Lista de Quimicos");
    }
    //CARGAR DETALLE DE LAS REQUISAS
    tblDetalleReq = $("#tblDetalleReq").DataTable({
        responsive: true,
        "destroy": true,

        // "autoWidth": false,
        "ajax": {
            "url": "../../getDetalleReq/" + cod_requisa + '/' + tipo_requisa,
            'dataSrc': '',
        },
        "info": false,

        "pagingType": "full",
        "language": {
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "zeroRecords": "No hay coincidencias",
            "loadingRecords": "Cargando datos...",
            oPaginate: {
                sNext: '<i class="fas fa-angle-right fa-2x mx-2 text-info"></i>',
                sPrevious: '<i class="fas fa-angle-left fa-2x mx-2 text-info"></i>',
                sFirst: '<i class="fas fa-angle-double-left fa-2x mx-2 text-info"></i>',
                sLast: '<i class="fas fa-angle-double-right fa-2x mx-2 text-info"></i>',
            },
            "lengthMenu": "MOSTRAR _MENU_",
            "emptyTable": "NO HAY DATOS DISPONIBLES",
            "search": "BUSCAR"
        },

        "columns": [{
                "title": "id",
                "data": "id"
            },
            {
                "title": "N°",
                "data": "numero"
            },
            {
                "title": "CODIDO",
                "data": "codigo"
            },
            {
                "title": "DESCRIPCIÓN DEL ARTICULO",
                "data": "descripcion"
            },
            {
                "title": "UND/MEDIDA",
                "data": "unidad"
            },
            {
                "title": "CANTIDAD",
                "data": "cantidad"
            },
        ],
        "columnDefs": [{
            "className": "dt-center",
            "targets": [2, 3]
        }, {
            "targets": [0],
            "visible": false,
            "searchable": true
        }],
    });

    $("#tblDetalleReq_filter").hide();
    $("#tblDetalleReq_length").hide();
    $('#SearchReq').on('keyup', function() {
        var table = $('#tblDetalleReq').DataTable();
        table.search(this.value).draw();
    });

    //ACTUALIZAR DETALLES DE LAS REQUISAS

    $('#btnActualizar').on('click', function(e) {

        var arrayDRFormat = [];
        var data = tblDetalleReq.$('input').serializeArray();
        let numOrden, cod_req, jefe_turno, turno, cantidad, i = 0,
            row, id, tipo_requisa, tipo, elemento_id, id_req;

        let dataDR = [],
            dataR = [];

        numOrden = $('#numOrden').val();
        cod_req = $('#codigo_req').val();
        jefe_turno = $('#jefe_turno').val();
        turno = $('#id_turno').val();
        tipo_requisa = $('#tipo_requisa').val();
        id_req = $('#id_req').val();

        console.log(tipo_requisa);
        $.each(data, function(ind, elem) {
            tblDetalleReq.rows().eq(0).each(function(index) {
                row = tblDetalleReq.row(index);
                data = row.data();
                id = data['id'];
                cantidad = data['cantidad'];
                elemento_id = data['elemento_id'];

                if (elem.name == id) {
                    dataDR[i] = {
                        id: id,
                        requisa_id: cod_req,
                        elemento_id: elemento_id,
                        cantidad: elem.value
                    }
                    i++;
                }

            });
        });
        //alert(tipo);
        //     alert(dataDR[0]['id']);
        $.ajax({
            url: "../../updateRequisas",
            type: 'post',
            dataType: "json",
            data: {
                numOrden: numOrden,
                codigo_req: cod_req,
                jefe_turno: jefe_turno,
                turno: turno,
                tipo: tipo_requisa,
                id_req: id_req,
                arrayDR: dataDR,
            },
            success: function(data) {
                mensaje(data.responseText, 'success');
                // 
            },
            error: function(data) {
                //console.log('Fuck no funciono');
            }
        });

        e.preventDefault();

    });
    /********** funciones extras para validacion ***********/
    function validarNum(event, element, _float) {
        event = event || window.event;
        var charCode = event.which || event.keyCode;
        if (charCode == 8 || charCode == 13 || (_float ? (element.value.indexOf('.') == -1 ? charCode == 46 : false) : even.preventDefault()))
            return true;
        else if ((charCode < 48) || (charCode > 57))
            return  event.preventDefault();
        return true;
    }

</script>