<script type="text/javascript">
    /** OCULTAR TABLAS */
    var dtQuimicos;
    var dtFibras;

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
            }, ],
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
        e.preventDefault();
        $("#formdatareq").submit();


       //let id_requisa = $('#codigo_req').val();
        let id_requisa = $('#codigo_req').val();
        let numOrden = $('#numOrden').val();
        let jefe_turno = $('#jefe_turno').val();
       let id_turno = $('#id_turno').val();
       let id_tipo = $('#id_tipo').val();
       let arrayRequisa = [];
      // let arrayDRequisa = [];
       arrayRequisa[0]={
           id_requisa: id_requisa,
           numOrden: numOrden,
           jefe_turno: jefe_turno,
           id_turno: id_turno,
           id_tipo: id_tipo
       }

        let i = 0;
        //let typeOfReq = $('input:radio[name="flexRadioDefault"]');
        let arrayDRequisa = [];
        //let id_tipo = $('#id_tipo').val();
        console.log(id_tipo);
        alert(typeof(id_tipo));

        if (id_tipo == 1)
        {
            $("#tblFibras tbody tr").each(function() {
                let cantidad = $(this).closest("tr").find('input[name="cantidad"]').val();
                let elemento_id = $(this).closest("tr").find('td:eq(0)').text();
                console.log('This is the table fibra');
                console.log(cantidad);
                e.preventDefault();
                //let type = 1;
                if (cantidad !== "undefined" && cantidad !== "")
                {
                    arrayDRequisa[i] = {
                        numOrden: numOrden,
                        requisa_id: id_requisa,
                        elemento_id: elemento_id,
                        cantidad: cantidad,
                        tipo: id_tipo
                    };
                    i++;
                } else
                    {
                        mensaje("Por favor Ingrese la cantidad requisada", 'error');
                    }
            });
            //console.log(arrayDRequisa);
           alert(arrayDRequisa);
           alert(arrayRequisa);

            if (arrayDRequisa.length > 0)
            {
                $.ajax({
                    url: "../../guardarDetalleReq",
                    data: {
                        dataDR: arrayDRequisa,
                        dataR: arrayRequisa
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
            } else
                {
                    return mensaje('No existen datos en la requisa:(', 'error');
                }
        }
        else {
            $("#tblQuimicos tbody tr").each(function() {
                console.log('This is the table Quimico');

                let cantidad = $(this).closest("tr").find('input[name="cantidad"]').val();
                let elemento_id = $(this).closest("tr").find('td:eq(0)').text();
                alert(cantidad);
                //let type = 1;
                if (cantidad !== "undefined" && cantidad !== "") {
                    //  console.log(idFibra);
                    //  console.log(cantidad);
                    arrayDRequisa[i] = {
                        requisa_id: id_requisa,
                        elemento_id: elemento_id,
                        cantidad: cantidad,
                    };
                    i++;
                } else {
                    mensaje("Por favor Ingrese la cantidad requisada", 'error');
                }
            });

            //console.log(arrayDRequisa);

            if (arrayDRequisa.length > 0) {
                $.ajax({
                    url: "../../guardarDetalleReq",
                    data: {
                        dataDR: arrayDRequisa,
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

                });
                //console.log('El arreglo esta vacio :(');
            } else {
                return mensaje('No existen datos en la requisa:(', 'error');
            }
        }
    });

    //Actualizar los datos del detalle de las requisas

    var dtReqQuimicos;
    var dtReqFibras;

    //CARGAR TABLAS DE LOS DETALLES DE REQUISAS
    dtReqFibras = $("#tblReqFibras").DataTable({
        responsive: true,
        "destroy": true,

        // "autoWidth": false,
        "ajax": {
            "url": "../../getFibreReq",
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
        }, ],
    });

    $("#tblReqFibras_filter").hide();
    $("#tblReqFibras_length").hide();
    $('#SearchReqFib').on('keyup', function() {
        var table = $('#tblReqFibras').DataTable();
        table.search(this.value).draw();
    });

</script>
