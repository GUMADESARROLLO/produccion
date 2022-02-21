<script type="text/javascript">
    /** OCULTAR TABLAS */
    let dtQuimicos;
    let dtFibras;
    $('#cont_quimico').hide();
    $('#cont_fibra').hide();

    $(document).on('change', '#id_tipo', function() {
        let tipo_ = $(this).val();
        //alert (tipo_);
        if (tipo_ == 1) {
            $('#title_material_fb').text('LISTA DE FIBRAS');
            $('#tblQuimicos').empty();
            $('#tblFibras').empty();
            $('#cont_quimico').hide();
            $('#cont_fibra').hide();
            getFibra();
            $('#tblFibras > thead').addClass('bg-info text-white');
        } else if (tipo_ == 2) {
            $('#title_material').text('LISTA DE QUIMICOS');
            $('#tblQuimicos').empty();
            $('#tblFibras').empty();
            $('#cont_quimico').hide();
            $('#cont_fibra').hide();
            getQuimicos();
            $('#tblQuimicos > thead').addClass('bg-info text-white');
        } else {
            $('#cont_quimico').hide();
            $('#cont_fibra').hide();
        }
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

            "columns": [
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
                    "data": "idQuimico",
                    "render": function(data, type, row) {
                        return '<input type="text" class="form-control" onkeypress="validarNum(event, this, true)"  name="' + data + '" id="cantidad">';
                    }
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
                    sNext: '   Siguiente    ',
                    sPrevious: '   Anterior ',
                    sFirst: '   Primero   ',
                    sLast: '   Ultimo   ',
                },
                "lengthMenu": "MOSTRAR _MENU_",
                "emptyTable": "NO HAY DATOS DISPONIBLES",
                "search": "BUSCAR"
            },

            "columns": [
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
                    "data": "idFibra",
                    "render": function(data, type, row) {
                        return '<input type="text" class="form-control" onkeypress="validarNum(event, this, true)" name="' + data + '" id="cantidad">';
                    }
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

    $(document).on('click', '#btnGuardarDR', function(e) {
        let row, data, dataf, id, cantidad, elemento_id, i = 0;
        let id_requisa = $('#codigo_req').val(),
            numOrden = $('#numOrden').val(),
            jefe_turno = $('#jefe_turno').val(),
            id_turno = $('#id_turno').val(),
            id_tipo = $('#id_tipo').val();
        let dataDR = [];
        var base_url = window.location.origin + '/' + window.location.pathname.split('/')[1] + '/';
        var url_ = base_url + 'requisas';
        if (id_requisa == '') {
            mensaje('Por favor ingrese el codigo de la requisa', 'error');
            return false;
        };
        if (id_tipo == 1) { //FIBRA
            data = dtFibras.$('input').serializeArray();
            $.each(data, function(ind, elem) {
                dtFibras.rows().eq(0).each(function(index) {
                    row = dtFibras.row(index);
                    dataf = row.data();
                    id = dataf['idFibra'];
                    nombre = dataf['descripcion'];
                    if (elem.name == id) {
                        if (elem.value != '') {
                            if (elem.value <= 0) {
                                alert('La cantidad no puede ser 0');
                                return false;
                            }
                            if (elem.value > 0) {
                                dataDR[i] = {
                                    numOrden: numOrden,
                                    requisa_id: id_requisa,
                                    elemento_id: id,
                                    cantidad: elem.value,
                                    tipo: id_tipo
                                }
                                i++;
                            }
                        }
                    }
                });
            });
            if (dataDR.length > 0) {
                $.ajax({
                    url: "../../guardarDetalleReq",
                    data: {
                        dataDR: dataDR,
                        numOrden: numOrden,
                        codigo_req: id_requisa,
                        jefe_turno: jefe_turno,
                        id_turno: id_turno,
                        tipo: id_tipo
                    },
                    type: 'post',
                    async: true,
                    success: function(response) {
                        if(response){
                            mensaje('No se guardo con exito :(, es una requisa duplicada, por favor elija otra', 'warning');
                        } else{
                            mensaje('Datos guardados', 'success');
                            setTimeout(function() {
                                location.href = url_;
                            }, 3000);
                        }
                    },
                    error: function(response) {
                        mensaje(response, 'error');
                    }
                }).done(function(data) {});
            } else {
                mensaje('No existen datos en la requisa:(', 'error');
            }
            e.preventDefault();

        } else if (id_tipo == 2) { //TIPO 2 : QUIMICOS
            data = dtQuimicos.$('input').serializeArray();
            $.each(data, function(ind, elem) {
                dtQuimicos.rows().eq(0).each(function(index) {
                    row = dtQuimicos.row(index);
                    dataf = row.data();
                    id = dataf['idQuimico'];
                    nombre = dataf['descripcion'];
                    if (elem.name == id) {
                        if (elem.value != '') {
                            if (elem.value <= 0) {
                                alert('La cantidad no puede ser 0');
                                return false;
                            }
                            dataDR[i] = {
                                numOrden: numOrden,
                                requisa_id: id_requisa,
                                elemento_id: id,
                                cantidad: elem.value,
                                tipo: id_tipo
                            }
                            i++;
                        }
                    }
                });
            });
            if (dataDR.length > 0) {
                $.ajax({
                    url: "../../guardarDetalleReq",
                    data: {
                        dataDR: dataDR,
                        numOrden: numOrden,
                        codigo_req: id_requisa,
                        jefe_turno: jefe_turno,
                        id_turno: id_turno,
                        tipo: id_tipo
                    },
                    type: 'post',
                    async: true,
                    success: function(response) {
                        if(response){
                            mensaje('No se guardo con exito :(, es una requisa duplicada, por favor elija otra', 'warning');
                        } else{
                            mensaje('Datos guardados', 'success');
                            setTimeout(function() {
                                location.href = url_;
                            }, 3000);
                        }
                    },
                    error: function(response) {
                        mensaje(response, 'error');
                    }
                }).done(function(data) {});
            } else {
                mensaje('No existen datos en la requisa:(', 'error');
            }
            e.preventDefault();
        } else {
            mensaje('Seleccione un tipo de Requisa', 'error');
            return false;
        }

    });

    //Actualizar los datos del detalle de las requisas

    let tblDetalleReq, cod_requisa, numOrden, tipo_requisa;

    cod_requisa = $('#codigo_req').val();
    numOrden = $('#numOrden').val();
    tipo_requisa = $('select[name="tipo_requisa"]').val();
    tipo_requisa == 1 ? $('#title_Req').text("Lista de fibras") : $('#title_Req').text("Lista de Quimicos");

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

        "columns": [
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
                    if (elem.value <= 0) {
                        alert('La cantidad no puede ser 0');
                        return false;
                    }
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
            success: function(response) {
                if(response){
                    mensaje('Actualizado Correctamente' + response, 'success');
                }
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
            return event.preventDefault();
        return true;
    }
</script>
