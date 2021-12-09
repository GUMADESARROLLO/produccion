<script type="text/javascript">
    var dtMPD;
    var dtQM;
    var indicador_1 = 0;

    /******** Cargar funcion al inicio del DOM ************/
    $(document).ready(function () {
        $(function () {
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

    /****** Fibras - Añadir o remover filas ******/
    $('#dtMPD tbody').on('click', 'tr', function (e) {
        e.preventDefault();
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            dtMPD.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
        $('#tbody-mp tr td').children().each(function (i) {
            $(this).on('keypress', function (e) {
                soloNumeros(e.keyCode, e, $(this).val());
            });
        });
    });

    /****** Quimicos - Añadir o remover filas ******/
    $('#dtQM tbody').on('click', 'tr', function (e) {
        e.preventDefault();
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            dtQM.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
        $('#tbody-qm tr td').children().each(function (i) {
            $(this).on('keypress', function (e) {
                soloNumeros(e.keyCode, e, $(this).val());
            });
        });
    });

    /********** Fibras - Eliminar registro de la bd ***********/
    $(document).on('click', '#quitRowdtBATH', function () {
        var numOrden = $("#numOrden").val();
        var select_row = dtMPD.row(".selected").data();
        $('#tbody-mp tr').each(function (i) {
            //    console.log($(this))
            if ($(this).hasClass('selected')) {
                // console.log($(this))
                id = $(this).children().first();
                var id_selected = id.val();
                console.log(id_selected);
                $.ajax({
                    url: "../eliminar-mp",
                    data: {
                        id: id_selected,
                    },
                    type: 'post',
                    async: true,
                    success: function (resultado) {
                    }
                }).done(function (data) {
                    alert('La materia prima ha sido eliminada');
                });
            } else {
                console.log('Esta clase no esta seleccionada');
            }
        });

        indexData = select_row[0];
        dtMPD.row('.selected').remove().draw(false);
    });

    /********** Quimicos - Eliminar registro de la bd ***********/
    $(document).on('click', '#quitRowdtBATHQ', function () {
        var numOrden = $("#numOrden").val();
        var select_rowq = dtQM.row(".selected").data();
        $('#tbody-qm tr').each(function (i) {
            if ($(this).hasClass('selected')) {
                // console.log($(this))
                id = $(this).children().first();
                var id_selected = id.val();
                console.log(id_selected);
                $.ajax({
                    url: "../eliminar-qm",
                    data: {
                        id: id_selected,
                    },
                    type: 'post',
                    async: true,
                    success: function (resultado) {
                    }
                }).done(function (data) {
                    alert('El quimico ha sido eliminado');
                });
            } else {
                console.log('Esta clase no esta seleccionada');
            }
        });

        indexData = select_rowq[0];
        dtQM.row('.selected').remove().draw(false);
    });

    /********** Fibras - Obtener lista de maquinas y fibras ***********/
    $(document).on('click', '.add-row-dt-mp', function () {
        var numOrden = $("#numOrden").val();
        var option1 = '';
        var option2 = '';
        var last_row = dtMPD.row(":last").data();

        if (typeof (last_row) === "undefined") {
            indicador_1 = 1;
        } else {
            indicador_1 = parseInt(last_row[0]) + 1
        }
        $.getJSON("../data-mp", function (json) {
            $.each(json['dataFibras'], function (i, item) {
                option1 += `<option value='` + item['idFibra'] + `'>` + item['descripcion'] + `</option>`
            })

            $.each(json['dataMaquinas'], function (i, item) {
                option2 += `<option value='` + item['idMaquina'] + `'>` + item['nombre'] + `</option>`
            })
            dtMPD.row.add([
                indicador_1,
                `<select class="mb-3 form-control " id="maquinaf-prev` + indicador_1 + `">` + option2 + `</select>`,
                `<select class="mb-3 form-control" id="fibras-` + indicador_1 + `">` + option1 + `</select>`,
                `<input required="required" class="input-dt" type="text"  placeholder="Cantidad" id="cantidadf-prev-` + indicador_1 + `" onpaste="return false">`,
            ]).draw(false);
        })
    });

    /********** Quimicos - Obtener lista de maquinas y quimicos ***********/
    $(document).on('click', '.add-row-dt-qm', function () {
        var numOrden = $("#numOrden").val();
        var option1q = '';
        var option2q = '';
        var last_rowq = dtQM.row(":last").data();

        if (typeof (last_rowq) === "undefined") {
            indicador_1 = 1;
        } else {
            indicador_1 = parseInt(last_rowq[0]) + 1
        }
        $.getJSON("../data-qm", function (json) {
            $.each(json['dataQuimicos'], function (i, item) {
                option1q += `<option value='` + item['idQuimico'] + `'>` + item['descripcion'] + `</option>`
            })

            $.each(json['dataMaquinas'], function (i, item) {
                option2q += `<option value='` + item['idMaquina'] + `'>` + item['nombre'] + `</option>`
            })
            dtQM.row.add([
                indicador_1,
                `<select class="mb-3 form-control " id="maquinaq-` + indicador_1 + `">` + option2q + `</select>`,
                `<select class="mb-3 form-control" id="quimicos-` + indicador_1 + `">` + option1q + `</select>`,
                `<input required="required" class="input-dt qm-cant" type="text"  placeholder="Cantidad" id="cantidadq-prev-` + indicador_1 + `" onpaste="return false">`,
            ]).draw(false);
        })
    });

    /********** Enviar informacion de fibras y quimicos ***********/
    $(document).on('click', '#btnguardar', function (e) {


        /*var table_qm = $('#dtQM').DataTable();
        var form_data_qm  = table_qm.rows().data().toArray();
        $.each( form_data_qm, function( key, item ) {
            var id_txt = $(item[3]).attr('id')
            var xd = $("#" + id_txt).val();

            console.log(xd);
        });*/


        e.preventDefault();
        codigo = $('#numOrden').val();
        var i = 0;
        /********** variables de Fibras ***********/
        //var last_row = dtMPD.row(":last").data();
        var arrayf = [];
        var array2f = [];
        var array3f =[];
        /********** variables de Fibras ***********/
        /********** variables de Quimicos ***********/
        //var last_rowq = dtQM.row(":last").data();
        var arrayq = [];
        var array2q = [];
        var array3q =[];
        /********** variables de Quimicos ***********/

        if (validarForm(e) !== true) {
            return false
        }
        else
        {
            /********** Fibras ***********/
            dtMPD.rows().eq(0).each(function (index)
            {
                var rowf = dtMPD.row(index);
                var dataf = rowf.data();
                var posf = dataf[0];

                var maquinaf = ($('#maquinaf-prev' + posf + ' option:selected').val() === "") ? 0 : $('#maquinaf-prev' + posf + ' option:selected').val();
                var fibra = ($('#fibras-' + posf + ' option:selected').val() === "") ? 0 : $('#fibras-' + posf + ' option:selected').val();
                //var cantidadf = ($('#cantidadf-prev-' + posf).val() == "") ? 0 : $('#cantidadf-prev-' + posf).val();

                $('#cantidadf-prev-').on('keypress', function (e) {
                    soloNumeros(e.keyCode, e, $('#cantidadq-prev-').val());
                });
                var cantidadf = $('#cantidadf-prev-' + posf).val();
                if (cantidadf === '')
                {
                    mensaje("La cantidad no puede estar vacia en la tabla de Materias Primas", "error");
                    return false;
                }
                /*if (parseFloat(cantidadf) > 0) {
                    parseFloat(cantidadf)
                } else {
                    mensaje("La cantidad de materia prima debe ser mayor a 0");
                    return false;
                }*/
                arrayf[i] = {orden: codigo, maquina: maquinaf, fibra: fibra, cantidad: cantidadf};
                console.log(arrayf)
                i++;
            });
            $('#tbody-mp tr td').children().each(function (i)
            {
                var item = $(this).val();
                console.log(item);
                var maquinaf = "";
                var fibra = "";
                var cantidadf = "";
                //console.log(i);
                if (item !== "" && item != null)
                {
                    codigo = $('#numOrden').val();
                    maquinaf = $('#maquinaf-prev-' + i).val();
                    fibra = $('#fibras-prev-' + i).val();
                    cantidadf = $('#cantidadf-prev-' + i).val();
                    if (maquinaf === "" && fibra === "" && cantidadf === "")
                    {
                        return false;
                    }else {
                        array2f[i] = {
                            orden: codigo,
                            maquina: maquinaf,
                            fibra: fibra,
                            cantidad: cantidadf
                        };
                    }
                }
            });
            console.log(array2f);
            array3f = array2f.filter(function (dato) {
                return dato.maquina !== undefined
            });
            console.log(array3f);
            array3f.forEach(element => {
                arrayf.push(element);
            });
            console.log(arrayf);
            //array4 =  array.push(array3);
            /********** Fibras ***********/
            //}
            /********** Quimicos ***********/
            dtQM.rows().eq(0).each(function (index) {
                var rowq = dtQM.row(index);
                var dataq = rowq.data();
                var posq = dataq[0];

                var maquinaq = ($('#maquinaq-' + posq + ' option:selected').val() === "") ? 0 : $('#maquinaq-' + posq + ' option:selected').val();
                var quimico = ($('#quimicos-' + posq + ' option:selected').val() === "") ? 0 : $('#quimicos-' + posq + ' option:selected').val();
                //var cantidadq = ($('#cantidadq-prev-' + posq).val() == "") ? 0 : $('#cantidadq-prev-' + posq).val();

                $('#cantidadq-prev-').on('keypress', function (e) {
                    soloNumeros(e.keyCode, e, $('#cantidadq-prev-').val());
                });

                var cantidadq = $('#cantidadq-prev-' + i).val();
                if (cantidadq === '') {
                    mensaje("Debe ingresar la cantidad en la tabla de Quimicos", "error");
                    return false;
                }
                /*if (parseFloat(cantidadq) > 0) {
                    parseFloat(cantidadq)
                } else {
                    mensaje("la cantidad de quimico debe ser mayor a 0");
                    return false;
                }*/
                arrayq[i] = { orden: codigo, maquina: maquinaq, quimico: quimico, cantidad: cantidadq };
                i++;
            });
            $('#tbody-qm tr td').children().each(function(i) {
                var item = $(this).val();
                var maquinaq = "";
                var quimico = "";
                var cantidadq = "";
                //console.log(i);
                if (item !== "" && item != null) {
                    codigo = $('#numOrden').val();
                    maquinaq = $('#maquinaq-prev-' + i).val();
                    quimico = $('#quimicos-prev-' + i).val();
                    cantidadq = $('#cantidadq-prev-' + i).val();
                    if (maquinaq !== "" && quimico !== "" && cantidadq !== "") {
                        array2q[i] = {
                            orden: codigo,
                            maquina: maquinaq,
                            quimico: quimico,
                            cantidad: cantidadq
                        };
                    }
                }
            });
            console.log(array2q);
            array3q = array2q.filter(function (dato) {
                return dato.maquina !== undefined
            });
            console.log(array3q);
            array3q.forEach(element => {
                arrayq.push(element);
            });
            console.log(arrayq);
            /********** Quimicos ***********/
            /********** Ajax de Fibras ***********/
            $.ajax({
                url: "../guardarmp-directa",
                data: {
                    data: arrayf,
                    codigo: codigo
                },
                type: 'post',
                async: true,
                success: function (resultado) {
                    mensaje('Exito en guardar fibras', 'success');
                },
                error: function() {
                    mensaje("error en ajax de Fibras 1", "error");
                }
            });
            /********** Ajax de Fibras ***********/
            /********** Ajax de Quimicos ***********/
            $.ajax({
                url: "../guardarqm-directa",
                data: {
                    data: arrayq,
                    codigo: codigo
                },
                type: 'post',
                async: true,
                success: function (resultado) {
                    mensaje('Exito en guardar quimicos', 'success');
                },
                error: function() {
                    mensaje("error en ajax de Quimicos 1", "error");
                }
            }).done(function (data) {
                $("#formdataord").submit();

            });
            /********** Ajax de Quimicos ***********/

        }
    });

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

    $('#hrsTrabajadas').on('keypress', function (e) {
        soloNumeros(e.keyCode, e, $('#hrsTrabajadas').val());
    });

    function validarForm(e) {
        e.preventDefault();
        var fecha1 = $("#fecha01").val();
        var fecha2 = $("#fecha02").val();
        var horaInicio = $("#hora01").val();
        var horaFin = $("#hora02").val();
        var horasT = $("#hrsTrabajadas").val();
        var last_row = dtMPD.row(":last").data();
        var last_rowq = dtQM.row(":last").data();

        if (typeof (last_row) === "undefined") {
            //e.preventDefault();
            mensaje("Ingrese al menos un registro en la tabla de Materia Prima Directa", "error");
            return false;

        } else if (typeof (last_rowq) === "undefined") {
            //e.preventDefault();
            mensaje("Ingrese al menos un registro en la tabla de Quimicos directos", "error");
            return false;

        } else if (fecha1 === '') {
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
            //e.preventDefault();
            mensaje("Debe ingresar una horas trabajadas de la orden", "error");
            return false;
        }
        return true;
    }
    /********** funciones extras para validacion ***********/

</script>
