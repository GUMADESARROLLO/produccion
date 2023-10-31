<script type="text/javascript">
    var dtMPD, dtQM, dtProduccion;
    var indicador_1 = 0;

    /******** Cargar funcion al inicio del DOM ************/
    $(document).ready(function() {
        $(function() {
            $('.datetimepicker_').datetimepicker({
                format: 'LT'
            });
        });

        dtProduccion = $('#tblOrder_produccion').DataTable({ // Costos por ORDEN
            "ajax": {
                "url": "getOrder_produccion",
                'dataSrc': '',
            },
            "order": [
                [0, "desc"]
            ],
            "destroy": true,
            "bPaginate": true,
            "info": false,
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
                    "title": "NO. ORDEN",
                    "data": "numOrden"
                },
                {
                    "title": "PRODUCTO",
                    "data": "producto"
                },
                {
                    "title": "FECHA INICIO",
                    "data": "fechaInicio",
                },
                {
                    "title": "FECHA FINAL",
                    "data": "fechaFinal"
                },
                {
                    "title": "PROD.REAL(kg)",
                    "data": "prod_real"
                },
                {
                    "title": "PROD.TOTAL(kg)",
                    "data": "prod_total"
                },
                {
                    "title": "ESTADO",
                    "data": "estado",
                    "render": function(data, type, row) {
                        if (data) {
                            return '<span class = "badge badge-success"> Activo </span>'
                        } else {
                            return '<span class = "badge badge-danger" > Inactivo </span>'
                        }
                    }
                },
                {
                    "title": "OPCIONES",
                    "data": "numOrden",
                    "render": function(data, type, row) {
                        return  '<a href="orden-produccion/reporte/' + data + '" title="Agregar datos al reporte"><i class="far fa-calendar-plus text-c-red  f-30 m-r-10"></i></a>' +
                                '<a href="orden-produccion/editar/' + data + '" title="Editar datos"><i class="feather icon-edit text-c-purple f-30 m-r-10"></i></a>' +
                                '<a href="orden-produccion/detalle/' + data + '" title="Ver reporte"><i class="feather icon-eye text-c-black f-30 m-r-10"></i></a>';
                    }
                },
            ],
            "columnDefs": [{
                    "targets": [0],
                    "className": "dt-center",
                }
            ]
        });

        $("#tblOrder_produccion_filter").hide();
        $("#tblOrder_produccion_length").hide();
        $('#cont_search').show();
        $('#InputBuscar').on('keyup', function() {
            var table = $('#tblOrder_produccion').DataTable();
            table.search(this.value).draw();
        });

        /****** Fibras - Agregar filas ******/
        dtMPD = $('#dtMPD').DataTable({
            "destroy": true,
            "ordering": false,
            "info": false,
            "bPaginate": false,
            "bfilter": false,
            "searching": false,
            "language": {
                "emptyTable": `<p class="text-center">Agrega una fibra</p>`
            },
           
        });

        /****** Quimicos - Agregar filas ******/
        dtQM = $('#dtQM').DataTable({
            "destroy": true,
            "ordering": false,
            "info": false,
            "bPaginate": false,
            "bfilter": false,
            "searching": false,
            "language": {
                "emptyTable": `<p class="text-center">Agrega un Quimico</p>`
            },
            "columnDefs": [{
                "targets": [0],
                "className": "dt-center",
                "visible": false
            }]
        });
        inicializaControlFecha();
    });

    

    /********** Fibras - Obtener lista de maquinas y fibras ***********/
    $(document).on('click', '.add-row-dt-mp', function() {
        var numOrden = $("#numOrden").val();

        var option1 = '';
        var option2 = '';
        var last_row = dtMPD.row(":last").data();
        var numF = '';
        console.log(last_row);
        console.log(Object.values(typeof(last_row)));
        if (typeof(last_row) === "undefined") {
            indicador_1 = 1;
        } else if (typeof(last_row) === Object) {
            indicador_1 = $('#num_mp').val() + 1;
        } else {
            indicador_1 = parseInt(last_row[0]) + 1
        }
        $.getJSON("../data-mp", function(json) {
            $.each(json['dataFibras'], function(i, item) {
                option1 += `<option value='` + item['idFibra'] + `'>` + item['descripcion'] +
                    `</option>`
            })

            $.each(json['dataMaquinas'], function(i, item) {
                option2 += `<option value='` + item['idMaquina'] + `'>` + item['nombre'] +
                    `</option>`
            })
            dtMPD.row.add([
                indicador_1,
                `<select class="mb-3 form-control " id="maquinaf-prev-` + indicador_1 + `">` +
                option2 + `</select>`,
                `<select class="mb-3 form-control" id="fibras-prev-` + indicador_1 + `">` +
                option1 + `</select>`,
                `<input required="required" class="input-dt" type="text"  placeholder="Cantidad" id="cantidadf-prev-` +
                indicador_1 + `" onpaste="return false">`,
            ]).draw(false);
        })
    });

    /********** Quimicos - Obtener lista de maquinas y quimicos ***********/
    $(document).on('click', '.add-row-dt-qm', function() {
        var numOrden = $("#numOrden").val();
        var option1q = '';
        var option2q = '';
        var last_rowq = dtQM.row(":last").data();

        if (typeof(last_rowq) === "undefined") {
            indicador_1 = 1;
        } else {
            indicador_1 = parseInt(last_rowq[0]) + 1
        }
        $.getJSON("../data-qm", function(json) {
            $.each(json['dataQuimicos'], function(i, item) {
                option1q += `<option value='` + item['idQuimico'] + `'>` + item['descripcion'] +
                    `</option>`
            })

            $.each(json['dataMaquinas'], function(i, item) {
                option2q += `<option value='` + item['idMaquina'] + `'>` + item['nombre'] +
                    `</option>`
            })
            dtQM.row.add([
                indicador_1,
                `<select class="mb-3 form-control " id="maquinaq-prev-` + indicador_1 + `">` +
                option2q + `</select>`,
                `<select class="mb-3 form-control" id="quimicos-prev-` + indicador_1 + `">` +
                option1q + `</select>`,
                `<input required="required" class="input-dt qm-cant" type="text"  placeholder="Cantidad" id="cantidadq-prev-` +
                indicador_1 + `" onpaste="return false">`,
            ]).draw(false);
        })
    });



    /********** Guardar informacion de fibras ***********/
    $(document).on('click', '#btnGFibras', function(e) {
        e.preventDefault();
        var codigo = $('#numOrden').val();
        //alert(codigo);
        var i = 0;
        /********** variables de Fibras ***********/
        //var last_row = dtMPD.row(":last").data();
        var arrayf = [];
        var array2f = [];
        var array3f = [];
        /********** variables de Fibras ***********/
        /********** Fibras ***********/
        dtMPD.rows().eq(0).each(function(index) {
            var rowf = dtMPD.row(index);
            var dataf = rowf.data();
            var posf = dataf[0];
            console.log(posf);
            var idf = posf;
            var maquinaf = ($('#maquinaf-prev-' + posf + ' option:selected').val() === "") ? 0 : $(
                '#maquinaf-prev-' + posf + ' option:selected').val();
            var fibra = ($('#fibras-prev-' + posf + ' option:selected').val() === "") ? 0 : $(
                '#fibras-prev-' + posf + ' option:selected').val();
            var cantidadf = ($('#cantidadf-prev-' + posf).val() === "") ? 0 : $('#cantidadf-prev-' +
                posf).val();

            $('#cantidadf-prev-').on('keypress', function(e) {
                soloNumeros(e.keyCode, e, $('#cantidadf-prev-').val());
            });
            arrayf[i] = {
                id: idf,
                orden: codigo,
                maquina: maquinaf,
                fibra: fibra,
                cantidad: cantidadf
            };
            //console.log(posf);
            i++;
        });


        console.log(arrayf);
        /********** Fibras ***********/
        /********** Ajax de Fibras ***********/
        if (arrayf.length > 0) {
            console.log('El arreglo no va vacio :D');
            $.ajax({
                url: "../guardarmp-directa",
                data: {
                    data: arrayf,
                    codigo: codigo
                },
                type: 'post',
                async: true,
                success: function(response) {
                    //console.log('Exito en guardar fibras');
                    //alert(response);
                    if (response == 1) {
                        mensaje("Ingrese materias primas por favor ", 'error');
                    } else if (response == 2) {
                        mensaje("No se guardo con exito :(, ya existe esta materia prima, por favor elija otra ", 'error');
                    } else if (response == false) {
                        mensaje(response.responseText, 'error');
                    } else {
                        mensaje(response.responseText, 'success');
                    }
                },
                error: function(response) {
                    mensaje(response.responseText, 'error');
                }
            }).done(function(data) {
                // location.reload();
            });
            //console.log('El arreglo esta vacio :(');

        } else {
            return mensaje('Los datos en materia prima estan vacios :(', 'error');
        }
        /********** Ajax de Fibras ***********/
    });
    /********** Guardar informacion de fibras ***********/

    /********** Guardar informacion de quimicos ***********/
    $(document).on('click', '#btnGQuimicos', function(e) {

        e.preventDefault();
        var codigo = $('#numOrden').val();
        var i = 0;
        /********** variables de Quimicos ***********/
        //var last_rowq = dtQM.row(":last").data();
        var arrayq = [];
        var array2q = [];
        var array3q = [];
        /********** variables de Quimicos ***********/
        /********** Quimicos ***********/
        dtQM.rows().eq(0).each(function(index) {
            var rowq = dtQM.row(index);
            var dataq = rowq.data();
            var posq = dataq[0];
            console.log(posq);
            var idq = posq;
            var maquinaq = ($('#maquinaq-prev-' + posq + ' option:selected').val() === "") ? 0 : $(
                '#maquinaq-prev-' + posq + ' option:selected').val();
            var quimico = ($('#quimicos-prev-' + posq + ' option:selected').val() === "") ? 0 : $(
                '#quimicos-prev-' + posq + ' option:selected').val();
            var cantidadq = ($('#cantidadq-prev-' + posq).val() === "") ? 0 : $('#cantidadq-prev-' +
                posq).val();

            $('#cantidadq-prev-').on('keypress', function(e) {
                soloNumeros(e.keyCode, e, $('#cantidadq-prev-').val());
            });

            arrayq[i] = {
                id: idq,
                orden: codigo,
                maquina: maquinaq,
                quimico: quimico,
                cantidad: cantidadq
            };
            //arrayq[i] = { maquina: maquinaq, quimico: quimico, cantidad: cantidadq };
            i++;
        });

        console.log(arrayq);
        /********** Quimicos ***********/
        /********** Ajax de Quimicos ***********/

        if (arrayq.length > 0) {
            console.log('El arreglo no va vacio :D');
            $.ajax({
                url: "../guardarqm-directa",
                data: {
                    data: arrayq,
                    codigo: codigo
                },
                type: 'post',
                async: true,
                success: function(response) {
                    //console.log('Exito en guardar quimicos');
                    mensaje(response.responseText, 'success');

                },
                error: function(response) {
                    //console.log("error en ajax de Quimicos");
                    mensaje(response.responseText, 'error');
                }
            }).done(function(data) {
                //location.reload();
            });
        } else {
            //console.log('El arreglo esta vacio :(');
            return mensaje('Los datos en quimicos estan vacios :(', 'error');
        }
        /********** Ajax de Quimicos ***********/
    });
    /********** Guardar informacion de quimicos ***********/







    /*********** Cargar registros en datatable**************/
    $(window).on("load", function() {
        var numOrden = $('#numOrden').val();
        dtMPD.clear().draw();
        dtQM.clear().draw();
        $.ajax({
            url: "../getData/" + numOrden,
            type: 'GET',
            dataType: "json",
            data: {},
            // async: true,
            success: function(data) {
                data.forEach(element => {
                    if (element.idFibra != null) {
                        var option1 = '';
                        var option2 = '';
                        option1 += `<option value='` + element.idFibra + `'>` + element.nombreFibra + `</option>`
                        option2 += `<option value='` + element.idMaquina + `'>` + element.nombreMaquina + `</option>`
                        dtMPD.row.add([
                            element.id, `<select disabled class="mb-3 form-control " id="maquinaf-prev-` + element.id + `">` + option2 + `</select>`,
                            `<select disabled class="mb-3 form-control" id="fibras-prev-` + element.id + `">` + option1 + `</select>`,
                            `<input required="required" class="input-dt" type="text"  placeholder="Cantidad" id="cantidadf-prev-` +
                            element.id + `" onpaste="return false" value="` + element.cantidad + `" >`,
                        ]).draw(false);
                    }
                    if (element.idQuimico != null) {
                        var option1q = '';
                        var option2q = '';
                        option1q += `<option value='` + element.idQuimico + `'>` + element.nombreQuimico + `</option>`
                        option2q += `<option value='` + element.idMaquina + `'>` + element.nombreMaquina + `</option>`
                        dtQM.row.add([
                            element.id,
                            `<select disabled class="mb-3 form-control " id="maquinaq-prev-` + element.id + `">` + option2q + `</select>`,
                            `<select disabled class="mb-3 form-control" id="quimicos-prev-` + element.id + `">` + option1q + `</select>`,
                            `<input required="required" class="input-dt qm-cant" type="text"  placeholder="Cantidad" id="cantidadq-prev-` +
                            element.id + `" onpaste="return false" value="` + element.cantidad + `" >`,
                        ]).draw(false);
                    }
                });
            },
            error: function(data) {

            }
        });
    });
    /*$(document).on('load', function(e) {
    });*/
    /********** funciones extras para validacion ***********/
</script>
