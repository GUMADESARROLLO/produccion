<script type="text/javascript">
    var dtMPD;
    var dtQM;
    var indicador_1 = 0;

    /******** Cargar funcion al inicio del DOM ************/
    $(document).ready(function() {
        $(function() {
            $('.datetimepicker_').datetimepicker({
                format: 'LT'
            });
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
            "columnDefs": [{
                "targets": [0],
                "className": "dt-center",
                "visible": false
            }]
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

    $('#numOrden').on('change', function() {
        $('#tbody-mp tr').each(function(i) {
            $(this).addClass('selected');
            dtMPD.row('.selected').remove().draw(false);
            //$(this).remove();
        });
        $('#tbody-qm tr').each(function(i) {
            $(this).addClass('selected');
            dtQM.row('.selected').remove().draw(false);
        });
    });
    /****** Fibras - Añadir o remover filas ******/
    $('#dtMPD tbody').on('click', 'tr', function(e) {
        e.preventDefault();
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            dtMPD.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
        $('#tbody-mp tr td').children().each(function(i) {
            $(this).on('keypress', function(e) {
                soloNumeros(e.keyCode, e, $(this).val());
            });
        });
    });

    /****** Quimicos - Añadir o remover filas ******/
    $('#dtQM tbody').on('click', 'tr', function(e) {
        e.preventDefault();
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            dtQM.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
        $('#tbody-qm tr td').children().each(function(i) {
            $(this).on('keypress', function(e) {
                soloNumeros(e.keyCode, e, $(this).val());
            });
        });
    });

    /********** Fibras - Eliminar registro de la bd ***********/
    $(document).on('click', '#quitRowdtBATH', function() {
        var numOrden = $("#numOrden").val();
        var select_row = dtMPD.row(".selected").data();
        indexData = select_row[0];
        console.log(indexData);
        $.ajax({
            url: "../eliminar-mp",
            data: {
                id: indexData,
            },
            type: 'post',
            async: true,
            success: function(resultado) {
                mensaje('Se elimino con exito la fila :)', 'success')
            }
        }).done(function(data) {
            dtMPD.row('.selected').remove().draw(false);
        });
    });

    /********** Quimicos - Eliminar registro de la bd ***********/
    $(document).on('click', '#quitRowdtBATHQ', function() {
        var numOrden = $("#numOrden").val();
        var select_rowq = dtQM.row(".selected").data();
        indexData = select_rowq[0];
        console.log(indexData);
        $.ajax({
            url: "../eliminar-qm",
            data: {
                id: indexData,
            },
            type: 'post',
            async: true,
            success: function(resultado) {
                mensaje('Se elimino con exito la fila :)', 'success')
            }
        }).done(function(data) {
            dtQM.row('.selected').remove().draw(false);
        });
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

    /********** Guardar datos de orden de produccion ***********/
    $(document).on('click', '#btnguardar', function(e) {
        /*var table_qm = $('#dtQM').DataTable();
        var form_data_qm  = table_qm.rows().data().toArray();
        $.each( form_data_qm, function( key, item ) {
            var id_txt = $(item[3]).attr('id')
            var xd = $("#" + id_txt).val();

            console.log(xd);
        });*/
        e.preventDefault();
        //codigo = $('#numOrden').val();
        if (validarForm(e) !== true) {
            return false
        } else {
            $("#formdataord").submit();
        }
    });
    /********** Guardar datos de orden de produccion ***********/

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

        /********** Ajax de Quimicos ***********/
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
                location.reload();
            });
        } else {
            //console.log('El arreglo esta vacio :(');
            return mensaje('Los datos en quimicos estan vacios :(', 'error');
        }
        /********** Ajax de Quimicos ***********/
    });

    /********** Guardar informacion de quimicos ***********/

    /********** funciones extras para validacion ***********/
    function soloNumeros(caracter, e, numeroVal) {
        var numero = numeroVal;
        if (String.fromCharCode(caracter) === "." && numero.length === 0) {
            e.preventDefault();
            mensaje('No puedes iniciar con un punto', 'warning');
        } else if (numero.includes(".") && String.fromCharCode(caracter) === ".") {
            e.preventDefault();
            mensaje('No puede haber mas de dos puntos', 'warning');
        } else {
            const soloNumeros = new RegExp("^[0-9]+$");
            if (!soloNumeros.test(String.fromCharCode(caracter)) && !(String.fromCharCode(caracter) === ".")) {
                e.preventDefault();
                mensaje('No se pueden escribir letras, solo se permiten datos númericos', 'warning');
            }
        }
    }

    $('#hrsTrabajadas').on('keypress', function(e) {
        soloNumeros(e.keyCode, e, $('#hrsTrabajadas').val());
    });

    function validarForm(e) {
        e.preventDefault();
        var codigo = $('#numOrden').val();
        var fecha1 = $("#fecha01").val();
        var fecha2 = $("#fecha02").val();
        var horaInicio = $("#hora01").val();
        var horaFin = $("#hora02").val();
        var horasT = $("#hrsTrabajadas").val();
        var last_row = dtMPD.row(":last").data();
        var last_rowq = dtQM.row(":last").data();

        /*if (typeof (last_row) === "undefined") {
            //e.preventDefault();
            mensaje("Ingrese al menos un registro en la tabla de Materia Prima Directa", "error");
            return false;

        } else if (typeof (last_rowq) === "undefined") {
            //e.preventDefault();
            mensaje("Ingrese al menos un registro en la tabla de Quimicos directos", "error");
            return false;

        } else */

        if (fecha1 === '') {
            //e.preventDefault();
            mensaje("Debe ingresar una fecha inicial para la orden", "error");
            return false;

        } else if (fecha2 === '') {
            //e.preventDefault();
            mensaje("Debe ingresar una fecha final para la orden", "error");
            return false;

        } else if (horaInicio === '') {
            //e.preventDefault();
            mensaje("Debe ingresar una hora inicial para la orden", "error");
            return false;

        } else if (horaFin === '') {
            //e.preventDefault();
            mensaje("Debe ingresar una hora final para la orden", "error");
            return false;
        } else if (horasT === '') {
            mensaje("Debe ingresar una horas trabajadas de la orden", "error");
            return false;
        } 
        else if (codigo === '') {
            //e.preventDefault();
            mensaje("Debe ingresar un numero de orden", "error");
            return false;
        }
        return true;
    }
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
                console.log('Fuck no funciono');
            }
        });
    });
    /*$(document).on('load', function(e) {
    });*/
    /********** funciones extras para validacion ***********/
</script>